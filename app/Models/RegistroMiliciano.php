<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroMiliciano extends Model
{
    //
    protected $connection = 'bd4';
    protected $table = 'public.tb_registro_miliciano';
    protected $primaryKey = 'id_registro_miliciano';
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
