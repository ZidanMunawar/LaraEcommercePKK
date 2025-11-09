{{-- resources/views/customer/pages/chat/index.blade.php --}}
@extends('customer.layouts.app')

@section('title', 'Chat Customer Service - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Customer Service</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Chat Customer Service</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="checkout-area section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if ($chatRooms->isEmpty())
                        <!-- Start New Chat Card -->
                        <div class="card mb-4" style="border: 2px solid #D4A574; border-radius: 12px;">
                            <div class="card-body text-center p-5">
                                <div class="mb-4">
                                    <ion-icon name="chatbubbles" style="font-size: 4rem; color: #A0826D;"></ion-icon>
                                </div>
                                <h3 style="color: #A0826D; font-weight: 700; margin-bottom: 20px;">Mulai Percakapan Baru
                                </h3>
                                <p style="color: #666; margin-bottom: 30px;">Tim customer service kami siap membantu Anda
                                    dengan senang hati</p>

                                <button type="button" class="btn btn-lg" data-bs-toggle="modal"
                                    data-bs-target="#startChatModal"
                                    style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; font-weight: 700; border: none; border-radius: 8px; padding: 12px 30px;">
                                    <ion-icon name="add-circle" class="me-2"></ion-icon>Mulai Chat Baru
                                </button>
                            </div>
                        </div>
                    @else
                        <!-- Existing Chats -->
                        <div class="card" style="border: 2px solid #D4A574; border-radius: 12px;">
                            <div class="card-header"
                                style="background: linear-gradient(135deg, #E8D4B8, #D4A574); border-bottom: 2px solid #D4A574;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 style="color: #8B6F47; font-weight: 700; margin: 0;">Percakapan Saya</h4>
                                    <button type="button" class="btn btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#startChatModal"
                                        style="background: #A0826D; color: white; border: none; border-radius: 6px; padding: 8px 15px;">
                                        <ion-icon name="add" class="me-1"></ion-icon>Chat Baru
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @foreach ($chatRooms as $room)
                                    <div class="chat-room-item p-4 border-bottom"
                                        style="cursor: pointer; transition: background-color 0.3s;"
                                        onclick="window.location.href='{{ route('customer.chat.room', $room->id_room) }}'"
                                        onmouseover="this.style.backgroundColor='#f5f1ed'"
                                        onmouseout="this.style.backgroundColor='transparent'">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <div class="d-flex align-items-center mb-2">
                                                    @if ($room->admin)
                                                        <div class="flex-shrink-0 me-3">
                                                            <div
                                                                style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                                                {{ substr($room->admin->nama_lengkap, 0, 1) }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <h6 style="color: #8B6F47; font-weight: 700; margin: 0;">
                                                            {{ $room->admin ? $room->admin->nama_lengkap : 'Menunggu Admin' }}
                                                        </h6>
                                                        <small style="color: #666;">
                                                            {{ $room->admin ? 'Admin' : 'Belum ditugaskan' }}
                                                        </small>
                                                    </div>
                                                </div>

                                                @if ($room->latestMessage)
                                                    <p class="mb-1" style="color: #2c2c2c;">
                                                        {{ Str::limit($room->latestMessage->isi_pesan, 80) }}
                                                    </p>
                                                    <small style="color: #888;">
                                                        {{ $room->latestMessage->created_at->diffForHumans() }}
                                                    </small>
                                                @endif
                                            </div>

                                            <div class="flex-shrink-0 text-end">
                                                <span class="badge"
                                                    style="background: {{ $room->status === 'active' ? '#28a745' : ($room->status === 'resolved' ? '#6c757d' : '#ffc107') }}; color: white;">
                                                    {{ ucfirst($room->status) }}
                                                </span>

                                                @php
                                                    $unreadCount = $room
                                                        ->messages()
                                                        ->where('sender_type', 'admin')
                                                        ->where('is_read', false)
                                                        ->count();
                                                @endphp
                                                @if ($unreadCount > 0)
                                                    <span class="badge bg-danger ms-1">{{ $unreadCount }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Start Chat Modal -->
    <div class="modal fade" id="startChatModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border: 2px solid #D4A574; border-radius: 12px;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #E8D4B8, #D4A574); border-bottom: 2px solid #D4A574;">
                    <h5 class="modal-title" style="color: #8B6F47; font-weight: 700;">Mulai Chat Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('customer.chat.start') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="subject" class="form-label" style="color: #8B6F47; font-weight: 600;">Subjek
                                Percakapan <span style="color: #dc3545;">*</span></label>
                            <input type="text" class="form-control" id="subject" name="subject" required
                                placeholder="Contoh: Pertanyaan tentang produk, Keluhan pengiriman, dll."
                                style="border: 2px solid #D4A574; border-radius: 8px; padding: 12px;">
                            <div class="form-text" style="color: #666;">
                                Jelaskan secara singkat apa yang ingin Anda tanyakan atau laporkan.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            style="border: 2px solid #D4A574; border-radius: 8px; padding: 10px 20px;">Batal</button>
                        <button type="submit" class="btn"
                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; font-weight: 700; border: none; border-radius: 8px; padding: 10px 20px;">
                            <ion-icon name="chatbubbles" class="me-2"></ion-icon>Mulai Chat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto refresh unread count
        function updateUnreadCount() {
            fetch('{{ route('customer.chat.unread.count') }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('unreadBadge');
                    if (badge) {
                        if (data.unread_count > 0) {
                            badge.textContent = data.unread_count;
                            badge.style.display = 'inline';
                        } else {
                            badge.style.display = 'none';
                        }
                    }
                });
        }

        // Update every 30 seconds
        setInterval(updateUnreadCount, 30000);
        updateUnreadCount(); // Initial call
    </script>
@endpush
