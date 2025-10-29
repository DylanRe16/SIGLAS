<?php

namespace App\Http\Controllers;

use App\Models\Preguntas;
use App\Models\PreguntaSeg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PreguntasController extends Controller
{
    public function edit()
    {
        $preguntaSeg_user = PreguntaSeg::where('id_persona', Auth::user()->id)->get();

        $preguntaSeg = Preguntas::where('benabled', true)->get();

        if ($preguntaSeg_user->isEmpty()) {
            session()->flash('warning', 'Aún no tienes preguntas de seguridad. Por favor, créalas para mayor protección..');
            return view('modulos.users.preguntas-seguridad', [
                'preguntaSeg' => $preguntaSeg,
                'preguntaSeg_user' => $preguntaSeg_user
            ]);
        }

        return view('modulos.users.preguntas-seguridad', [
            'preguntaSeg' => $preguntaSeg,
            'preguntaSeg_user' => $preguntaSeg_user,
        ]);
    }


    public function update(Request $request)
    {
        // Validar las respuestas y las preguntas seleccionadas
        $request->validate([
            'respuesta_1' => 'required|string|max:255',
            'respuesta_2' => 'required|string|max:255',
            'respuesta_3' => 'required|string|max:255',
            'pregunta_1' => 'required|exists:bd2.public.tb_preguntas_seg,id_preguntaseg|distinct',
            'pregunta_2' => 'required|exists:bd2.public.tb_preguntas_seg,id_preguntaseg|distinct',
            'pregunta_3' => 'required|exists:bd2.public.tb_preguntas_seg,id_preguntaseg|distinct',
        ], [], [
            'respuesta_1' => 'Respuesta 1',
            'respuesta_1' => 'Respuesta 2',
            'respuesta_1' => 'Respuesta 3',
            'pregunta_1' => 'Pregunta 1',
            'pregunta_2' => 'Pregunta 2',
            'pregunta_3' => 'Pregunta 3',
        ]);

        // Obtén los registros actuales del usuario
        $preguntasActuales = PreguntaSeg::where('id_persona', Auth::user()->id)->get()->values();
        // return $preguntasActuales;

        if ($preguntasActuales->isEmpty()) {
            $preguntas = [
                ['pregunta' => $request->pregunta_1, 'respuesta' => $request->respuesta_1],
                ['pregunta' => $request->pregunta_2, 'respuesta' => $request->respuesta_2],
                ['pregunta' => $request->pregunta_3, 'respuesta' => $request->respuesta_3],
            ];

            foreach ($preguntas as $pregunta) {
                PreguntaSeg::create([
                    'id_persona' => Auth::user()->id,
                    'id_preguntaseg' => $pregunta['pregunta'],
                    'srespuesta' => $pregunta['respuesta'],
                    'nusuario_creacion' => Auth::user()->ndocumento,
                ]);
            }
        } else {
            $preguntas = [
                ['pregunta' => $request->pregunta_1, 'respuesta' => $request->respuesta_1],
                ['pregunta' => $request->pregunta_2, 'respuesta' => $request->respuesta_2],
                ['pregunta' => $request->pregunta_3, 'respuesta' => $request->respuesta_3],
            ];

            // Recorre cada pregunta actual y actualiza con los nuevos datos
            foreach ($preguntasActuales as $i => $preguntaActual) {
                $preguntaNueva = $preguntas[$i];

                $preguntaActual->update([
                    'id_preguntaseg' => $preguntaNueva['pregunta'],
                    'srespuesta' => $preguntaNueva['respuesta'],
                    'nusuario_actualizacion' => Auth::user()->ndocumento,
                    'dfecha_actualizacion' => now(),
                ]);
            }
        }

        return redirect()->route('preguntaSeg-edit')->with('success', 'Preguntas de seguridad actualizadas exitosamente.');
    }
}
