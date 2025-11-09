{{-- resources/views/customer/pages/chat/room.blade.php --}}
@extends('customer.layouts.app')

@section('title', 'Chat dengan Admin - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Chat Customer Service</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><a href="{{ route('customer.chat.index') }}">Chat</a></li>
                                    <li><span>Percakapan</span></li>
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
                    <div class="card" style="border: 2px solid #D4A574; border-radius: 12px;">
                        <!-- Chat Header -->
                        <div class="card-header"
                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); border-bottom: 2px solid #8B6F47;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    @if ($chatRoom->admin)
                                        <div class="flex-shrink-0 me-3">
                                            @if ($chatRoom->admin->avatar)
                                                <img src="{{ asset('storage/' . $chatRoom->admin->avatar) }}"
                                                    alt="{{ $chatRoom->admin->nama_lengkap }}"
                                                    style="width: 45px; height: 45px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                                            @else
                                                <div
                                                    style="width: 45px; height: 45px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; color: #8B6F47; font-weight: bold; font-size: 18px; border: 2px solid white;">
                                                    {{ substr($chatRoom->admin->nama_lengkap, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                    <div class="flex-grow-1">
                                        <h5 style="color: white; font-weight: 700; margin: 0;">
                                            {{ $chatRoom->admin ? $chatRoom->admin->nama_lengkap : 'Menunggu Admin' }}
                                        </h5>
                                        <small style="color: rgba(255,255,255,0.8);">
                                            @if ($chatRoom->admin)
                                                Admin ZynHope •
                                                <span class="badge bg-success">Online</span>
                                            @else
                                                <span class="badge bg-warning">Menunggu penugasan admin</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <span class="badge"
                                        style="background: {{ $chatRoom->status === 'active' ? '#28a745' : ($chatRoom->status === 'resolved' ? '#6c757d' : '#ffc107') }}; color: white;">
                                        {{ ucfirst($chatRoom->status) }}
                                    </span>
                                    <a href="{{ route('customer.chat.index') }}" class="btn btn-sm ms-2"
                                        style="background: white; color: #8B6F47; border: 1px solid white; border-radius: 6px; padding: 6px 12px; font-weight: 600;">
                                        <i class="bi bi-arrow-left me-1"></i> Kembali
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Chat Messages -->
                        <div class="card-body p-0">
                            <div class="chat-messages p-4" id="chatMessages"
                                style="height: 500px; overflow-y: auto; background: #f9f7f4;">

                                @foreach ($chatRoom->messages as $message)
                                    <div
                                        class="message-wrapper mb-4 {{ $message->sender_type === 'customer' ? 'text-end' : '' }}">
                                        <div
                                            class="d-flex {{ $message->sender_type === 'customer' ? 'justify-content-end' : 'justify-content-start' }} align-items-end">
                                            @if ($message->sender_type === 'admin')
                                                <div class="flex-shrink-0 me-3">
                                                    @if ($message->sender->avatar)
                                                        <img src="{{ asset('storage/' . $message->sender->avatar) }}"
                                                            alt="{{ $message->sender->nama_lengkap }}"
                                                            style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                                                    @else
                                                        <div
                                                            style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; border: 2px solid white;">
                                                            {{ substr($message->sender->nama_lengkap, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif

                                            <div class="flex-grow-0" style="max-width: 70%;">
                                                <div class="card {{ $message->sender_type === 'customer' ? '' : '' }}"
                                                    style="border: 2px solid {{ $message->sender_type === 'customer' ? '#A0826D' : '#D4A574' }};
                                                        background: {{ $message->sender_type === 'customer' ? 'linear-gradient(135deg, #A0826D, #8B6F47)' : '#FFFFFF' }};
                                                        border-radius: 18px;
                                                        {{ $message->sender_type === 'customer' ? 'border-bottom-right-radius: 4px;' : 'border-bottom-left-radius: 4px;' }}">
                                                    <div class="card-body p-3">
                                                        @if ($message->message_type === 'image')
                                                            <div class="text-center">
                                                                <img src="{{ asset('storage/' . $message->image_url) }}"
                                                                    alt="Chat Image" class="img-fluid rounded"
                                                                    style="max-height: 200px; cursor: pointer;"
                                                                    onclick="openImageModal('{{ asset('storage/' . $message->image_url) }}')">
                                                                @if ($message->isi_pesan)
                                                                    <p class="mt-2 mb-0"
                                                                        style="color: {{ $message->sender_type === 'customer' ? 'white' : '#2c2c2c' }};">
                                                                        {{ $message->isi_pesan }}</p>
                                                                @endif
                                                            </div>
                                                        @else
                                                            <p class="mb-0"
                                                                style="color: {{ $message->sender_type === 'customer' ? 'white' : '#2c2c2c' }};">
                                                                {{ $message->isi_pesan }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                                <small class="text-muted mt-1 d-block" style="color: #8B6F47 !important;">
                                                    {{ $message->created_at->format('H:i') }} •
                                                    {{ $message->created_at->format('M j') }}
                                                    @if ($message->is_read && $message->sender_type === 'customer')
                                                        • <i class="bi bi-check2-all text-success"></i>
                                                    @endif
                                                </small>
                                            </div>

                                            @if ($message->sender_type === 'customer')
                                                <div class="flex-shrink-0 ms-3">
                                                    @if (Auth::guard('customer')->user()->foto_profil)
                                                        <img src="{{ asset('storage/' . Auth::guard('customer')->user()->foto_profil) }}"
                                                            alt="{{ Auth::guard('customer')->user()->nama_lengkap }}"
                                                            style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid #f9f7f4;">
                                                    @else
                                                        <div
                                                            style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; border: 2px solid #f9f7f4;">
                                                            {{ substr(Auth::guard('customer')->user()->nama_lengkap, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pesan Resolved -->
                                @if ($chatRoom->status === 'resolved')
                                    <div class="text-center py-4">
                                        <div class="alert alert-info mx-auto"
                                            style="max-width: 400px; background: #e8f4fd; border: 1px solid #b8daff; color: #004085; border-radius: 10px;">
                                            <i class="bi bi-check-circle-fill me-2" style="color: #28a745;"></i>
                                            <strong>Percakapan ini telah selesai</strong>
                                            <p class="mb-0 mt-1" style="font-size: 0.9rem;">Chat ini telah ditandai sebagai
                                                resolved dan tidak dapat menerima pesan baru.</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Chat Input - HILANG KALO RESOLVED -->
                        @if ($chatRoom->status !== 'resolved')
                            <div class="card-footer" style="background: white; border-top: 2px solid #D4A574;">
                                <form action="{{ route('customer.chat.send', $chatRoom->id_room) }}" method="POST"
                                    enctype="multipart/form-data" id="chatForm">
                                    @csrf
                                    <div class="input-group">
                                        <input type="file" name="image" id="imageInput" class="d-none"
                                            accept="image/*">
                                        <button type="button" class="btn"
                                            onclick="document.getElementById('imageInput').click()"
                                            style="background: #D4A574; color: white; border: 2px solid #D4A574; border-radius: 8px 0 0 8px; padding: 12px;">
                                            <i class="bi bi-image"></i>
                                        </button>
                                        <input type="text" name="message" class="form-control"
                                            placeholder="Ketik pesan Anda...">
                                        <button type="submit" class="btn"
                                            style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; border: 2px solid #8B6F47; border-radius: 0 8px 8px 0; padding: 12px 20px;">
                                            <i class="bi bi-send-fill"></i>
                                        </button>
                                    </div>
                                    <div id="imagePreview" class="mt-2 d-none">
                                        <div class="d-flex align-items-center rounded p-2"
                                            style="border: 1px solid #D4A574; background: #f9f7f4;">
                                            <img id="previewImg" src="" alt="Preview"
                                                class="img-thumbnail me-2"
                                                style="max-height: 50px; border: 1px solid #D4A574;">
                                            <div class="flex-grow-1">
                                                <small id="fileName" class="d-block" style="color: #8B6F47;"></small>
                                                <button type="button" class="btn btn-sm mt-1" onclick="clearImage()"
                                                    style="background: #dc3545; color: white; border: none; border-radius: 4px; padding: 2px 6px;">
                                                    <i class="bi bi-x me-1"></i> Hapus
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #D4A574;
            border-radius: 10px;
        }

        .chat-messages::-webkit-scrollbar-thumb:hover {
            background: #A0826D;
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Auto scroll to bottom
        function scrollToBottom() {
            const container = document.getElementById('chatMessages');
            container.scrollTop = container.scrollHeight;
        }

        // Auto refresh messages every 30 seconds - HANYA UNTUK ACTIVE CHAT
        @if ($chatRoom->status === 'active')
            setInterval(function() {
                fetch('{{ route('customer.chat.room', $chatRoom->id_room) }}')
                    .then(response => response.text())
                    .then(html => {
                        const currentScroll = document.getElementById('chatMessages').scrollTop;
                        const isAtBottom = currentScroll + document.getElementById('chatMessages')
                            .clientHeight >=
                            document.getElementById('chatMessages').scrollHeight - 100;

                        if (isAtBottom) {
                            window.location.reload();
                        }
                    });
            }, 30000); // 30 detik
        @endif

        // Image preview
        document.getElementById('imageInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewImg').src = e.target.result;
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('imagePreview').classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        });

        function clearImage() {
            document.getElementById('imageInput').value = '';
            document.getElementById('imagePreview').classList.add('d-none');
        }

        function openImageModal(src) {
            const modal = document.createElement('div');
            modal.className = 'modal fade show d-block';
            modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
            modal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content" style="border: 2px solid #D4A574; border-radius: 12px;">
                    <div class="modal-header" style="background: linear-gradient(135deg, #A0826D, #8B6F47); border-bottom: 2px solid #8B6F47;">
                        <h5 class="modal-title" style="color: white; font-weight: 700;">Preview Gambar</h5>
                        <button type="button" class="btn-close" style="filter: invert(1);" onclick="closeImageModal()"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <img src="${src}" alt="Full size" class="img-fluid rounded" style="max-height: 70vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        `;
            document.body.appendChild(modal);

            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeImageModal();
            });
        }

        function closeImageModal() {
            const modal = document.querySelector('.modal');
            if (modal) modal.remove();
        }

        // Form submission - BISA KIRIM GAMBAR SAJA
        document.getElementById('chatForm')?.addEventListener('submit', function(e) {
            const messageInput = this.querySelector('input[name="message"]');
            const imageInput = this.querySelector('input[name="image"]');

            // BOLEH KIRIM GAMBAR SAJA TANPA PESAN
            if (!messageInput.value && !imageInput.files[0]) {
                e.preventDefault();
                alert('Silakan ketik pesan atau pilih gambar');
                return;
            }

            // Biarkan form submit biasa
        });

        // Initial scroll to bottom
        document.addEventListener('DOMContentLoaded', scrollToBottom);
    </script>
@endpush
