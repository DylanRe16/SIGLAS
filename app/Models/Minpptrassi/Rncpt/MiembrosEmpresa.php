<?php

namespace App\Models\Minpptrassi\Rncpt;

use Illuminate\Database\Eloquent\Model;

class MiembrosEmpresa extends Model{
    protected $connection = 'bd4';
    protected $table = 'rncpt.miembros_empresa';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
