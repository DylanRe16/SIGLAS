<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\RegistroMiliciano;

use Illuminate\Http\Request;

class RegistroMilicianoController extends Controller
{
    public function registros()
    {
        $registros = RegistroMiliciano::where('benabled', true)->get();
        return $registros;
    }
    public function index()
    {
        $registros = $this->registros();
        return view('modulos.ccombatiente.mantenimiento.catalogos.registro-miliciano', compact('registros'));
    }
    public function store(Request $request)
    {
        $request->validate(
            [
                'registro_miliciano' => 'required|string|max:255',
            ],
            [/* para mensajes personalizados */],
            [
                'registro_miliciano' => 'Información del Registro Miliciano es obligatorio',
                'registro_miliciano.required' => 'El :attribute no puede estar vacío',
                'registro_miliciano.max' => 'El :attribute no puede superar los :max caracteres',
                'registro_miliciano.string' => 'El :attribute debe ser una cadena de texto',
            ]
        );
        // Lógica para almacenar el registro miliciano en la base de datos
        // ...
        try {
            $busqueda = RegistroMiliciano::where('sdescripcion', $request->registro_miliciano)->first();
            if ($busqueda) {
                return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-miliciano')->with('error', 'El registro miliciano ya existe.');
            } else {

                $registro = new RegistroMiliciano();
                $registro->sdescripcion = $request->registro_miliciano;
                $registro->benabled = true; // o false según corresponda
                $registro->nusuario_creacion = Auth::user()->id; // Asumiendo que tienes autenticación
                $registro->dfecha_creacion = now();
                $registro->save();
                return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-miliciano')->with('success', 'Registro miliciano creado exitosamente.');
            }
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-miliciano')->with('error', 'Error al crear el registro miliciano: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        $editRegistro = RegistroMiliciano::findOrFail($id);
        $registros = $this->registros();
        return view('modulos.ccombatiente.mantenimiento.catalogos.registro-miliciano', compact('registros', 'editRegistro'));
    }
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'registro_miliciano' => 'required|string|max:255',
            ],
            [/* para mensajes personalizados */],
            [
                'registro_miliciano' => 'Información del Registro Miliciano es obligatorio',
                'registro_miliciano.required' => 'El :attribute no puede estar vacío',
                'registro_miliciano.max' => 'El :attribute no puede superar los :max caracteres',
                'registro_miliciano.string' => 'El :attribute debe ser una cadena de texto',
            ]
        );
        // Lógica para actualizar el registro miliciano en la base de datos
        // ...
        try {
            $registro = RegistroMiliciano::findOrFail($id);
            $registro->sdescripcion = $request->registro_miliciano;
            $registro->nusuario_actualizacion = Auth::user()->id; // Asumiendo que tienes autenticación
            $registro->dfecha_actualizacion = now();
            $registro->save();
            return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-miliciano')->with('success', 'Registro miliciano actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-miliciano')->with('error', 'Error al actualizar el registro miliciano: ' . $e->getMessage());
        }
    }
    public function destroy($id)
    {
        $registro = RegistroMiliciano::findOrFail($id);
        $registro->benabled = false;
        $registro->nusuario_actualizacion = Auth::user()->id; // Asumiendo que tienes autenticación
        $registro->dfecha_actualizacion = now();
        $registro->save();
        return redirect()->route('ccombatiente-mantenimiento-catalogos-registro-miliciano')->with('success', 'Registro miliciano eliminado exitosamente.');
    }
}
