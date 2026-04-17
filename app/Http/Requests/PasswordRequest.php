<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'password'  => 'required|confirmed|min:6',
            'password_confirmation'  => 'required|min:6'
        ];
    }

    public function messages()
    {
        return [
            'required'  => "Este campo es requerido",
            'min'       => "Debe contener al menos 6 caracteres",
            'confirmed' => "Debe coincidir con la confirmación de contraseña",
        ];
    }
}
