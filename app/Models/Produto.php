<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = "product";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_categoria','desc','weight','height',
        'width','brand','price','stock','unity',
    ];
}