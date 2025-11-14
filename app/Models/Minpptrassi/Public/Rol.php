<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $connection = 'bd4';
    protected $table = 'public.rol';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function opciones()
    {
        return $this->belongsToMany(Opcion::class, 'rolopcion', 'rol_id', 'opcion_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany(Personales::class, 'personales_rol', 'rol_id', 'personales_cedula');
    }
}
