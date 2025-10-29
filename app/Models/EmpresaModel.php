<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpresaModel extends Model
{
    protected $connection = 'bd2'; // Especifica la conexión de base de datos

    protected $table = 'gestion_solicitudes.tb_empresa';

    public $timestamps = false;
    protected $primaryKey = 'id_empresa'; // Agrega esta línea


    protected $fillable = [
        'srif',
        'srazon_social',
        'sdireccion_fiscal',
        'id_estado',
        'id_municipio',
        'id_parroquia',
        'id_sectoremp',
        'nusuario_creacion',
        // Agrega los campos que necesites
    ];

    // Relación con el modelo Solicitud_citaModel
    public function solicitudes()
    {
        return $this->hasMany(Solicitud_citaModel::class, 'id_empresa', 'id_empresa');
    }

    // Relación con la tabla tb_estado
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id_estado');
    }

    // Relación con la tabla tb_municipio
    public function municipio()
    {
        return $this->belongsTo(Municipio::class, 'id_municipio', 'id_municipio');
    }

    // Relación con la tabla tb_parroquia
    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class, 'id_parroquia', 'id_parroquia');
    }

    // Relación con la tabla tb_sector_empleo
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'id_sectoremp', 'id_sectoremp');
    }
}
