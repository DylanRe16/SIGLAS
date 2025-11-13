<?php

namespace App\Models\Minpptrassi\Rncpt;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model{

    protected $connection = 'bd4';
    protected $table = 'rncpt.empresa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    
}
