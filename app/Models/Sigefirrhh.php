<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sigefirrhh extends Model
{
    //
    protected $connection = 'sigefirrhh';
    protected $table = 'personal';
    protected $primaryKey = 'id_personal';
    public $timestamps = false;
}
