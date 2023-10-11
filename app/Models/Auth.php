<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    protected $table = "funcionario";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $hidden = [
        'name', 'email', 'password', 'telephone', 'cpf',
        'address', 'gender', 'birth_date', 'occupation', 'admission_date', 'dismissal_date', 'status'
    ];
}
