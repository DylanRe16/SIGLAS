<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tb_Codigo_Telefonico extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'public.tb_codigos_telefonicos';
    protected $primaryKey = 'id_codtelf';
    public $timestamps = false;
    protected $fillable = [
        'ncodigo',
        'sdescripcion',
        'btipo',
        'benabled',
        'nusuario_creacion',
        'dfecha_creacion',
        'nusuario_actualizacion',
        'dfecha_actualizacion'
    ];
}
