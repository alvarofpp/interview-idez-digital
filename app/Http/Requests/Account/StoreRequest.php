<?php

namespace App\Http\Requests\Account;

use App\Models\AccountType;
use App\Rules\CheckUserAccountType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreRequest extends FormRequest
{
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
            'bank_branch' => ['required', 'string', 'min:4', 'max:6',],
            'number' => ['required', 'string', 'min:5', 'max:6',],
            'digit' => ['required', 'string', 'size:1',],
            'account_type_id' => ['required', 'exists:account_types,id', new CheckUserAccountType(),],
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
        if ($this->all()['account_type_id'] == AccountType::TYPE_COMPANY) {
            $validator->addRules([
                'cnpj' => ['required', 'string', 'size:14', 'cnpj', 'unique:companies',],
                'company_name' => ['required', 'string', 'min:1', 'max:255',],
                'trading_name' => ['required', 'string', 'min:1', 'max:255',],
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
        $data = $this->request->all();
        $keys = ['bank_branch', 'number',];

        if ($data['account_type_id'] == AccountType::TYPE_COMPANY) {
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
