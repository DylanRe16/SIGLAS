<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personales_Nivel_Academico extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'public.personales_nivel_academico';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'id_personales',
        'id_nivel_academico',
        'sespecialidad',
        'sgraduado',
        'dfecha_creacion',
        'usuario_idcreacion',
        'dfecha_actualizacion',
        'usuario_idactualizacion',
        'nenabled',
    ];
}
