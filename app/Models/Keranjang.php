<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';
    protected $primaryKey = 'id_cart';

    protected $fillable = [
        'id_customers'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customers', 'id_customers');
    }

    public function items()
    {
        return $this->hasMany(ItemKeranjang::class, 'id_cart', 'id_cart');
    }
}
