<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateRegistroRequest;
use App\Models\Persona;
use App\Models\Estado;
use App\Models\Municipio;
use App\Models\Parroquia;
use App\Models\Personales;
use App\Models\PersonaRol;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class DatoPersonalController extends Controller
{
    public function edit(){
        
        $user = Persona::find(Auth::user()->id_persona);
        
        
        $edad = $this->calcularEdad($user->dfecha_nacimiento);
        $estados = Estado::all();
        $municipios = Municipio::all();
        $parroquias = Parroquia::all();
        
        $cod_moviles = DB::connection('bd2')->table('tb_codigos_telefonicos')->where('btipo', true)->get();
        $cod_locales = DB::connection('bd2')->table('tb_codigos_telefonicos')->where('btipo', false)->get();
        $t_discapacidad = DB::connection('bd2')->table('tb_tipo_discapacidad')->get();

        
        return view('modulos.users.mis-datos', ['user' => $user, 
                                                'edad' => $edad, 
                                                't_discapacidad' => $t_discapacidad,  
                                                'cod_moviles' => $cod_moviles,
                                                'cod_locales' => $cod_locales,
                                                'estados' => $estados,
                                                'municipios' => $municipios,
                                                'parroquias' => $parroquias]);
    }


    public function update(UpdateRegistroRequest $request, Persona $user){

        /**
        * * CAMPOS QUE SE PUEDEN MODIFICAR
        * @param  smail
        * @param  bdiscapacidad 
        * @param id_tdiscapacidad
        * @param sdicapacidad_especifica
        * @param bcertificado_conapdis
        * @param nnum_certificado
        * @param ncodigo_telfmovil
        * @param nnumero_telfmovil
        * @param ncodigo_telflocal
        * @param nnumero_telflocal
        */

        // return $request->all();

        if(Auth::user()->ssexo == 'F'){
            $request->validate([
                'bembarazada' => 'required|boolean',
            ],[/* para mensajes personalizados */],[
                'bembarazada' => 'Embarazada',
            ]);
        }


        if($request->input('bdiscapacidad') == 1){
            $request->validate([
                'id_tdiscapacidad' => 'required|integer',
                'sdicapacidad_especifica' => 'required|string|max:255',
                'bcertificado_conapdis' => 'required|boolean',
            ],[/* para mensajes personalizados */],[
                'id_tdiscapacidad' => 'Tipo de discapacidad',
                'sdicapacidad_especifica' => 'Discapacidad especifica',
                'bcertificado_conapdis' => 'Certificado CONAPDIS',
            ]);
            if ($request->input('bcertificado_conapdis') == 1){
                $request->validate([
                    'nnum_certificado' => 'required|numeric|digits_between:6,10',
                ],[/* para mensajes personalizados */],[
                    'nnum_certificado' => 'número de certificado',
                ]);
            }

        }

        $user->update([
            'bembarazada' => $request->input('bembarazada'),
            'semail' => $request->input('semail'),
            'bdiscapacidad' => $request->input('bdiscapacidad'),
            'id_tdiscapacidad' => $request->input('id_tdiscapacidad'),
            'sdicapacidad_especifica' => $request->input('sdicapacidad_especifica'),
            'bcertificado_conapdis' => $request->input('bcertificado_conapdis'),
            'nnum_certificado' => $request->input('nnum_certificado'),
            'ncodigo_telfmovil' => $request->input('ncodigo_telfmovil'),
            'nnumero_telfmovil' => $request->input('nnumero_telfmovil'),
            'ncodigo_telflocal' => $request->input('ncodigo_telflocal'),
            'nnumero_telflocal' => $request->input('nnumero_telflocal')
        ]);

        

        if($user){
            return redirect()->back()->with('success', 'Datos actualizados correctamente.');
        }else{
            return redirect()->back()->with('error', 'Error al actualizar los datos.');
        }
    }

    private function calcularEdad($fechaNacimiento)
    {
        $fechaNacimiento = new \DateTime($fechaNacimiento);
        $hoy = new \DateTime();
        return $hoy->diff($fechaNacimiento)->y; // Retorna la edad en años
    }

}
