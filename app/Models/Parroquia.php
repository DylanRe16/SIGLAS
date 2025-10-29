<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parroquia extends Model
{
    protected $connection = 'bd2';
    protected $table = 'public.tb_parroquia';
    protected $primaryKey = 'id_parroquia';
    public $timestamps = false;

}
