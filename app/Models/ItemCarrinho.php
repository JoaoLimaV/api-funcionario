<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ItemCarrinho extends Model
{
    protected $table = "sale_item";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'product_id', 'amount','discount'
    ];

    public function sale()
    {
        return $this->belongsTo(Carrinho::class, 'sale_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Produto::class, 'product_id', 'id');
    }
}