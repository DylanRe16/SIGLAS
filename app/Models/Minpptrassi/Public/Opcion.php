<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $connection = 'bd4';
    protected $table = 'public.opcion';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function modulo(){
        return $this->belongsTo(Modulo::class, 'nmodulo', 'id');
    }

    public function roles(){
        return $this->belongsToMany(Rol::class, 'rolopcion', 'opcion_id', 'rol_id');
    }
}
