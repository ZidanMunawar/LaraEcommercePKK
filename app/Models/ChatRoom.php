<?php
// app/Models/ChatRoom.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_room';
    protected $table = 'chat_rooms';

    protected $fillable = [
        'id_customers',
        'id_admin',
        'status',
        'subject',
        'last_message_at'
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    // Relationship dengan customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customers', 'id_customers');
    }

    // Relationship dengan admin
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id_admin', 'id_admin');
    }

    // Relationship dengan messages
    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'id_room', 'id_room')
            ->orderBy('created_at', 'asc');
    }

    // Relationship dengan unread messages
    public function unreadMessages()
    {
        return $this->hasMany(ChatMessage::class, 'id_room', 'id_room')
            ->where('is_read', false)
            ->where('sender_type', 'customer');
    }

    // Latest message
    public function latestMessage()
    {
        return $this->hasOne(ChatMessage::class, 'id_room', 'id_room')
            ->latest();
    }

    // Scope untuk chat aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk chat yang belum ditugaskan
    public function scopeUnassigned($query)
    {
        return $query->whereNull('id_admin');
    }

    // Update last message timestamp
    public function updateLastMessage()
    {
        $this->update(['last_message_at' => now()]);
    }
}
