<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist';
    protected $primaryKey = 'id_wishlist';

    protected $fillable = [
        'id_customers',
        'id_produk'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customers', 'id_customers');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
