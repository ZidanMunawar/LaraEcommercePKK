<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $primaryKey = 'id_feedback';

    protected $fillable = [
        'id_customers',
        'id_transaksi',
        'nama_pelanggan',
        'pesan',
        'rating',
        'is_approved'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relationship dengan Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customers', 'id_customers');
    }

    // Relationship dengan Transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    // Scope untuk feedback yang disetujui
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    // Scope untuk feedback yang belum disetujui
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    // Accessor untuk rating stars
    public function getRatingStarsAttribute()
    {
        return str_repeat('⭐', $this->rating);
    }

    // Method untuk approve feedback
    public function approve()
    {
        $this->update(['is_approved' => true]);
    }

    // Method untuk reject feedback
    public function reject()
    {
        $this->update(['is_approved' => false]);
    }
}
