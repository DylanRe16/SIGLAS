<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class Solicitud_citaModel extends Model
{
    //
    protected $connection = 'bd2'; // Especifica la conexión de base de datos

    protected $table = 'gestion_solicitudes.tb_persona_tsolicitud';

    public $timestamps = false;
    protected $primaryKey = 'id_ptsolicitud'; // Agrega esta línea


    protected $fillable = [
        'id_persona',
        'id_tsolicitud',
        'id_empresa',
        'bcargo_direccion',
        'sult_cargo_desempenado',
        'nusuario_creacion',
        'dfecha_creacion',
    ];

    // Relación con el modelo Persona
    public function persona(){
        return $this->belongsTo(Persona::class, 'id_persona', 'id_persona');
    }

    // Relación con el modelo EmpresaModel
    public function empresa(){
        return $this->belongsTo(EmpresaModel::class, 'id_empresa', 'id_empresa');
    }

    // Relación con la tabla tb_tipo_solicitud
    public function tipoSolicitud(){
        return $this->belongsTo(TipoSolicitud::class, 'id_tsolicitud', 'id_tsolicitud');
    }

    // Relación con la tabla tb_estatus
    public function estatus(){
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id_estatus');
    }

    // Relación con la tabla tb_estatus
    public function solicitudProcurador(){
        return $this->hasMany(SolicitudProcurador::class, 'persona_tsolicitud_id', 'id_ptsolicitud');
    }
}
