<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "customer";
    protected $primaryKey = 'id';
    public $timestamps = false;

}