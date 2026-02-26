<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rango extends Model
{
    //
    protected $connection = 'bd4';

    protected $table = 'cuerpo_combatiente.tb_rango';
    protected $primaryKey = 'id_rango';
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
