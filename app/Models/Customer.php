<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'id_customers';

    protected $fillable = [
        'username',
        'password',
        'nama_lengkap',
        'email',
        'no_telp',
        'alamat',
        'province_name',
        'regency_name',
        'district_name',
        'village_name',
        'postal_code',
    ];

    // Accessor untuk alamat lengkap
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->alamat,
            $this->village_name,
            $this->district_name,
            $this->regency_name,
            $this->province_name,
            $this->postal_code
        ]);

        return implode(', ', $parts);
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Auto hash password
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    // Relationships
    // public function transaksi()
    // {
    //     return $this->hasMany(Transaksi::class, 'id_customers', 'id_customers');
    // }

    public function keranjang()
    {
        return $this->hasOne(Keranjang::class, 'id_customers', 'id_customers');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'id_customers', 'id_customers');
    }

    // public function shippingAddresses()
    // {
    //     return $this->hasMany(ShippingAddress::class, 'id_customers', 'id_customers');
    // }

    public function chatRooms()
    {
        return $this->hasMany(ChatRoom::class, 'id_customers', 'id_customers');
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'sender_id', 'id_customers')
            ->where('sender_type', 'customer');

    }


}
