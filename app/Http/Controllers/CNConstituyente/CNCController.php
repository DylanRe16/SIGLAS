<?php

namespace App\Http\Controllers\CNConstituyente;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Persona;
use Exception;
use Illuminate\Http\Request;

class CNCController extends Controller{
    public function create(){
        $estados = Estado::where('nenabled', 1)->get();

        return view('modulos.cnconstituyente.registrar', compact('estados'));
    }

    public function getPerson(Request $request){

        try {

            // Validar los datos de entrada
            $request->validate([
                'snacionalidad' => 'required|in:V,E,P',
                'ndocumento' => 'required|numeric|digits_between:6,9',
            ], [], [
                'snacionalidad' => 'Tipo de Documento',
                'ndocumento' => 'Nro. de Documento',
            ]);

            $persona = Persona::where('ndocumento', $request->ndocumento)
                ->where('snacionalidad', $request->snacionalidad)
                ->first();
    
            if($persona) {
                return response()->json([
                    'success' => true,
                    'persona' => $persona
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Persona no encontrada'
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
        }
    }
}
