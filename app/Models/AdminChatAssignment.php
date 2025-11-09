<?php
// app/Models/AdminChatAssignment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminChatAssignment extends Model
{
    use HasFactory;

    protected $table = 'admin_chat_assignments';

    protected $fillable = [
        'id_room',
        'id_admin',
        'assigned_at',
        'unassigned_at',
        'is_active'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'unassigned_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public $timestamps = true;

    // Relationship dengan admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // Relationship dengan chat room
    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'id_room', 'id_room');
    }

    // Scope untuk assignment aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
