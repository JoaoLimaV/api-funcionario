<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = "funcionario";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id', 'name', 'email', 'password', 'telephone', 'cpf', 'address', 'gender',
        'birth_date', 'role', 'occupation', 'admission_date', 'dismissal_date', 'status'
    ];
}
