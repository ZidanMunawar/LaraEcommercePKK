<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PromoCode extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'promocodes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'image',
        'discount',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'discount' => 'decimal:2',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Check if promo code is expired
     *
     * @return bool
     */
    public function isExpired()
    {
        return Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Get status badge
     *
     * @return string
     */
    public function getStatusAttribute()
    {
        return $this->isExpired() ? 'Expired' : 'Active';
    }

    /**
     * Get status class for badge
     *
     * @return string
     */
    public function getStatusClassAttribute()
    {
        return $this->isExpired() ? 'danger' : 'success';
    }
}
