<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreguntaSeg extends Model
{
    protected $connection = 'bd5'; // Conexión a la base de datos

    protected $table = 'tb_persona_pseguridad'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_ppseguridad'; // Clave primaria de la tabla
    public $timestamps = false; // Desactivar los timestamps automáticos

    protected $fillable = [
        'id_persona',
        'id_preguntaseg',
        'srespuesta',
        'nusuario_creacion',
    ];

    // Relación con el modelo tb_Preguntas_seg
    public function preguntas(){
        return $this->belongsTo(Preguntas::class, 'id_preguntaseg', 'id_preguntaseg');
    }
}
