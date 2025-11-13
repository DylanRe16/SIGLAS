<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model{
    protected $connection = 'bd4';
    protected $table = 'public.parroquia';
    protected $primaryKey = 'nparroquia';
    public $timestamps = false;
}
