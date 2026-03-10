<?php

namespace App\Models\Minpptrassi\Public;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $connection = 'bd4';
    protected $table = 'public.modulo';
    protected $primaryKey = 'id';
    public $timestamps = false;


    public function opciones(){
        return $this->hasMany(Opcion::class, 'nmodulo', 'id')->where('senabled', 1)->where('bsiglas2', true);
    }
}
