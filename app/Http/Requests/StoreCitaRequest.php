<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCitaRequest extends FormRequest
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
    public function rules(): array{
        $rules = [
            'srazon_social' => 'required|string|max:255',
            'sdireccion_fiscal' => 'required|string|max:500',
            'id_estado' => 'required|integer|exists:bd2.public.tb_estado,id_estado',
            'id_municipio' => 'required|integer|exists:bd2.public.tb_municipio,id_municipio',
            'id_parroquia' => 'required|integer|exists:bd2.public.tb_parroquia,id_parroquia',
            'id_sectoremp' => 'required|integer|exists:bd2.public.tb_sector_empleo,id_sectoremp',
            'tipo_solicitud' => 'required|integer|exists:bd2.public.tb_tipo_solicitud,id_tsolicitud',
            'bcargo_direccion' => 'required|boolean',
            'sult_cargo_desempenado' => 'nullable|string|max:255',
        ];

        // Si viene de la ruta cita-create2, el campo srif no es obligatorio
        if ($this->has('from_create2') && $this->from_create2 === 'true') {
            $rules['srif'] = 'nullable|string|max:20';
        } else {
            $rules['srif'] = 'required|string|max:20';
        }

        return $rules;
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
            'srif' => 'RIF',
            'srazon_social' => 'Razón social',
            'sdireccion_fiscal' => 'Dirección fiscal',
            'id_estado' => 'Estado',
            'id_municipio' => 'Municipio',
            'id_parroquia' => 'Parroquia',
            'id_sectoremp' => 'Sector',
            'solicitud' => 'Solicitud',
            'tipo_solicitud' => 'Tipo de solicitud',
            'bcargo_direccion' => 'Cargo de dirección',
            'sult_cargo_desempenado' => 'Cargo',
        ];
    }
}
