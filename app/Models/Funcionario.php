<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = "funcionario";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id', 'nome', 'telefone', 'cpf', 'rg', 'endereco', 'data_nascimento',
        'cargo', 'data_admissao', 'data_demissao', 'email', 'sexo', 'status'
    ];
}
