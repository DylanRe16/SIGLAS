<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Personales_Patologias extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'public.personales_patologias';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'personales_cedula',
        'patologias_id',
        'nenabled',
        'dfecha_creacion',
        'nusuario_creacion',
        'dfecha_actualizacion',
        'nusuario_actualizacion'
    ];
}
