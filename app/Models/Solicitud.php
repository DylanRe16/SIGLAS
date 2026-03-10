<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $connection = 'bd2'; // Conexión a la base de datos
    protected $table = 'public.tb_solicitud'; // Nombre de la tabla
    protected $primaryKey = 'id_solicitud'; // Clave primaria
    public $timestamps = false; // Desactivar timestamps automáticos

    protected $fillable = [
        'sdescripcion', // Agrega los campos que necesites
        'id_tsolicitud', // Relación con TipoSolicitud
    ];

    // Relación con el modelo TipoSolicitud
    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitud::class, 'id_tsolicitud', 'id_tsolicitud');
    }


}