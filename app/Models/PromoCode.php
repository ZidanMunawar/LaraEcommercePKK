<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoCode extends Model
{
    use HasFactory;

    protected $table = 'promocodes';

    protected $fillable = [
        'code',
        'image',
        'discount',
        'discount_type',
        'min_purchase',
        'expires_at',
    ];

    protected $casts = [
        'discount' => 'integer',  // ✅ INTEGER
        'min_purchase' => 'integer',  // ✅ INTEGER
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    public function getStatusAttribute()
    {
        return $this->isExpired() ? 'Expired' : 'Active';
    }

    public function getStatusClassAttribute()
    {
        return $this->isExpired() ? 'danger' : 'success';
    }

    public function getFormattedDiscountAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount . '%';
        }
        return 'Rp ' . number_format($this->discount, 0, ',', '.');
    }

    public function calculateDiscount($subtotal)
    {
        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            return floor(($subtotal * $this->discount) / 100);  // ✅ FLOOR BIAR BULAT
        }

        return $this->discount;
    }
}
