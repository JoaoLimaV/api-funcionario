<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = "product";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function product_img()
    {
        return $this->hasMany(ImagemProduto::class, 'product_id', 'id');
    }
}