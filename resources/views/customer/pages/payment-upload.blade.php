@extends('customer.layouts.app')

@section('title', 'Upload Payment Proof - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Upload Payment Proof</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><span>Payment</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if (session('info'))
                        <div class="alert alert-info alert-dismissible fade show">
                            <i class="fas fa-info-circle"></i> {{ session('info') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Order Summary -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-receipt"></i> Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Order Number:</strong><br>
                                    <span class="text-primary fs-5">{{ $transaction->transaction_id }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Total Amount:</strong><br>
                                    <span class="text-success fs-4 fw-bold">Rp
                                        {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-md-12">
                                    <strong>Payment Method:</strong><br>
                                    <span
                                        class="badge bg-info">{{ strtoupper(str_replace('_', ' ', $transaction->metode_pembayaran)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fa-solid fa-exclamation-triangle"></i> Complete Your Payment</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Transfer to:</h6>

                            @switch($transaction->metode_pembayaran)
                                @case('transfer_bca')
                                    <div class="alert alert-light border">
                                        <h6><strong>Bank BCA</strong></h6>
                                        <p class="mb-1">Account Number: <strong class="fs-5 text-primary">1234567890</strong></p>
                                        <p class="mb-0">Account Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('gopay')
                                    <div class="alert alert-light border">
                                        <h6><strong>GoPay</strong></h6>
                                        <p class="mb-1">Number: <strong class="fs-5 text-primary">081234567890</strong></p>
                                        <p class="mb-0">Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('dana')
                                    <div class="alert alert-light border">
                                        <h6><strong>DANA</strong></h6>
                                        <p class="mb-1">Number: <strong class="fs-5 text-primary">081234567890</strong></p>
                                        <p class="mb-0">Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('seabank')
                                    <div class="alert alert-light border">
                                        <h6><strong>SeaBank</strong></h6>
                                        <p class="mb-1">Account Number: <strong class="fs-5 text-primary">901234567890</strong>
                                        </p>
                                        <p class="mb-0">Account Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break
                            @endswitch

                            <div class="alert alert-danger mt-3">
                                <i class="fa-solid fa-exclamation-circle"></i>
                                <strong>Important:</strong> Transfer exactly <strong>Rp
                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <div class="card mb-4 border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-upload"></i> Upload Payment Proof (Required)</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-danger fw-bold mb-3">
                                <i class="fa-solid fa-info-circle"></i> You must upload payment proof to proceed!
                            </p>

                            <form id="uploadProofForm" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Upload Transfer Receipt / Screenshot <span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="form-control" name="payment_proof" id="payment_proof"
                                        accept="image/*" required>
                                    <small class="text-muted">Max file size: 2MB. Format: JPG, PNG, JPEG</small>
                                </div>

                                <div id="imagePreview" class="mb-3" style="display: none;">
                                    <label class="form-label">Preview:</label>
                                    <img id="preview" src="" alt="Preview" class="img-thumbnail d-block"
                                        style="max-width: 100%; max-height: 400px;">
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-danger btn-lg" id="btnUpload">
                                        <i class="fa-solid fa-upload"></i> Upload & Continue
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="text-center text-muted">
                        <small>Need help? <a href="{{ route('customer.contact') }}">Contact Support</a></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Image preview
            $('#payment_proof').change(function() {
                const file = this.files[0];
                if (file) {
                    if (file.size > 2048000) {
                        alert('File size must be less than 2MB!');
                        $(this).val('');
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                        $('#imagePreview').show();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Upload form
            $('#uploadProofForm').submit(function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const btn = $('#btnUpload');

                btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Uploading...');

                $.ajax({
                    url: '{{ route('customer.payment.upload', $transaction->id_transaksi) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            alert('Payment proof uploaded successfully!');
                            window.location.href = response.redirect_url;
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Failed to upload payment proof');
                        btn.prop('disabled', false).html(
                            '<i class="fa-solid fa-upload"></i> Upload & Continue');
                    }
                });
            });
        });
    </script>
@endpush
