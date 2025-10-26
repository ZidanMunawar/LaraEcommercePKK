<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemKeranjang extends Model
{
    use HasFactory;

    protected $table = 'item_keranjang';
    protected $primaryKey = 'id_cart_item';
    public $timestamps = false;

    protected $fillable = [
        'id_cart',
        'id_produk',
        'id_size',
        'id_color',
        'qty',
        'harga'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
    ];

    public function keranjang()
    {
        return $this->belongsTo(Keranjang::class, 'id_cart', 'id_cart');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'id_size');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color');
    }
}
