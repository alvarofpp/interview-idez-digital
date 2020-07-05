<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->route('user') == Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['string', 'min:3', 'max:255',],
            'email' => ['string', 'email', 'max:255', 'unique:users',],
            'cpf' => ['string', 'cpf', 'unique:users',],
            'telephone' => ['string', 'min:8', 'max:14',],
            'password' => ['string', 'min:8', 'confirmed',],
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $data = $this->request->all();
        $keys = ['cpf', 'telephone',];

        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $data[$key] = unmaskValue($data[$key]);
            }
        }

        $this->replace($data);
    }
}
