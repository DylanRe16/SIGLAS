<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
    protected $connection = 'bd2';
    protected $table = 'public.tb_estatus';
    protected $primaryKey = 'id_estatus';
    public $timestamps = false;

    // Relación con el modelo Solicitud_citaModel
    public function solicitudCita()
    {
        return $this->hasMany(Solicitud_citaModel::class, 'id_estatus', 'id_estatus');
    }
}
