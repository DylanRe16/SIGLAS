<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoSolicitud extends Model
{
    protected $connection = 'bd2';
    protected $table = 'public.tb_tipo_solicitud';
    protected $primaryKey = 'id_tsolicitud';
    public $timestamps = false;

    protected $fillable = [
        'sdescripcion',
    ];



    // Relación con el modelo Solicitud
    public function solicitud()
    {
        return $this->hasMany(Solicitud::class, 'id_solicitud', 'id_solicitud');
    }

    public function requisitos(){
        return $this->belongsToMany(
            Requisito::class,
            'public.tb_tsolicitud_requisitos',
            'id_tsolicitud',
            'id_requisitos'
        );
    }
}