<?php

namespace App\Http\Requests\Account;

use Alvarofpp\ExpandRequest\Traits\UrlParameters;
use App\Models\Account;
use App\Rules\SessionUserAccount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
{
    use UrlParameters;

    /**
     * @var \App\Models\Account
     */
    protected $account = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bank_branch' => ['string', 'min:4', 'max:6',],
            'number' => ['string', 'min:5', 'max:6',],
            'digit' => ['string', 'size:1',],
            'account' => ['required', 'exists:accounts,id', new SessionUserAccount()],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        if ($this->account->is_company) {
            $validator->addRules([
                'cnpj' => ['string', 'size:14', 'cnpj', 'unique:companies',],
                'company_name' => ['string', 'max:255',],
                'trading_name' => ['string', 'max:255',],
            ]);
        }
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $accountId = $this->route('account');
        $this->account = Account::findOrFail($accountId);
        $data = $this->request->all();
        $keys = ['bank_branch', 'number',];

        if ($this->account->is_company) {
            $keys = array_merge($keys, ['cnpj',]);
        }

        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $data[$key] = unmaskValue($data[$key]);
            }
        }

        $this->replace($data);
    }
}
