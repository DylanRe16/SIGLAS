<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $connection = 'bd2';
    protected $table = 'public.tb_sector_empleo';
    protected $primaryKey = 'id_sectoremp';
    public $timestamps = false;

}