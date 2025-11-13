<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunas extends Model
{
    //
    protected $connection = 'bd4';

    protected $table = 'public.tb_comuna_circuito';
    protected $primaryKey = 'id_comuna_circuito';
    public $timestamps = false;
    protected $fillable = [
        'sdescripcion',
        'benabled',
        'nusuario_creacion',
        'nusuario_actualizacion',
        'dfecha_creacion',
        'dfecha_actualizacion'
    ];
}
