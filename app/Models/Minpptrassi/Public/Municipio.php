<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model{
    protected $connection = 'bd4';
    protected $table = 'public.municipio';
    protected $primaryKey = 'nmunicipio';
    public $timestamps = false;
}
