<?php

namespace App\Models;

use App\Models\Minpptrassi\Public\Rol;
use Illuminate\Database\Eloquent\Model;

class Personales extends Model
{
    protected $connection = 'bd4'; // Especifica la conexión
    protected $table = 'public.personales'; // Especifica el nombre de la tabla
    protected $primaryKey = 'cedula'; // Asegúrate de que esta sea tu clave primaria si no es 'id'
    public $timestamps = false; // Si no usas timestamps en esta tabla


    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'personales_rol', 'personales_cedula', 'rol_id')->wherePivot('nenabled', '1');
    }

}
