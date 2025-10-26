<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaksi',
        'transaction_id',
        'order_id',
        'payment_type',
        'gross_amount',
        'transaction_status',
        'fraud_status',
        'status_code',
        'response_midtrans'
    ];

    protected $casts = [
        'gross_amount' => 'decimal:2',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
