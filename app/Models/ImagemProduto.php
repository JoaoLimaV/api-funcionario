<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ImagemProduto extends Model
{
    protected $table = "product_img";
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(ImagemProduto::class, 'id', 'product_id');
    }
}