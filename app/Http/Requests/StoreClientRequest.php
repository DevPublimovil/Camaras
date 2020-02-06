<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    protected $redirectRoute = 'trafico.index';
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
            'name' => 'required|max:255',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'email.required'  => 'El correo es requerido',
            'email.email' => 'El correo debe contener @',
            'email.unique' => 'El correo que ingreso ya esta en uso',
            'password.min' => 'La contraseña debe tener mas de 8 caracteres',
        ];
    }
}
