<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ccombatiente extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'cuerpo_combatiente.tb_persona';
    protected $primaryKey = 'id_persona';
    public $timestamps = false;

    protected $fillable = [
        'snacionalidad',
        'ndocumento',
        'sprimer_nombre',
        'ssegundo_nombre',
        'sprimer_apellido',
        'ssegundo_apellido',
        'dfecha_nacimiento',
        'ssexo',
        'bembarazada',
        'semail',
        'id_estado_civil',
        'ncodigo_telfmovil',
        'nnumero_telfmovil',
        'ncodigo_telflocal',
        'nnumero_telflocal',
        'id_entidad',
        'id_municipio',
        'id_parroquia',
        'sdireccion',
        'spunto_referencia',
        'id_comuna_circuito',
        'btiene_discapacidad',
        'id_tipo_discapacidad',
        'id_grado_discapacidad',
        'sdicapacidad_especifique',
        'bcertificado_conapdis',
        'ncodigo_conapdis',
        'slateralidad',
        'id_grupo_sanguineo',
        'stalla_camisa',
        'stalla_pantalon',
        'ntalla_zapato',
        'binscripcion_militar',
        'nnumero_inscripcion_militar',
        'id_registro_miliciano',
        'bservicio_militar',
        'srango_militancia',
        'btiene_hijos',
        'ncant_hijos_menores',
        'subicacion_administrativa',
        'id_ciudad',
        'subicacion_fisica',
        'scargo_actual_ejerce',
        'id_tipo_trabajador',
        'id_ente',
        'benabled',
        'nusuario_creacion',
        'dfecha_creacion',
        'ncod_cargo_titular'
    ];
}
