<?php

namespace App\Http\Requests;

use App\Models\Persona;
use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'semail' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Persona::class],
            'bdiscapacidad' => 'required|boolean',
            'ncodigo_telfmovil' => 'required',
            'nnumero_telfmovil' => 'required|numeric|digits_between:7,10',
            'ncodigo_telflocal' => 'nullable',
            'nnumero_telflocal' => 'nullable|numeric|digits_between:7,10',
            'nnum_certificado' => 'nullable|numeric|digits_between:1,10',
            'pregunta_1' => 'required',
            'respuesta_1' => 'required|min:3|max:255',
            'pregunta_2' => 'required',
            'respuesta_2' => 'required|min:3|max:255',
            'pregunta_3' => 'required',
            'respuesta_3' => 'required|min:3|max:255',
        ];
    }

    // public function messages(){
    //     return [
    //         'title.required' => 'El campo :attribute es requerido',
    //         'title.min' => 'El campo :attribute debe tener al menos 5 caracteres',
    //         'title.max' => 'El campo :attribute debe tener maximo 255 caracteres',
    //         'slug.required' => 'El campo :attribute es requerido',
    //         'slug.unique' => 'El campo :attribute debe ser unico',   
    //         'content.required' => 'El campo :attribute es requerido',
    //         'category.required' => 'El campo :attribute es requerido',
    //     ];
    // }

    public function attributes(){
        return [
            'semail' => 'Correo electrónico',
            'bdiscapacidad' => 'Discapacidad',
            'ncodigo_telfmovil' => 'Código de teléfono móvil',
            'nnumero_telfmovil' => 'Número de teléfono móvil',
            'ncodigo_telflocal' => 'Código de teléfono local',
            'nnumero_telflocal' => 'Número de teléfono local',
            'pregunta_1' => 'Pregunta 1',
            'respuesta_1' => 'Respuesta 1',
            'pregunta_2' => 'Pregunta 2',
            'respuesta_2' => 'Respuesta 2',
            'pregunta_3' => 'Pregunta 3',
            'respuesta_3' => 'Respuesta 3',
        ];
    }
}
