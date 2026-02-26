<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tratamiento_Medico extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'public.tratamiento_medico';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'personales_patologias_id',
        'productos_id',
        'sobservacion',
        'nenabled',
        'dfecha_creacion',
        'nusuario_creacion',
        'dfecha_actualizacion',
        'nusuario_actualizacion',
    ];
}
