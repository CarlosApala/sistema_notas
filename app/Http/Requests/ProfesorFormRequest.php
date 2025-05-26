<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfesorFormRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nombre' => 'required|max:255',
            'cedula' => 'required|numeric',
            'direccion' => 'required|max:255',
            'celular' => 'required|numeric',
            'email' => 'required|email',
            'experiencia' => 'required|numeric',
            'fecha_contratacion' => 'required|date',
            
        ];
    }

    public function messages()
    {
        return [
        'nombre' => "El nombre es requerido",
        'cedula' => "El nombre es requerido",
        'direccion' => "El nombre es requerido",
        'celular' => "El nombre es requerido" ,
        'email' => "El nombre es requerido",           
        'experiencia' => "El nombre es requerido",
        'fecha_contratacion' => "El nombre es requerido", 
        
        ];
    }
}
