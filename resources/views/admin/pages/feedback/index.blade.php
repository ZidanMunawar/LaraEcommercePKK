@extends('admin.layouts.mainLayout')
@section('title', 'Kelola Feedback')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Manajemen Feedback</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Feedback</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Feedback</p>
                            <h4 class="my-1" id="total-feedback">0</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-primary text-white">
                            <ion-icon name="chatbubbles-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Approved</p>
                            <h4 class="my-1 text-success" id="approved-feedback">0</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-success text-white">
                            <ion-icon name="checkmark-done-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Pending</p>
                            <h4 class="my-1 text-warning" id="pending-feedback">0</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-warning text-white">
                            <ion-icon name="time-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Avg Rating</p>
                            <h4 class="my-1 text-info" id="average-rating">0.0</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-info text-white">
                            <ion-icon name="star-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Semua Feedback</h5>
                <div class="ms-auto">
                    <form method="GET" class="d-flex gap-2">
                        <!-- Filter Status -->
                        <select name="status" class="form-select form-select-sm" id="status-filter">
                            <option value="">Semua Status</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        </select>

                        <!-- Filter Rating -->
                        <select name="rating" class="form-select form-select-sm" id="rating-filter">
                            <option value="">Semua Rating</option>
                            <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Bintang</option>
                            <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Bintang</option>
                            <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Bintang</option>
                            <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Bintang</option>
                            <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Bintang</option>
                        </select>

                        <!-- Search -->
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..."
                            id="search-input" value="{{ request('search') }}">
                    </form>
                </div>
            </div>

            <!-- TABLE UTAMA FEEDBACK -->
            <div class="table-responsive">
                <table class="table align-middle table-hover" id="feedback-table">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Rating</th>
                            <th>Pesan</th>
                            <th>Transaksi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div id="pagination-links" class="mt-3">
                <!-- Pagination will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modals -->
    @include('admin.modals.feedback.view-modal')
    @include('admin.modals.feedback.delete-modal')
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            loadFeedback();
            loadStatistics();

            // Load feedback data
            function loadFeedback(page = 1) {
                const status = $('#status-filter').val();
                const rating = $('#rating-filter').val();
                const search = $('#search-input').val();

                $.ajax({
                    url: '{{ route('admin.feedback.index') }}',
                    type: 'GET',
                    data: {
                        status: status,
                        rating: rating,
                        search: search,
                        page: page
                    },
                    success: function(response) {
                        $('#feedback-table tbody').html(response.html);
                        $('#pagination-links').html(response.pagination);
                    }
                });
            }

            // Load statistics
            function loadStatistics() {
                $.ajax({
                    url: '{{ route('admin.feedback.statistics') }}',
                    type: 'GET',
                    success: function(response) {
                        $('#total-feedback').text(response.total);
                        $('#approved-feedback').text(response.approved);
                        $('#pending-feedback').text(response.pending);
                        $('#average-rating').text(response.average_rating);
                    }
                });
            }

            // Event listeners
            $('#status-filter, #rating-filter').change(function() {
                loadFeedback();
            });

            $('#search-input').on('keyup', function() {
                loadFeedback();
            });

            // View feedback details
            $(document).on('click', '.view-feedback', function() {
                const feedbackId = $(this).data('id');

                $.ajax({
                    url: '{{ route('admin.feedback.show', '') }}/' + feedbackId,
                    type: 'GET',
                    success: function(response) {
                        const feedback = response.data;

                        // Populate modal dengan data feedback
                        $('#viewCustomerName').text(feedback.nama_pelanggan);
                        $('#viewCustomerEmail').text(feedback.customer?.email || 'N/A');
                        $('#viewRating').html(
                            '<span class="text-warning">' +
                            '⭐'.repeat(feedback.rating) +
                            '</span> (' + feedback.rating + '/5)'
                        );
                        $('#viewMessage').text(feedback.pesan);
                        $('#viewTransaction').text(
                            feedback.transaksi?.transaction_id ||
                            (feedback.transaksi ? '#' + feedback.transaksi.id_transaksi :
                                'N/A')
                        );
                        $('#viewDate').text(new Date(feedback.created_at).toLocaleDateString(
                            'id-ID', {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric',
                                hour: '2-digit',
                                minute: '2-digit'
                            }));

                        // Status badge
                        const statusBadge = feedback.is_approved ?
                            '<span class="badge bg-success">Disetujui</span>' :
                            '<span class="badge bg-warning">Menunggu</span>';
                        $('#viewStatus').html(statusBadge);

                        $('#viewFeedbackModal').modal('show');
                    }
                });
            });

            // Approve feedback
            $(document).on('click', '.approve-feedback', function() {
                const feedbackId = $(this).data('id');

                if (confirm('Apakah Anda yakin ingin menyetujui feedback ini?')) {
                    $.ajax({
                        url: '{{ route('admin.feedback.approve', '') }}/' + feedbackId,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            loadFeedback();
                            loadStatistics();
                        },
                        error: function(xhr) {
                            toastr.error('Terjadi kesalahan: ' + xhr.responseJSON?.message);
                        }
                    });
                }
            });

            // Reject feedback
            $(document).on('click', '.reject-feedback', function() {
                const feedbackId = $(this).data('id');

                if (confirm('Apakah Anda yakin ingin menolak feedback ini?')) {
                    $.ajax({
                        url: '{{ route('admin.feedback.reject', '') }}/' + feedbackId,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            toastr.success(response.message);
                            loadFeedback();
                            loadStatistics();
                        },
                        error: function(xhr) {
                            toastr.error('Terjadi kesalahan: ' + xhr.responseJSON?.message);
                        }
                    });
                }
            });

            // Delete feedback
            $(document).on('click', '.delete-feedback', function() {
                const feedbackId = $(this).data('id');
                $('#deleteFeedbackId').val(feedbackId);
                $('#deleteFeedbackModal').modal('show');
            });

            $('#confirmDeleteFeedback').click(function() {
                const feedbackId = $('#deleteFeedbackId').val();

                $.ajax({
                    url: '{{ route('admin.feedback.destroy', '') }}/' + feedbackId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        toastr.success(response.message);
                        $('#deleteFeedbackModal').modal('hide');
                        loadFeedback();
                        loadStatistics();
                    },
                    error: function(xhr) {
                        toastr.error('Terjadi kesalahan: ' + xhr.responseJSON?.message);
                    }
                });
            });
        });
    </script>
@endpush
