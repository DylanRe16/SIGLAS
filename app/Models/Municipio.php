<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $connection = 'bd2';
    protected $table = 'public.tb_municipio';
    protected $primaryKey = 'id_municipio';
    public $timestamps = false;

    
}
