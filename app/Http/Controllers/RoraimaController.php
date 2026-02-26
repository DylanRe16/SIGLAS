<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoraimaController extends Controller
{
    public function index()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.index', $data);
    }

     public function proyectos()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.proyectos', $data);
    }

     public function acciones_centralizadas()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.acciones_centralizadas', $data);
    }

    public function asignar_proyectos()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.asignar_proyectos', $data);
    }

    public function asignar_acciones()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.asignar_acciones', $data);
    }

    public function proyectos_requerimientos()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.proyectos_requerimientos', $data);
    }

    public function acc_requerimientos()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.acc_requerimientos', $data);
    }

    public function proyectos2()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.proyectos2', $data);
    }

    public function acciones_centralizadas2()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.acciones_centralizadas2', $data);
    }

     public function reportes_planificacion()
    {
        // Si no tienes el método roles() aquí, esto fallará. 
        // Por ahora, para probar, usemos algo simple:
        $user = Auth::user();
        $rol_usuario = $user->roles()->first(); // Ajusta según tu lógica real

        $data['rol_usuario'] = $rol_usuario;

        return view('modulos.roraima.reportes_planificacion', $data);
    }
}
