<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function rules()
    {
        $ruleImage = 'image|mimes:jpeg,png,jpg,gif,webp|max:1024';
        if( isset($this->team) == false ){
            $ruleImage = 'required|' . $ruleImage;
        }else{
            $ruleImage = 'nullable|' . $ruleImage;
        }

        return [
            'image' => $ruleImage,
            'name'  => 'required',
            'members' => ['required', 'array', 'min:1'],
        ];
    }

    public function messages()
    {
        return [
            'image'     => "El archivo debe ser de tipo imagen",
            'mimes'     => "El archivo debe ser de tipo imagen",
            'max'       => "El peso del archivo debe ser menor a 1MB",
            'required'  => "Este campo es requerido",
            'membersmin' => "El equipo debe tener al menos un miembro",
        ];
    }
}
