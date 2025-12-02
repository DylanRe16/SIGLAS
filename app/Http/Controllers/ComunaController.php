<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Comunas;


use Illuminate\Http\Request;

class ComunaController extends Controller
{
    //
    public function comunas()
    {
        $comunas = Comunas::where('benabled', true)->get();
        return $comunas;
    }
    public function index()
    {
        $comunas = $this->comunas();
        return view('modulos.ccombatiente.mantenimiento.catalogos.comunas', compact('comunas'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'comuna' => 'required|string|max:255',
            ],
            [/* para mensajes personalizados */],
            [
                'comuna' => 'Nombre de la Comuna es obligatorio',
                'comuna.required' => 'El :attribute no puede estar vacío',
                'comuna.max' => 'El :attribute no puede superar los :max caracteres',
                'comuna.string' => 'El :attribute debe ser una cadena de texto',
            ]
        );
        // Lógica para almacenar la comuna en la base de datos
        // ...
        try {
            $busqueda = Comunas::where('sdescripcion', $request->comuna)->where('benabled', true)->first();
            if ($busqueda) {
                return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('error', 'La comuna ya existe.');
            } else {

                $comuna = new Comunas();
                $comuna->sdescripcion = $request->comuna;
                $comuna->benabled = true; // o false según corresponda
                $comuna->nusuario_creacion = Auth::user()->id; // Asumiendo que tienes autenticación
                $comuna->dfecha_creacion = now();
                $comuna->save();
                return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('success', 'Comuna creada exitosamente.');
            }
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('error', 'Error al crear la comuna: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $editComuna = Comunas::findOrFail($id);
        $comunas = $this->comunas();
        return view('modulos.ccombatiente.mantenimiento.catalogos.comunas', compact('editComuna', 'comunas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'comuna' => 'required|string|max:255',
            ],
            [/* para mensajes personalizados */],
            [
                'comuna' => 'Nombre de la Comuna es obligatorio',
                'comuna.required' => 'El :attribute no puede estar vacío',
                'comuna.max' => 'El :attribute no puede superar los :max caracteres',
                'comuna.string' => 'El :attribute debe ser una cadena de texto',
            ]
        );
        // Lógica para actualizar la comuna en la base de datos
        // ...
        try {
            $comuna = Comunas::findOrFail($id);
            $comuna->sdescripcion = $request->comuna;
            $comuna->nusuario_actualizacion = Auth::user()->id; // Asumiendo que tienes autenticación
            $comuna->dfecha_actualizacion = now();
            $comuna->save();
            return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('success', 'Comuna actualizada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('error', 'Error al actualizar la comuna: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        try {
            $comuna = Comunas::findOrFail($id);
            $comuna->benabled = false; // Deshabilitar en lugar de eliminar
            $comuna->nusuario_actualizacion = Auth::user()->id; // Asumiendo que tienes autenticación
            $comuna->dfecha_actualizacion = now();
            $comuna->save();
            return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('success', 'Comuna eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-comunas')->with('error', 'Error al eliminar la comuna: ' . $e->getMessage());
        }
    }
}
