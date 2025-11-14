<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Personales extends Model
{
    protected $connection = 'bd4';
    protected $table = 'public.personales';
    protected $primaryKey = 'cedula';
    public $timestamps = false;

    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'personales_rol', 'personales_cedula', 'rol_id');
    }
}
