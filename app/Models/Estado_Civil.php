<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado_Civil extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'public.estado_civil';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'sdescripcion',
        'nenabled',
        'dfecha_creacion',
        'nusuario_creacion',
        'dfecha_actualizacion',
        'nusuario_actualizacion'
    ];
}
