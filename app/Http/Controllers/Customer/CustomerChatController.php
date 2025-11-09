<?php
// app/Http/Controllers/Customer/CustomerChatController.php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerChatController extends Controller
{
    // Menampilkan daftar chat room customer
    public function index()
    {
        $customerId = Auth::guard('customer')->id();

        $chatRooms = ChatRoom::with(['admin', 'latestMessage'])
            ->where('id_customers', $customerId)
            ->orderBy('last_message_at', 'desc')
            ->get();

        return view('customer.pages.chat.index', compact('chatRooms'));
    }

    // Memulai chat baru
    public function startChat(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255'
        ]);

        $customerId = Auth::guard('customer')->id();

        // Cek apakah sudah ada chat aktif
        $existingChat = ChatRoom::where('id_customers', $customerId)
            ->where('status', 'active')
            ->first();

        if ($existingChat) {
            return redirect()->route('customer.chat.room', $existingChat->id_room)
                ->with('info', 'Anda sudah memiliki chat aktif');
        }

        // Buat chat room baru
        $chatRoom = ChatRoom::create([
            'id_customers' => $customerId,
            'subject' => $request->subject,
            'status' => 'active',
            'last_message_at' => now()
        ]);

        // Kirim pesan pertama dari customer
        ChatMessage::create([
            'id_room' => $chatRoom->id_room,
            'sender_type' => 'customer',
            'sender_id' => $customerId,
            'message_type' => 'text',
            'isi_pesan' => $request->subject,
        ]);

        return redirect()->route('customer.chat.room', $chatRoom->id_room)
            ->with('success', 'Chat berhasil dimulai, admin akan segera merespons');
    }

    // Menampilkan detail chat room
    public function showRoom($id)
    {
        $customerId = Auth::guard('customer')->id();

        $chatRoom = ChatRoom::with(['messages.sender', 'admin'])
            ->where('id_room', $id)
            ->where('id_customers', $customerId)
            ->firstOrFail();

        // Tandai pesan sebagai dibaca
        ChatMessage::where('id_room', $id)
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return view('customer.pages.chat.room', compact('chatRoom'));
    }

    // Mengirim pesan sebagai customer
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000', // Diubah jadi nullable
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $customerId = Auth::guard('customer')->id();

        $chatRoom = ChatRoom::where('id_room', $id)
            ->where('id_customers', $customerId)
            ->firstOrFail();

        // Validasi: harus ada message ATAU image
        if (!$request->hasFile('image') && empty($request->message)) {
            return redirect()->back()->with('error', 'Silakan ketik pesan atau pilih gambar');
        }

        $messageData = [
            'id_room' => $id,
            'sender_type' => 'customer',
            'sender_id' => $customerId,
        ];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chat_images', 'public');
            $messageData['message_type'] = 'image';
            $messageData['image_url'] = $imagePath;

            // TAMBAHIN INI: Simpan teks pesan juga kalo ada
            if ($request->message) {
                $messageData['isi_pesan'] = $request->message;
            }
        } else {
            $messageData['message_type'] = 'text';
            $messageData['isi_pesan'] = $request->message;
        }

        $message = ChatMessage::create($messageData);

        // Update last message timestamp
        $chatRoom->updateLastMessage();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender')
            ]);
        }

        return redirect()->back()->with('success', 'Pesan berhasil dikirim');
    }

    // Get unread messages count
    public function getUnreadCount()
    {
        $customerId = Auth::guard('customer')->id();

        $unreadCount = ChatMessage::whereHas('room', function ($query) use ($customerId) {
            $query->where('id_customers', $customerId);
        })
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }
}
