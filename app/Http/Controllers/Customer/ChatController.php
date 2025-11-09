<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $adminId = Auth::guard('admin')->id();

        // Get all active chat rooms for this admin
        $chatRooms = ChatRoom::with(['customer', 'lastMessage'])
            ->where('id_admin', $adminId)
            ->active()
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.pages.chat.index', compact('chatRooms'));
    }

    public function getChatRoom($roomId)
    {
        $adminId = Auth::guard('admin')->id();

        $chatRoom = ChatRoom::with(['customer', 'messages.sender'])
            ->where('id_room', $roomId)
            ->where('id_admin', $adminId)
            ->firstOrFail();

        // Mark all messages as read
        ChatMessage::where('id_room', $roomId)
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json($chatRoom);
    }

    public function getMessages($roomId)
    {
        $adminId = Auth::guard('admin')->id();

        // Verify admin has access to this room
        $room = ChatRoom::where('id_room', $roomId)
            ->where('id_admin', $adminId)
            ->firstOrFail();

        $messages = ChatMessage::with('sender')
            ->where('id_room', $roomId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    public function sendMessage(Request $request, $roomId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'message_type' => 'sometimes|in:text,image,file'
        ]);

        $adminId = Auth::guard('admin')->id();

        // Verify admin has access to this room
        $room = ChatRoom::where('id_room', $roomId)
            ->where('id_admin', $adminId)
            ->firstOrFail();

        $message = ChatMessage::create([
            'id_room' => $roomId,
            'sender_type' => 'admin',
            'sender_id' => $adminId,
            'message_type' => $request->get('message_type', 'text'),
            'isi_pesan' => $request->message,
            'image_url' => $request->image_url,
            'file_name' => $request->file_name,
            'file_size' => $request->file_size,
        ]);

        // Update room updated_at
        $room->touch();

        // Broadcast event (jika menggunakan websockets)
        // broadcast(new NewChatMessage($message))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $message->load('sender')
        ]);
    }

    public function getUnreadCount()
    {
        $adminId = Auth::guard('admin')->id();

        $unreadCount = ChatMessage::whereHas('room', function ($query) use ($adminId) {
            $query->where('id_admin', $adminId);
        })
            ->where('sender_type', 'customer')
            ->where('is_read', false)
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }

    public function createRoom(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id_customers'
        ]);

        $adminId = Auth::guard('admin')->id();

        // Check if room already exists
        $existingRoom = ChatRoom::where('id_customers', $request->customer_id)
            ->where('id_admin', $adminId)
            ->active()
            ->first();

        if ($existingRoom) {
            return response()->json([
                'success' => true,
                'room_id' => $existingRoom->id_room,
                'message' => 'Room already exists'
            ]);
        }

        $customer = Customer::findOrFail($request->customer_id);

        $chatRoom = ChatRoom::create([
            'id_customers' => $request->customer_id,
            'id_admin' => $adminId,
            'room_name' => "Chat with " . $customer->nama_lengkap,
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'room_id' => $chatRoom->id_room,
            'message' => 'Chat room created successfully'
        ]);
    }

    public function closeRoom($roomId)
    {
        $adminId = Auth::guard('admin')->id();

        $chatRoom = ChatRoom::where('id_room', $roomId)
            ->where('id_admin', $adminId)
            ->firstOrFail();

        $chatRoom->update(['is_active' => false]);

        return response()->json([
            'success' => true,
            'message' => 'Chat room closed successfully'
        ]);
    }

    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:10240', // 10MB max
            'room_id' => 'required|exists:chat_rooms,id_room'
        ]);

        $adminId = Auth::guard('admin')->id();

        // Verify admin has access to this room
        $room = ChatRoom::where('id_room', $request->room_id)
            ->where('id_admin', $adminId)
            ->firstOrFail();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->store('chat_files', 'public');

            $messageType = 'file';
            if (strpos($file->getMimeType(), 'image/') === 0) {
                $messageType = 'image';
            }

            $message = ChatMessage::create([
                'id_room' => $request->room_id,
                'sender_type' => 'admin',
                'sender_id' => $adminId,
                'message_type' => $messageType,
                'isi_pesan' => $messageType === 'image' ? 'Mengirim gambar' : 'Mengirim file',
                'image_url' => $messageType === 'image' ? $filePath : null,
                'file_name' => $fileName,
                'file_size' => $file->getSize(),
            ]);

            // Update room updated_at
            $room->touch();

            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
                'file_url' => asset('storage/' . $filePath)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'File upload failed'
        ], 400);
    }
}
