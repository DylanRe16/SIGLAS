<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Indicar que la clave primaria es 'id_persona'
     */
    protected $primaryKey = 'id_persona';

    /**
     * Definir los atributos que se pueden asignar en masa.
     */
    protected $fillable = [
        'id_persona',
        'snacionalidad',
        'ndocumento',
        'sprimer_nombre',
        'ssegundo_nombre',
        'sprimer_apellido',
        'ssegundo_apellido',
        'email',
        'password',
    ];

    /**
     * Esconder los atributos sensibles.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Definir los tipos de datos.
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Especificar la conexión de la base de datos (si tb_persona está en bd2)
     */
    protected $connection = 'bd2';

    /**
     * Especificar la tabla que usa este modelo.
     */
    protected $table = 'public.tb_persona';
}

