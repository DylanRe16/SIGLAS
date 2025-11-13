<?php

namespace App\Http\Controllers\CNConstituyente;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use App\Models\Minpptrassi\Public\Estado as PublicEstado;
use App\Models\Minpptrassi\Public\Municipio;
use App\Models\Minpptrassi\Public\Parroquia;
use App\Models\Minpptrassi\Rncpt\Empresa;
use App\Models\Minpptrassi\Rncpt\Miembros;
use App\Models\Saime;
use App\Models\Seniat;
use Exception;
use Illuminate\Http\Request;

class CNCController extends Controller{
    public function create(){
        $estados = PublicEstado::where('nenabled', 1)->get();
        $municipios = Municipio::where('nenabled', 1)->get();
        $parroquias = Parroquia::where('nenabled', 1)->get();
        
        return view('modulos.cnconstituyente.registrar', compact('estados', 'municipios', 'parroquias'));
    }

    public function report(){
        
        return view('modulos.cnconstituyente.reportes');
    }

    
    public function getCompany(Request $request){
        try {
            // return $request->all();
            // Validar los datos de entrada
            $request->validate([
                'srif' => [
                    'required',
                    'regex:/^[JGVEP]-?\d{9}$/i', // <-- Valida J, G, V, E o P seguidos de 9 números
                ],
                ], [], [
                    'srif' => 'RIF',
                ]);

            $company = Empresa::where('srif', $request->srif)
                ->first();

            if($company) {
                return response()->json([
                    'success' => true,
                    'company' => $company
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Empresa no encontrada'
                ]);
            }
            
        } catch (Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Error: ' . $e->getMessage()
                ]);
        }
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

            $persona = Miembros::where('ncedula', $request->ndocumento)
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


    public function store(Request $request){
        return redirect()->route('cnconstituyente-registrar')->with('success', 'Constituyente registrado exitosamente.');
    }
}
