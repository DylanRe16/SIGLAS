<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Rango;

use Illuminate\Http\Request;

class RangoController extends Controller
{
    public function registros()
    {
        $registros = Rango::where('benabled', true)->get();
        return $registros;
    }
    public function index()
    {
        $registros = $this->registros();
        return view('modulos.ccombatiente.mantenimiento.catalogos.registro-rango', compact('registros'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'rango' => 'required|string|max:255',
            ],
            [/* para mensajes personalizados */],
            [
                'rango' => 'Información del Rango es obligatorio',
                'rango.required' => 'El :attribute no puede estar vacío',
                'rango.max' => 'El :attribute no puede superar los :max caracteres',
                'rango.string' => 'El :attribute debe ser una cadena de texto',
            ]
        );
        // Lógica para almacenar el registro rango en la base de datos
        // ...
        try {
            $busqueda = Rango::where('sdescripcion', $request->rango)->first();
            if ($busqueda) {
                return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-rango')->with('error', 'El rango ya existe.');
            } else {

                $registro = new Rango();
                $registro->sdescripcion = $request->rango;
                $registro->benabled = true; // o false según corresponda
                $registro->nusuario_creacion = Auth::user()->id; // Asumiendo que tienes autenticación
                $registro->dfecha_creacion = now();
                $registro->save();
                return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-rango')->with('success', 'Rango creado exitosamente.');
            }
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-rango')->with('error', 'Error al crear el rango: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $editRegistro = Rango::findOrFail($id);
        $registros = $this->registros();
        return view('modulos.ccombatiente.mantenimiento.catalogos.registro-rango', compact('registros', 'editRegistro'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'rango' => 'required|string|max:255',
            ],
            [/* para mensajes personalizados */],
            [
                'rango' => 'Información del Rango es obligatorio',
                'rango.required' => 'El :attribute no puede estar vacío',
                'rango.max' => 'El :attribute no puede superar los :max caracteres',
                'rango.string' => 'El :attribute debe ser una cadena de texto',
            ]
        );
        // Lógica para actualizar el registro rango en la base de datos
        // ...
        try {
            $registro = Rango::findOrFail($id);
            $registro->sdescripcion = $request->rango;
            $registro->nusuario_actualizacion = Auth::user()->id; // Asumiendo que tienes autenticación
            $registro->dfecha_actualizacion = now();
            $registro->save();
            return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-rango')->with('success', 'Rango actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-rango')->with('error', 'Error al actualizar el rango: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $registro = Rango::findOrFail($id);
        $registro->benabled = false;
        $registro->nusuario_actualizacion = Auth::user()->id; // Asumiendo que tienes autenticación
        $registro->dfecha_actualizacion = now();
        $registro->save();
        return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-rango')->with('success', 'Rango eliminado exitosamente.');
    }
}
