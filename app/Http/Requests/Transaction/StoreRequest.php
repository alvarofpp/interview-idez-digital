<?php

namespace App\Http\Requests\Transaction;

use Alvarofpp\ExpandRequest\Traits\UrlParameters;
use App\Rules\SessionUserAccount;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    use UrlParameters;

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
            'value' => ['required', 'numeric',],
            'transaction_type_id' => ['required', 'exists:transaction_types,id',],
            'account_to_id' => ['required', 'exists:accounts,id',],
            'account' => ['required', 'exists:accounts,id', new SessionUserAccount()],
        ];
    }
}
