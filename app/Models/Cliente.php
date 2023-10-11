<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = "customer";
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id', 'identify_document', 'name', 'email', 'password', 'address', 'phone', 
        'birthdate', 'image_path', 'gender', 'status', 'created_at', 'updated_at'
    ];

    public function delivery_address()
    {
        return $this->hasMany(DeliveryAddress::class, 'customer_id', 'id');
    }
}
