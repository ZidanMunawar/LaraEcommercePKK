{{-- resources/views/admin/pages/chat/detail.blade.php --}}
@extends('admin.layouts.mainLayout')
@section('title', 'Chat dengan ' . $chatRoom->customer->nama_lengkap)

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Customer Service</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.chat.index') }}">Chat</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $chatRoom->customer->nama_lengkap }}</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <div class="btn-group">
                <!-- HANYA ADMIN YANG BISA ASSIGN DAN UPDATE STATUS -->
                @if (Auth::guard('admin')->user()->role === 'admin')
                    @include('admin.modals.chat.assign-modal', ['room' => $chatRoom])
                    @include('admin.modals.chat.status-modal', ['room' => $chatRoom])
                @endif
                <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                    <ion-icon name="arrow-back"></ion-icon> Back
                </button>
            </div>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <!-- Chat Header -->
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <div class="bg-light rounded-circle p-2">
                            @if ($chatRoom->customer->foto_profil)
                                <img src="{{ asset('storage/' . $chatRoom->customer->foto_profil) }}"
                                    alt="{{ $chatRoom->customer->nama_lengkap }}"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                            @else
                                <div
                                    style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 16px;">
                                    {{ substr($chatRoom->customer->nama_lengkap, 0, 1) }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h5 class="mb-0">{{ $chatRoom->customer->nama_lengkap }}</h5>
                        <small class="text-muted">{{ $chatRoom->customer->username }} •
                            {{ $chatRoom->customer->email }}</small>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span
                        class="badge bg-{{ $chatRoom->status === 'active' ? 'primary' : ($chatRoom->status === 'resolved' ? 'success' : 'warning') }}">
                        {{ ucfirst($chatRoom->status) }}
                    </span>
                    @if ($chatRoom->admin)
                        @if ($chatRoom->admin->id_admin == Auth::guard('admin')->id())
                            <span class="badge bg-success">Assigned to You</span>
                        @else
                            <span class="badge bg-info">Assigned to: {{ $chatRoom->admin->nama_lengkap }}</span>
                        @endif
                    @else
                        <span class="badge bg-warning">Unassigned</span>
                    @endif

                    <!-- INFO UNTUK PETUGAS -->
                    @if (Auth::guard('admin')->user()->role === 'petugas' && !$chatRoom->admin)
                        <span class="badge bg-success">Click Take to assign to yourself</span>
                    @endif
                </div>
            </div>

            <!-- Chat Messages -->
            <div class="chat-messages" id="chatMessages" style="height: 500px; overflow-y: auto;">
                @foreach ($chatRoom->messages as $message)
                    <div class="message-wrapper mb-3 {{ $message->sender_type === 'admin' ? 'text-end' : '' }}">
                        <div
                            class="d-flex {{ $message->sender_type === 'admin' ? 'justify-content-end' : 'justify-content-start' }}">
                            @if ($message->sender_type === 'customer')
                                <div class="flex-shrink-0 me-2">
                                    <div class="bg-light rounded-circle p-1">
                                        @if ($chatRoom->customer->foto_profil)
                                            <img src="{{ asset('storage/' . $chatRoom->customer->foto_profil) }}"
                                                alt="{{ $chatRoom->customer->nama_lengkap }}"
                                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <div
                                                style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px;">
                                                {{ substr($chatRoom->customer->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="flex-grow-0" style="max-width: 70%;">
                                <div
                                    class="card {{ $message->sender_type === 'admin' ? 'bg-primary text-white' : 'bg-light' }}">
                                    <div class="card-body p-3">
                                        @if ($message->message_type === 'image')
                                            <div class="text-center">
                                                <img src="{{ asset('storage/' . $message->image_url) }}" alt="Chat Image"
                                                    class="img-fluid rounded" style="max-height: 200px; cursor: pointer;"
                                                    onclick="openImageModal('{{ asset('storage/' . $message->image_url) }}')">
                                                @if ($message->isi_pesan)
                                                    <p class="mt-2 mb-0">{{ $message->isi_pesan }}</p>
                                                @endif
                                            </div>
                                        @else
                                            <p class="mb-0">{{ $message->isi_pesan }}</p>
                                        @endif
                                    </div>
                                </div>
                                <small class="text-muted mt-1 d-block">
                                    {{ $message->created_at->format('M j, H:i') }}
                                    @if ($message->is_read && $message->sender_type === 'admin')
                                        • <ion-icon name="checkmark-done" class="text-success"></ion-icon>
                                    @endif
                                </small>
                            </div>

                            @if ($message->sender_type === 'admin')
                                <div class="flex-shrink-0 ms-2">
                                    <div class="bg-primary rounded-circle p-1 text-white">
                                        @if ($message->sender->avatar)
                                            <img src="{{ asset('storage/' . $message->sender->avatar) }}"
                                                alt="{{ $message->sender->nama_lengkap }}"
                                                style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <div
                                                style="width: 35px; height: 35px; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; color: #007bff; font-weight: bold; font-size: 14px;">
                                                {{ substr($message->sender->nama_lengkap, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
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
                            <p class="mb-0 mt-1" style="font-size: 0.9rem;">Chat ini telah ditandai sebagai resolved dan
                                tidak dapat menerima pesan baru.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Chat Input - HILANG KALO RESOLVED ATAU PETUGAS GA BISA AKSES -->
            @if ($chatRoom->status !== 'resolved')
                @if (Auth::guard('admin')->user()->role === 'admin' ||
                        (Auth::guard('admin')->user()->role === 'petugas' &&
                            $chatRoom->admin &&
                            $chatRoom->admin->id_admin == Auth::guard('admin')->id()))
                    <div class="chat-input border-top pt-3">
                        <form action="{{ route('admin.chat.send', $chatRoom->id_room) }}" method="POST"
                            enctype="multipart/form-data" id="chatForm">
                            @csrf
                            <div class="input-group">
                                <input type="file" name="image" id="imageInput" class="d-none" accept="image/*">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="document.getElementById('imageInput').click()">
                                    <ion-icon name="image"></ion-icon>
                                </button>
                                <input type="text" name="message" class="form-control"
                                    placeholder="Type your message...">
                                <button type="submit" class="btn btn-primary">
                                    <ion-icon name="send"></ion-icon> Send
                                </button>
                            </div>
                            <div id="imagePreview" class="mt-2 d-none">
                                <div class="d-flex align-items-center bg-light rounded p-2">
                                    <img id="previewImg" src="" alt="Preview" class="img-thumbnail me-2"
                                        style="max-height: 50px;">
                                    <div class="flex-grow-1">
                                        <small id="fileName" class="d-block"></small>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                            onclick="clearImage()">
                                            <ion-icon name="close"></ion-icon>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @elseif(Auth::guard('admin')->user()->role === 'petugas' && !$chatRoom->admin)
                    <!-- PETUGAS BISA TAKE UNASSIGNED CHAT -->
                    <div class="chat-input border-top pt-3 text-center">
                        <div class="alert alert-warning mx-auto" style="max-width: 400px;">
                            <h6>Chat Belum Diassign</h6>
                            <p class="mb-3">Klik tombol di bawah untuk mengambil chat ini</p>
                            <form action="{{ route('admin.chat.show', $chatRoom->id_room) }}" method="GET">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <ion-icon name="hand-right"></ion-icon> Take This Chat
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- PETUGAS GA BISA AKSES CHAT ORANG LAIN -->
                    <div class="chat-input border-top pt-3 text-center">
                        <div class="alert alert-danger mx-auto" style="max-width: 400px;">
                            <h6>Akses Ditolak</h6>
                            <p class="mb-0">Chat ini sudah diassign ke admin lain dan tidak dapat Anda akses.</p>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection

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
                fetch('{{ route('admin.chat.show', $chatRoom->id_room) }}')
                    .then(response => response.text())
                    .then(html => {
                        const currentScroll = document.getElementById('chatMessages').scrollTop;
                        const isAtBottom = currentScroll + document.getElementById('chatMessages')
                            .clientHeight >=
                            document.getElementById('chatMessages').scrollHeight - 50;

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
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Image Preview</h5>
                        <button type="button" class="btn-close" onclick="closeImageModal()"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="${src}" alt="Full size" class="img-fluid">
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
                alert('Please type a message or select an image');
                return;
            }

            // Biarkan form submit biasa
        });

        // Initial scroll to bottom
        document.addEventListener('DOMContentLoaded', scrollToBottom);
    </script>
@endpush
