<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisito extends Model
{
    protected $table = 'public.tb_requisitos';
    protected $primaryKey = 'id_requisitos';
    public $timestamps = false;

    public function tipoSolicitud()
    {
        return $this->belongsToMany(
            TipoSolicitud::class,
            'public.tb_tsolicitud_requisitos',
            'id_requisitos',
            'id_tsolicitud'
        );
    }
}