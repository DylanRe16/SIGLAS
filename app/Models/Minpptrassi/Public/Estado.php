<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model{
    protected $connection = 'bd4';
    protected $table = 'public.entidad';
    protected $primaryKey = 'nentidad';
    public $timestamps = false;
}
