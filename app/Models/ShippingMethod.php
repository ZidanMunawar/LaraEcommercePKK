<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cost',
        'estimated_days',
        'is_active'
    ];

    protected $casts = [
        'cost' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'id_shipping_method');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
