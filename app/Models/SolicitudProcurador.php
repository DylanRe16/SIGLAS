<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudProcurador extends Model
{
    protected $connection = 'bd2'; // Especifica la conexión
    protected $table = 'gestion_solicitudes.tb_solicitud_procurador'; // Especifica el nombre de la tabla
    protected $primaryKey = 'id'; // Asegúrate de que esta sea tu clave primaria si no es 'id'
    public $timestamps = false; // Si no usas timestamps en esta tabla

    protected $fillable = [
        'personales_rol_unidad_sustantiva_id',
        'persona_tsolicitud_id',
        'estatus_id',
        'personales_asistido',
        'sobservacion',
        'dfecha_cita',
        'nenabled',
        'dfecha_creacion',
        'nusuario_creacion',
    ];

    // Relación con el modelo PersonaRolUnidadSust
    public function personalRolUnidadSust(){
        return $this->belongsTo(PersonaRolUnidadSust::class, 'personales_rol_unidad_sustantiva_id', 'id');
    }

    // Relación con la tabla tb_estatus
    public function estatus(){
        return $this->belongsTo(Estatus::class, 'estatus_id', 'id_estatus');
    }

    // Relación con la tabla tb_estatus
    public function personaSolicitud(){
        return $this->belongsTo(Solicitud_citaModel::class, 'persona_tsolicitud_id', 'id_ptsolicitud');
    }
}
