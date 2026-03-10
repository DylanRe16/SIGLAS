<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use App\Models\Ccombatiente;

use Illuminate\Http\Request;

class ReporteCCombatienteController extends Controller
{
    public function index()
    {
        $totalHombres = Ccombatiente::where('ssexo', '2')->count();
        $totalMujeres = Ccombatiente::where('ssexo', '1')->count();
        $totalGeneral = Ccombatiente::count();
        $personasDiscapacitadas = Ccombatiente::where('btiene_discapacidad', true)->count();
        $personasNoDiscapacitadas = Ccombatiente::where('btiene_discapacidad', false)->count();
        $cantidadMPPPST = Ccombatiente::where('id_ente', 'MPPPST')->count();
        $cantidadINPSASEL = Ccombatiente::where('id_ente', 'INPSASEL')->count();
        $cantidadINCES = Ccombatiente::where('id_ente', 'INCES')->count();
        $cantidadTSS = Ccombatiente::where('id_ente', 'TSS')->count();
        $cantidadINCRET = Ccombatiente::where('id_ente', 'INCRET')->count();
        $totalPersonasEnte = Ccombatiente::whereIn('id_ente', ['MPPPST', 'INPSASEL', 'INCES', 'TSS', 'INCRET'])->count();
        $cantidadPersonaEntidad = Ccombatiente::select(
            DB::raw('COUNT(id_persona) AS cantidad'),
            DB::raw("COALESCE(enti.sdescripcion, 'POR DEFINIR') AS entidad_federal")
        )
            ->from('cuerpo_combatiente.tb_persona as pers')
            ->leftJoin('entidad as enti', 'pers.id_entidad', '=', 'enti.nentidad')
            ->where('pers.benabled', true)
            ->groupBy('pers.id_entidad', 'enti.sdescripcion')
            ->orderBy('enti.sdescripcion')
            ->get();
        $cantidadEdades = Ccombatiente::select(
            DB::raw("
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 20 AND 24 THEN 1 ELSE 0 END) AS entre20y24,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 25 AND 29 THEN 1 ELSE 0 END) AS entre25y29,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 30 AND 34 THEN 1 ELSE 0 END) AS entre30y34,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 35 AND 39 THEN 1 ELSE 0 END) AS entre35y39,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 40 AND 45 THEN 1 ELSE 0 END) AS entre40y45,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 46 AND 50 THEN 1 ELSE 0 END) AS entre46y50,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 51 AND 55 THEN 1 ELSE 0 END) AS entre51y55,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) BETWEEN 56 AND 60 THEN 1 ELSE 0 END) AS entre56y60,
            SUM(CASE WHEN EXTRACT(YEAR FROM AGE(current_date, dfecha_nacimiento)) > 60 THEN 1 ELSE 0 END) AS de60ymasanios
        ")
        )
            ->where('benabled', true)
            ->first();
        $catidadPersonaTipoTrabajo = Ccombatiente::select(
            DB::raw('COUNT(id_persona) AS cantidad'),
            DB::raw("COALESCE(trabajo.sdescripcion, 'POR DEFINIR') AS tipo_trabajo")
        )
            ->from('cuerpo_combatiente.tb_persona as pers')
            ->leftJoin('public.tipo_trabajador as trabajo', 'pers.id_tipo_trabajador', '=', 'trabajo.ncodigo')
            ->where('pers.benabled', true)
            ->groupBy('pers.id_tipo_trabajador', 'trabajo.sdescripcion')
            ->get();

        $cantidadComunas = Ccombatiente::select(
            DB::raw('COUNT(id_persona) AS cantidad'),
            DB::raw("COALESCE(comuna.sdescripcion, 'POR DEFINIR') AS comuna")
        )
            ->from('cuerpo_combatiente.tb_persona as pers')
            ->leftJoin('public.tb_comuna_circuito as comuna', 'pers.id_comuna_circuito', '=', 'comuna.id_comuna_circuito')
            ->where('pers.benabled', true)
            ->groupBy('pers.id_comuna_circuito', 'comuna.sdescripcion')
            ->get();

        $miliciasi = Ccombatiente::where('balisto_miliciano', true)->count();
        $milicano = Ccombatiente::where('balisto_miliciano', false)->count();
        $cantidadRangos = Ccombatiente::select(
            DB::raw('COUNT(id_persona) AS cantidad'),
            DB::raw("COALESCE(rango.sdescripcion, 'POR DEFINIR') AS rango_militancia")
        )
            ->from('cuerpo_combatiente.tb_persona as pers')
            ->leftJoin('cuerpo_combatiente.tb_rango as rango', 'pers.id_rango', '=', 'rango.id_rango')
            ->where('pers.benabled', true)->where('pers.id_rango', '!=', null)
            ->groupBy('pers.id_rango', 'rango.sdescripcion')
            ->get();
        //return $cantidadRangos;
        $condicionSaludsi = Ccombatiente::where('bcondicion_salud', true)->count();
        $condicionSaludno = Ccombatiente::where('bcondicion_salud', false)->count();


        return view('modulos.ccombatiente.reporte', compact(
            'totalHombres',
            'totalMujeres',
            'personasDiscapacitadas',
            'personasNoDiscapacitadas',
            'cantidadMPPPST',
            'cantidadINPSASEL',
            'cantidadINCES',
            'cantidadTSS',
            'cantidadINCRET',
            'totalPersonasEnte',
            'cantidadPersonaEntidad',
            'cantidadEdades',
            'catidadPersonaTipoTrabajo',
            'cantidadComunas',
            'miliciasi',
            'milicano',
            'cantidadRangos',
            'condicionSaludsi',
            'condicionSaludno',
            'totalGeneral'
        ));
    }
}
