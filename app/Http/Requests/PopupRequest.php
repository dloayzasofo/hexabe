<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PopupRequest extends FormRequest
{
    public function rules()
    {
        $ruleImage = 'image|mimes:jpeg,png,jpg,gif,webp|max:1025';
        if( isset($this->popup) == false ){
            $ruleImage = 'required|' . $ruleImage;
        }
        
        return [
            'image' => $ruleImage,
            'name'  => 'required'
        ];
    }

    public function messages()
    {
        return [
            'image'     => "El archivo debe ser de tipo imagen",
            'mimes'     => "El archivo debe ser de tipo imagen",
            'max'       => "El peso del archivo debe ser menor a 1MB",
            'required'  => "Este campo es requerido"
        ];
    }
}
