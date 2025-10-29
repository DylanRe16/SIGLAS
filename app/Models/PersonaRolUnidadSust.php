<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaRolUnidadSust extends Model
{
    protected $connection = 'bd4'; // Especifica la conexión
    protected $table = 'public.personales_rol_unidad_sustantiva'; // Especifica el nombre de la tabla
    protected $primaryKey = 'id'; // Asegúrate de que esta sea tu clave primaria si no es 'id'
    public $timestamps = false; // Si no usas timestamps en esta tabla

    function personalRol(){
        return $this->belongsTo(PersonaRol::class,'personales_rol_id','id');
    }

    // Relación con la tabla unidad_sustantiva_gs
    public function unidadSust(){
        return $this->belongsTo(UnidadSust::class, 'unidad_sustantiva_gs_id', 'id');
    }
}
