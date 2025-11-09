<?php
// app/Models/ChatMessage.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_messages';
    protected $table = 'chat_messages';

    protected $fillable = [
        'id_room',
        'sender_type',
        'sender_id',
        'message_type',
        'isi_pesan',
        'image_url',
        'file_name',
        'file_size',
        'is_read',
        'read_at'
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Relationship dengan chat room
    public function room()
    {
        return $this->belongsTo(ChatRoom::class, 'id_room', 'id_room');
    }

    // Relationship dengan sender (polymorphic)
    public function sender()
    {
        if ($this->sender_type === 'customer') {
            return $this->belongsTo(Customer::class, 'sender_id', 'id_customers');
        }

        return $this->belongsTo(Admin::class, 'sender_id', 'id_admin');
    }

    // Mark as read
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        }
    }

    // Scope untuk pesan yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    // Scope untuk pesan dari customer
    public function scopeFromCustomer($query)
    {
        return $query->where('sender_type', 'customer');
    }

    // Scope untuk pesan dari admin
    public function scopeFromAdmin($query)
    {
        return $query->where('sender_type', 'admin');
    }
}
