<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'name',
        'description',
        'price',
        'old_price',
        'quantity',
        'is_available',
        'is_new',
        'is_featured',
        'is_best_seller',
        'promotion_id', // UBAH INI
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'quantity' => 'integer',
        'is_available' => 'boolean',
        'is_new' => 'boolean',
        'is_featured' => 'boolean',
        'is_best_seller' => 'boolean',
    ];

    // Relations
    public function promotion() // TAMBAH INI
    {
        return $this->belongsTo(Promotion::class, 'promotion_id');
    }

    public function audiences()
    {
        return $this->belongsToMany(Audience::class, 'produk_audiences', 'id_produk', 'id_audience');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'produk_categories', 'id_produk', 'id_category');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'produk_colors', 'id_produk', 'id_color');
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'produk_sizes', 'id_produk', 'id_size');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'produk_tags', 'id_produk', 'id_tag');
    }

    public function images()
    {
        return $this->hasMany(ProdukImage::class, 'id_produk', 'id_produk');
    }

    public function primaryImage()
    {
        return $this->hasOne(ProdukImage::class, 'id_produk', 'id_produk')->where('is_primary', true);
    }

    // Accessors
// Accessors - FIX INI
    public function getDiscountPercentageAttribute()
    {
        // Cast to float untuk pastikan calculation benar
        $oldPrice = floatval($this->old_price);
        $currentPrice = floatval($this->price);

        if ($oldPrice && $oldPrice > $currentPrice && $currentPrice > 0) {
            return round((($oldPrice - $currentPrice) / $oldPrice) * 100);
        }
        return 0;
    }


    public function getStockStatusAttribute()
    {
        if (!$this->is_available) {
            return 'Tidak Tersedia';
        }
        if ($this->quantity <= 0) {
            return 'Stok Habis';
        }
        if ($this->quantity <= 10) {
            return 'Stok Terbatas';
        }
        return 'Tersedia';
    }
}
