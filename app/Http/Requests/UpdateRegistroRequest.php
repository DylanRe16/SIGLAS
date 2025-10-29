<?php

namespace App\Http\Requests;

use App\Models\Persona;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistroRequest extends FormRequest
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
        return [
            'semail' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Persona::class.',semail,'.$this->route('user')->id_persona.',id_persona'],
            'bdiscapacidad' => 'required|boolean',
            'ncodigo_telfmovil' => 'required',
            'nnumero_telfmovil' => 'required|numeric|digits_between:7,10',
            'ncodigo_telflocal' => 'nullable',
            'nnumero_telflocal' => 'nullable|numeric|digits_between:7,10',
        ];
    }

    public function attributes(){
        return [
            'semail' => 'Correo electrónico',
            'bdiscapacidad' => 'Discapacidad',
            'id_tdiscapacidad' => 'Tipo de discapacidad',
            'sdicapacidad_especifica' => 'Discapacidad especifica',
            'bcertificado_conapdis' => 'Certificado CONAPDIS',
            'nnum_certificado' => 'Número de certificado',
            'ncodigo_telfmovil' => 'Código de teléfono móvil',
            'nnumero_telfmovil' => 'Número de teléfono móvil',
            'ncodigo_telflocal' => 'Código de teléfono local',
            'nnumero_telflocal' => 'Número de teléfono local',
        ];
    }
}
