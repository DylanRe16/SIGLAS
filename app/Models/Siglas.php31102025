<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Siglas extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'bd4'; // Conexión a la base de datos

    protected $table = 'sesion'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id'; // Clave primaria de la tabla
    public $timestamps = false; // Desactivar los timestamps automáticos

    protected $fillable = [
        'personales_cedula',
        'clave',
        'nusuario_creacion',
        'dfecha_creacion',
        'nusuario_actualizacion',
        'dfecha_actualizacion',
        'nenabled',
        'estatus',
    ];
}
