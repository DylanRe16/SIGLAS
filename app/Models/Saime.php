<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saime extends Model{
    
    use HasFactory;

    protected $connection = 'third_pgsql'; // Conexión a la base de datos

    protected $table = 'saime'; // Nombre de la tabla en la base de datos
    protected $primaryKey = 'numcedula'; // Clave primaria de la tabla
    public $timestamps = false; // Desactivar los timestamps automáticos

    public function getFormattedFechaNac()
    {
        if (!$this->fechanac) {
            return '';
        }

        foreach (['d-m-Y', 'Y-m-d'] as $format) {
            try {
                return \Carbon\Carbon::createFromFormat($format, trim($this->fechanac))->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        return '';
    }

}
