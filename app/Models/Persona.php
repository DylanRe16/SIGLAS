<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Persona extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $connection = 'bd5'; // Conexión a la base de datos

    protected $table = 'tb_persona'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'id_persona'; // Clave primaria de la tabla
    public $timestamps = false; // Desactivar los timestamps automáticos

    protected $fillable = [
        'snacionalidad',
        'ndocumento',
        'sprimer_nombre',
        'ssegundo_nombre',
        'sprimer_apellido',
        'ssegundo_apellido',
        'dfecha_nacimiento',
        'ssexo',
        'id_estado',
        'id_municipio',
        'id_parroquia',
        'semail_principal',
        'semail_secundario',
        'ncodigo_telfmovil',
        'nnumero_telfmovil',
        'ncodigo_telflocal',
        'nnumero_telflocal',
        'nusuario_creacion',
        'dfecha_creacion',
        'nusuario_actualizacion',
        'dfecha_actualizacion',
        'sclave',
        'id_nivel',
        'sfoto',
    ];

    protected function casts(): array
    {
        return [
            'sclave' => 'hashed',
        ];
    }

    
    // Mutador para el campo sprimer_nombre
    
    protected function sprimerNombre(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(strtolower(trim($value)))
        );
    }

    
    //  Mutador para el campo ssegundo_nombre
        
    protected function ssegundoNombre(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(strtolower(trim($value)))
        );
    }

    
    // Mutador para el campo sprimer_apellido
        
    protected function sprimerApellido(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(strtolower(trim($value)))
        );
    }

    
    // Mutador para el campo ssegundo_apellido
    
    protected function ssegundoApellido(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(strtolower(trim($value)))
        );
    }

    // Relación con el modelo Solicitud_citaModel
    public function solicitudes(){
        return $this->hasMany(Solicitud_citaModel::class, 'id_persona', 'id_persona');
    }

    // Relación con el modelo Solicitud_citaModel
    public function preguntaSeg(){
        return $this->hasMany(PreguntaSeg::class, 'id_persona', 'id_persona');
    }
}
