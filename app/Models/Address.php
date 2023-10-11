<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = "address";
    protected $primaryKey = 'cep';
    protected $keyType = 'string';
    public $timestamps = false;
    
    protected $fillable = [
        'cep', 'logradouro', 'bairro', 'cidade', 'uf'
    ];

    public function deliveryAddresses()
    {
        return $this->hasMany(DeliveryAddress::class, 'cep', 'cep');
    }
}