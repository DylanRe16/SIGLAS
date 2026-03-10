<?php

namespace App\Models\Minpptrassi\Rncpt;

use Illuminate\Database\Eloquent\Model;

class Miembros extends Model{
    protected $connection = 'bd4';
    protected $table = 'rncpt.miembros';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
