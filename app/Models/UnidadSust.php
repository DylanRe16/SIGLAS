<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadSust extends Model
{
    protected $connection = 'bd4'; // Especifica la conexión
    protected $table = 'public.unidad_sustantiva_gs'; // Especifica el nombre de la tabla
    protected $primaryKey = 'id'; // Asegúrate de que esta sea tu clave primaria si no es 'id'
    public $timestamps = false; // Si no usas timestamps en esta tabla

    // Relación con el modelo personales_rol_unidad_sustantiva
    public function personaRol_unidadSust(){
        return $this->hasMany(PersonaRolUnidadSust::class, 'unidad_sustantiva_gs_id', 'id');
    }
}
