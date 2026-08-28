<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules()
    {
        
        return [
            'name'  => 'required',
            'date_ini'  => 'required|date|date_format:Y-m-d',
            'date_delivery'  => 'required|date|date_format:Y-m-d',
            'time_ini'  => 'required|date_format:H:i',
            'time_delivery'  => 'required|date_format:H:i',
            'brand'  => 'required|numeric',
            'user_assign'  => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [
            'image'     => "El archivo debe ser de tipo imagen",
            'mimes'     => "El archivo debe ser de tipo imagen",
            'max'       => "El peso del archivo debe ser menor a 1MB",
            'required'  => "Este campo es requerido",
            'date_format' => "El formato de la fecha no es valido"
        ];
    }
}
