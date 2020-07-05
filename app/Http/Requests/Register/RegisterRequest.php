<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:255',],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users',],
            'cpf' => ['required', 'string', 'cpf', 'unique:users',],
            'telephone' => ['required', 'string', 'min:8', 'max:14',],
            'password' => ['required', 'string', 'min:8', 'confirmed',],
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
