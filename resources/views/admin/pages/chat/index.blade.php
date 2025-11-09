{{-- resources/views/admin/pages/chat/index.blade.php --}}
@extends('admin.layouts.mainLayout')
@section('title', 'Chat Management')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Customer Service</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Chat</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Chat Stats -->
    <div class="row row-cols-1 row-cols-md-4 g-3 mb-4">
        <div class="col">
            <div class="card bg-primary bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-0">{{ $stats['active'] }}</h5>
                            <p class="mb-0">Active Chats</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-primary text-white rounded-circle p-3">
                                <ion-icon name="chatbubbles"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-warning bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-0">{{ $stats['unassigned'] }}</h5>
                            <p class="mb-0">Unassigned</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-warning text-white rounded-circle p-3">
                                <ion-icon name="warning"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-success bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-0">{{ $stats['resolved'] }}</h5>
                            <p class="mb-0">Resolved</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-success text-white rounded-circle p-3">
                                <ion-icon name="checkmark-done"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card bg-info bg-opacity-10 border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h5 class="mb-0">{{ $stats['my_chats'] }}</h5>
                            <p class="mb-0">My Chats</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="bg-info text-white rounded-circle p-3">
                                <ion-icon name="person"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chat Rooms Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">Chat Rooms</h5>
                <div class="d-flex gap-2">
                    <!-- Status Filter -->
                    <div class="btn-group">
                        <a href="{{ route('admin.chat.index', ['status' => 'all']) }}"
                            class="btn btn-outline-secondary {{ $status === 'all' ? 'active' : '' }}">All</a>
                        <a href="{{ route('admin.chat.index', ['status' => 'active']) }}"
                            class="btn btn-outline-primary {{ $status === 'active' ? 'active' : '' }}">Active</a>
                        <a href="{{ route('admin.chat.index', ['status' => 'resolved']) }}"
                            class="btn btn-outline-success {{ $status === 'resolved' ? 'active' : '' }}">Resolved</a>
                    </div>

                    <!-- Search Form -->
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search customer..." name="search"
                                value="{{ $search }}">
                            <button class="btn btn-primary" type="submit">
                                <ion-icon name="search-sharp"></ion-icon>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Last Message</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Last Activity</th>
                            <th>Unread</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($chatRooms as $room)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-light rounded-circle p-2">
                                                <ion-icon name="person-circle" class="fs-4"></ion-icon>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0">{{ $room->customer->nama_lengkap }}</h6>
                                            <small class="text-muted">{{ $room->customer->username }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if ($room->latestMessage)
                                        <small class="text-truncate d-inline-block" style="max-width: 200px;">
                                            {{ $room->latestMessage->isi_pesan ?: '📷 Image' }}
                                        </small>
                                    @else
                                        <small class="text-muted">No messages yet</small>
                                    @endif
                                </td>
                                <td>
                                    @if ($room->admin)
                                        @if ($room->admin->id_admin == Auth::guard('admin')->id())
                                            <span class="badge bg-success">You</span>
                                        @else
                                            <span class="badge bg-info">{{ $room->admin->nama_lengkap }}</span>
                                        @endif
                                    @else
                                        <span class="badge bg-warning">Unassigned</span>
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge bg-{{ $room->status === 'active' ? 'primary' : ($room->status === 'resolved' ? 'success' : 'warning') }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small>{{ $room->last_message_at ? $room->last_message_at->diffForHumans() : 'Never' }}</small>
                                </td>
                                <td>
                                    @php
                                        $unreadCount = $room->unreadMessages->count();
                                    @endphp
                                    @if ($unreadCount > 0)
                                        <span class="badge bg-danger">{{ $unreadCount }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <!-- TOMBOL OPEN/TAKE BERBEDA UNTUK PETUGAS -->
                                        @if (Auth::guard('admin')->user()->role === 'petugas')
                                            @if (!$room->admin)
                                                <!-- Petugas bisa take unassigned chat -->
                                                <a href="{{ route('admin.chat.show', $room->id_room) }}"
                                                    class="btn btn-success btn-sm">
                                                    <ion-icon name="hand-right"></ion-icon> Take
                                                </a>
                                            @elseif($room->admin->id_admin == Auth::guard('admin')->id())
                                                <!-- Petugas bisa buka chat yang dia assign -->
                                                <a href="{{ route('admin.chat.show', $room->id_room) }}"
                                                    class="btn btn-primary btn-sm">
                                                    <ion-icon name="chatbubbles"></ion-icon> Open
                                                </a>
                                            @else
                                                <!-- Petugas gabisa akses chat orang lain -->
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <ion-icon name="lock-closed"></ion-icon> Locked
                                                </button>
                                            @endif
                                        @else
                                            <!-- Admin bisa akses semua chat -->
                                            <a href="{{ route('admin.chat.show', $room->id_room) }}"
                                                class="btn btn-primary btn-sm">
                                                <ion-icon name="chatbubbles"></ion-icon> Open
                                            </a>
                                            @include('admin.modals.chat.assign-modal', ['room' => $room])
                                            @include('admin.modals.chat.status-modal', ['room' => $room])
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <ion-icon name="chatbubbles-outline" class="fs-1"></ion-icon>
                                        <p class="mt-2">No chat rooms found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <p class="mb-0">Showing {{ $chatRooms->firstItem() }} to {{ $chatRooms->lastItem() }} of
                        {{ $chatRooms->total() }} entries</p>
                </div>
                {{ $chatRooms->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto refresh every 30 seconds
        setInterval(function() {
            window.location.reload();
        }, 30000);
    </script>
@endpush
