@extends('customer.layouts.app')

@section('title', 'Order Success - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Order Successful</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><span>Order Success</span></li>
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
                    <!-- Success Message -->
                    <div class="text-center mb-5">
                        <div class="mb-4">
                            <div class="success-icon" style="font-size: 80px; color: #28a745;">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                        </div>
                        <h2 class="mb-3">Thank You for Your Order!</h2>
                        <p class="text-muted">Your order has been placed successfully. Please complete payment to process
                            your order.</p>
                    </div>

                    <!-- Order Details -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-receipt"></i> Order Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <strong>Order Number:</strong><br>
                                    <span class="text-primary fs-5">{{ $transaction->transaction_id }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Order Date:</strong><br>
                                    {{ $transaction->created_at->format('d M Y, H:i') }}
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Total Amount:</strong><br>
                                    <span class="text-success fs-5">Rp
                                        {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <strong>Payment Status:</strong><br>
                                    <span class="badge bg-warning">{{ ucfirst($transaction->payment_status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-credit-card"></i> Payment Instructions</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-3">Payment Method:
                                <strong>{{ strtoupper(str_replace('_', ' ', $transaction->metode_pembayaran)) }}</strong>
                            </h6>

                            @switch($transaction->metode_pembayaran)
                                @case('transfer_bca')
                                    <div class="alert alert-light border">
                                        <h6><strong>Bank BCA</strong></h6>
                                        <p class="mb-1">Account Number: <strong class="fs-5">1234567890</strong></p>
                                        <p class="mb-0">Account Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('transfer_bni')
                                    <div class="alert alert-light border">
                                        <h6><strong>Bank BNI</strong></h6>
                                        <p class="mb-1">Account Number: <strong class="fs-5">0987654321</strong></p>
                                        <p class="mb-0">Account Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('transfer_mandiri')
                                    <div class="alert alert-light border">
                                        <h6><strong>Bank Mandiri</strong></h6>
                                        <p class="mb-1">Account Number: <strong class="fs-5">1122334455</strong></p>
                                        <p class="mb-0">Account Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('gopay')
                                    <div class="alert alert-light border">
                                        <h6><strong>GoPay</strong></h6>
                                        <p class="mb-1">Number: <strong class="fs-5">081234567890</strong></p>
                                        <p class="mb-0">Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('dana')
                                    <div class="alert alert-light border">
                                        <h6><strong>DANA</strong></h6>
                                        <p class="mb-1">Number: <strong class="fs-5">081234567890</strong></p>
                                        <p class="mb-0">Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break

                                @case('seabank')
                                    <div class="alert alert-light border">
                                        <h6><strong>SeaBank</strong></h6>
                                        <p class="mb-1">Account Number: <strong class="fs-5">901234567890</strong></p>
                                        <p class="mb-0">Account Name: <strong>ZynHope Apparel</strong></p>
                                    </div>
                                @break
                            @endswitch

                            <div class="alert alert-warning mt-3">
                                <i class="fa-solid fa-exclamation-triangle"></i>
                                <strong>Important:</strong> Please transfer the exact amount and upload payment proof below.
                            </div>
                        </div>
                    </div>

                    <!-- Upload Payment Proof -->
                    <div class="card mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="fa-solid fa-cloud-arrow-up"></i> Upload Payment Proof</h5>
                        </div>
                        <div class="card-body">
                            @if ($transaction->payment_proof)
                                <div class="alert alert-success">
                                    <i class="fa-solid fa-check-circle"></i>
                                    <strong>Payment proof uploaded!</strong>
                                    <br>Uploaded at: {{ $transaction->payment_proof_uploaded_at->format('d M Y, H:i') }}
                                    <br>
                                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank"
                                        class="btn btn-sm btn-primary mt-2">
                                        View Uploaded Proof
                                    </a>
                                </div>
                            @else
                                <form id="uploadProofForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Upload Transfer Receipt / Screenshot <span
                                                class="text-danger">*</span></label>
                                        <input type="file" class="form-control" name="payment_proof" accept="image/*"
                                            required>
                                        <small class="text-muted">Max file size: 2MB. Accepted formats: JPG, PNG,
                                            JPEG</small>
                                    </div>
                                    <div id="imagePreview" class="mb-3" style="display: none;">
                                        <img id="preview" src="" alt="Preview" class="img-thumbnail"
                                            style="max-width: 300px;">
                                    </div>
                                    <button type="submit" class="btn btn-success btn-lg w-100" id="btnUpload">
                                        <i class="fa-solid fa-upload"></i> Upload Payment Proof
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0"><i class="fa-solid fa-box"></i> Order Items</h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->details as $detail)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if ($detail->produk->images->isNotEmpty())
                                                            <img src="{{ asset('storage/' . $detail->produk->images->first()->image_url) }}"
                                                                alt="{{ $detail->produk->name }}"
                                                                style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;"
                                                                class="me-2">
                                                        @endif
                                                        <div>
                                                            <strong>{{ $detail->produk->name }}</strong>
                                                            @if ($detail->size || $detail->color)
                                                                <br>
                                                                <small class="text-muted">
                                                                    @if ($detail->size)
                                                                        Size: {{ $detail->size->size }}
                                                                    @endif
                                                                    @if ($detail->color)
                                                                        | Color: {{ $detail->color->name }}
                                                                    @endif
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                                <td>{{ $detail->qty }}</td>
                                                <td><strong>Rp
                                                        {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</strong>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr class="table-light">
                                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                                            <td><strong>Rp
                                                    {{ number_format($transaction->subtotal, 0, ',', '.') }}</strong></td>
                                        </tr>
                                        <tr class="table-light">
                                            <td colspan="3" class="text-end"><strong>Shipping Cost:</strong></td>
                                            <td><strong>Rp
                                                    {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                        <tr class="table-success">
                                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                            <td><strong class="text-success fs-5">Rp
                                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="text-center">
                        <a href="{{ route('customer.orders') }}" class="btn btn-primary btn-lg me-2">
                            <i class="fa-solid fa-box"></i> View My Orders
                        </a>
                        <a href="{{ route('customer.home') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fa-solid fa-home"></i> Back to Home
                        </a>
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
            $('input[name="payment_proof"]').change(function() {
                const file = this.files[0];
                if (file) {
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
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Failed to upload payment proof');
                        btn.prop('disabled', false).html(
                            '<i class="fa-solid fa-upload"></i> Upload Payment Proof');
                    }
                });
            });
        });
    </script>
@endpush
