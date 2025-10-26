<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';

    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'id_size',
        'id_color',
        'qty',
        'harga',
        'diskon'
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'diskon' => 'decimal:2',
    ];

    // Relationships
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'id_size', 'id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color', 'id');
    }
}
