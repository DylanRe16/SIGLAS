<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $connection = 'bd4';
    protected $table = 'public.entidad';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
