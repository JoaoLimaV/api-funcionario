<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $table = "sale";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'customer_id', 'status', 'delivery_type', 'delivery_price', 'payment_type', 'payment_discount', 'installment_payment', 'obs'
    ];

    public function sale_item()
    {
        return $this->hasMany(ItemCarrinho::class, 'sale_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Cliente::class, 'customer_id', 'id');
    }

    public function sale_status()
    {
        return $this->belongsTo(ItemCarrinho::class, 'status', 'name');
    }
}
