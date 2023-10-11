<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $table = "sale";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'customer_id','status'
    ];

    public function sale_item()
    {
        return $this->hasMany(ItemCarrinho::class, 'sale_id', 'id');
    }
}
