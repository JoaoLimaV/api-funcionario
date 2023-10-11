<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    protected $table = "delivery_address";
    protected $primaryKey = 'id';
    public $timestamps = false;
    
    protected $fillable = [
        'id', 'customer_id', 'cep', 'numero', 'complemento',
        'referencia', 'created_at', 'updated_at'
    ];

    public function address()
    {
        return $this->belongsTo(Address::class, 'cep', 'cep');
    }
}