<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preguntas extends Model
{
    protected $connection = 'bd4';
    protected $table = 'public.tb_preguntas_seg';
    protected $primaryKey = 'id_preguntaseg';
    public $timestamps = false;
}
