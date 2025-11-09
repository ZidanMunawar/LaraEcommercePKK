<?php
// app/Http/Controllers/Admin/ChatController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\Customer;
use App\Models\AdminChatAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Menampilkan daftar chat room
    public function index(Request $request)
    {
        $status = $request->get('status', 'active');
        $search = $request->get('search');

        $chatRooms = ChatRoom::with(['customer', 'admin', 'latestMessage'])
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->when($search, function ($query) use ($search) {
                return $query->whereHas('customer', function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('username', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_message_at', 'desc')
            ->paginate(15);

        $stats = [
            'active' => ChatRoom::where('status', 'active')->count(),
            'unassigned' => ChatRoom::where('status', 'active')->whereNull('id_admin')->count(),
            'resolved' => ChatRoom::where('status', 'resolved')->count(),
            'my_chats' => ChatRoom::where('id_admin', Auth::guard('admin')->id())->where('status', 'active')->count(),
        ];

        return view('admin.pages.chat.index', compact('chatRooms', 'stats', 'status', 'search'));
    }

    // Menampilkan detail chat room
    public function show($id)
    {
        $chatRoom = ChatRoom::with(['customer', 'admin', 'messages.sender'])
            ->findOrFail($id);

        // Mark messages as read
        ChatMessage::where('id_room', $id)
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        // Jika chat belum ditugaskan, assign ke admin saat ini
        if (!$chatRoom->id_admin && $chatRoom->status === 'active') {
            $chatRoom->update(['id_admin' => Auth::guard('admin')->id()]);

            // Record assignment
            AdminChatAssignment::create([
                'id_room' => $chatRoom->id_room,
                'id_admin' => Auth::guard('admin')->id(),
                'assigned_at' => now(),
                'is_active' => true
            ]);
        }

        return view('admin.pages.chat.detail', compact('chatRoom'));
    }

    // Mengirim pesan sebagai admin
    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000', // Diubah jadi nullable
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $chatRoom = ChatRoom::findOrFail($id);

        // Validasi: harus ada message ATAU image
        if (!$request->hasFile('image') && empty($request->message)) {
            return redirect()->back()->with('error', 'Silakan ketik pesan atau pilih gambar');
        }

        $messageData = [
            'id_room' => $id,
            'sender_type' => 'admin',
            'sender_id' => Auth::guard('admin')->id(),
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


    // Mengupdate status chat room
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,resolved,pending'
        ]);

        $chatRoom = ChatRoom::findOrFail($id);
        $chatRoom->update(['status' => $request->status]);

        // Jika status diubah ke resolved, unassign admin
        if ($request->status === 'resolved') {
            AdminChatAssignment::where('id_room', $id)
                ->where('is_active', true)
                ->update([
                    'is_active' => false,
                    'unassigned_at' => now()
                ]);
        }

        return redirect()->back()->with('success', 'Status chat berhasil diupdate');
    }

    // Assign chat ke admin lain
    public function assignToAdmin(Request $request, $id)
    {
        $request->validate([
            'id_admin' => 'required|exists:admins,id_admin'
        ]);

        $chatRoom = ChatRoom::findOrFail($id);

        // Deactivate current assignment
        AdminChatAssignment::where('id_room', $id)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'unassigned_at' => now()
            ]);

        // Update chat room
        $chatRoom->update(['id_admin' => $request->id_admin]);

        // Create new assignment
        AdminChatAssignment::create([
            'id_room' => $id,
            'id_admin' => $request->id_admin,
            'assigned_at' => now(),
            'is_active' => true
        ]);

        return redirect()->back()->with('success', 'Chat berhasil ditugaskan ke admin lain');
    }

    // Get unread messages count (for notifications)
    public function getUnreadCount()
    {
        $unreadCount = ChatMessage::where('sender_type', 'customer')
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    // Get latest chats for sidebar
    public function getLatestChats()
    {
        $latestChats = ChatRoom::with(['customer', 'latestMessage'])
            ->where('status', 'active')
            ->orderBy('last_message_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json($latestChats);
    }
}
