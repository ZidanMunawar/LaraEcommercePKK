<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_customers',
        'id_shipping_method',
        'shipping_cost',
        'resi_number',
        'subtotal',
        'discount_amount',
        'total_amount',
        'metode_pembayaran',
        'snap_token',
        'transaction_id',
        'payment_type',
        'payment_status',
        'paid_at',
        'payment_proof',
        'payment_proof_uploaded_at',
        'status',
        'catatan',
        'approved_by',
        // Tambahkan shipping fields
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'shipping_village_name',
        'shipping_district_name',
        'shipping_regency_name',
        'shipping_province_name',
        'shipping_postal_code',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'paid_at' => 'datetime',
        'payment_proof_uploaded_at' => 'datetime',
    ];

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customers', 'id_customers');
    }

    public function shippingMethod()
    {
        return $this->belongsTo(ShippingMethod::class, 'id_shipping_method');
    }

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Admin::class, 'approved_by', 'id_admin');
    }

    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class, 'id_transaksi', 'id_transaksi');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
