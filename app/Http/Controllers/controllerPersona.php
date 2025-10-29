<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class controllerPersona extends Controller
{
    //
    public function index()
    {
        $preguntas = \DB::connection('bd2')
            ->table('public.tb_preguntas_seg')
            ->select('id_preguntaseg', 'sdescripcion')
            ->where('benabled', 'true')
            ->get();
        $tipo_discapacidad = \DB::connection('bd2')
            ->table('public.tb_tipo_discapacidad')
            ->select('id_tdiscapacidad', 'sdescripcion')
            ->where('benabled', 'true')
            ->get();

        return view('modulos.users.registro3', [
            'preguntas' => $preguntas,
            'tipo_discapacidad' => $tipo_discapacidad,
        ]);
    }
}
