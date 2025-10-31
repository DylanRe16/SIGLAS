<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seniat extends Model{
    
    use HasFactory;

    protected $connection = 'third_pgsql'; // Conexión a la base de datos

    protected $table = 'seniat'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_seniat'; // Clave primaria de la tabla
    public $timestamps = false; // Desactivar los timestamps automáticos
}
