@extends('customer.layouts.app')

@section('title', 'Order Success - ZynHope Apparel')

@section('content')
    <!-- Success Header -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title text-white">Order Confirmed!</h2>
                        <p class="text-white opacity-75 mb-0">Your order has been successfully placed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section-space success-brown-theme">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <!-- Success Alert -->
                    <div class="success-alert-card mb-5">
                        <div class="success-alert-content">
                            <div class="success-alert-icon">
                                <i class="bi bi-check-circle-fill"></i>
                            </div>
                            <div class="success-alert-text">
                                <h4 class="mb-2">Thank You for Your Order!</h4>
                                <p class="mb-0">
                                    We've received your order and will process it immediately. Please complete the payment
                                    to proceed with shipping.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Left Column - Order & Payment Info -->
                        <div class="col-lg-8">
                            <!-- Order Summary Card -->
                            <div class="success-card mb-4">
                                <div class="success-card-header">
                                    <i class="bi bi-receipt me-2"></i>
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <div class="success-card-body">
                                    <div class="row g-3">
                                        <div class="col-sm-6">
                                            <div class="info-item">
                                                <span class="info-label">Order Number</span>
                                                <span
                                                    class="info-value text-primary">{{ $transaction->transaction_id }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="info-item">
                                                <span class="info-label">Order Date</span>
                                                <span
                                                    class="info-value">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="info-item">
                                                <span class="info-label">Total Amount</span>
                                                <span class="info-value text-success">Rp
                                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="info-item">
                                                <span class="info-label">Payment Status</span>
                                                <span class="info-value">
                                                    <span
                                                        class="status-badge status-pending">{{ ucfirst($transaction->payment_status) }}</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Method Card -->
                            <div class="success-card mb-4">
                                <div class="success-card-header">
                                    <i class="bi bi-credit-card me-2"></i>
                                    <h5 class="mb-0">Payment Method</h5>
                                </div>
                                <div class="success-card-body">
                                    <div class="payment-method">
                                        <div class="payment-method-header mb-3">
                                            <h6 class="mb-1">
                                                {{ strtoupper(str_replace('_', ' ', $transaction->metode_pembayaran)) }}
                                            </h6>
                                            <p class="text-muted mb-0">Please transfer the exact amount to the account below
                                            </p>
                                        </div>

                                        @switch($transaction->metode_pembayaran)
                                            @case('transfer_bca')
                                                <div class="bank-details">
                                                    <div class="bank-logo"><i class="bi bi-bank" style="color: #0066a7;"></i></div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">Bank BCA</h6>
                                                        <div class="account-number">1234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('transfer_bni')
                                                <div class="bank-details">
                                                    <div class="bank-logo"><i class="bi bi-bank" style="color: #0066a7;"></i></div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">Bank BNI</h6>
                                                        <div class="account-number">0987654321</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('transfer_mandiri')
                                                <div class="bank-details">
                                                    <div class="bank-logo"><i class="bi bi-bank" style="color: #0066a7;"></i></div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">Bank Mandiri</h6>
                                                        <div class="account-number">1122334455</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('gopay')
                                                <div class="bank-details">
                                                    <div class="bank-logo"><i class="bi bi-phone" style="color: #00aa13;"></i></div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">GoPay</h6>
                                                        <div class="account-number">081234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('dana')
                                                <div class="bank-details">
                                                    <div class="bank-logo"><i class="bi bi-phone" style="color: #108ee9;"></i></div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">DANA</h6>
                                                        <div class="account-number">081234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('seabank')
                                                <div class="bank-details">
                                                    <div class="bank-logo"><i class="bi bi-bank" style="color: #0066a7;"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">SeaBank</h6>
                                                        <div class="account-number">901234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break
                                        @endswitch

                                        <div class="payment-alert mt-3">
                                            <i class="bi bi-exclamation-triangle me-2"></i>
                                            <span>Please complete payment within 24 hours to avoid order cancellation</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Payment Proof -->
                            <div class="success-card">
                                <div class="success-card-header">
                                    <i class="bi bi-cloud-upload me-2"></i>
                                    <h5 class="mb-0">Upload Payment Proof</h5>
                                </div>
                                <div class="success-card-body">
                                    @if ($transaction->payment_proof)
                                        <div class="upload-success">
                                            <div class="upload-success-icon">
                                                <i class="bi bi-check-circle-fill"></i>
                                            </div>
                                            <div class="upload-success-content">
                                                <h6 class="mb-1">Payment Proof Uploaded!</h6>
                                                <p class="text-muted mb-2">Uploaded at:
                                                    {{ $transaction->payment_proof_uploaded_at->format('d M Y, H:i') }}</p>
                                                <button type="button" class="btn-view-proof"
                                                    onclick="viewPaymentProof()">
                                                    <i class="bi bi-eye me-1"></i>View Proof
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <form id="uploadProofForm" enctype="multipart/form-data">
                                            @csrf
                                            <div class="upload-area" id="uploadArea">
                                                <div class="upload-placeholder" id="uploadPlaceholder">
                                                    <i class="bi bi-cloud-arrow-up"></i>
                                                    <p class="mb-1">Click to upload payment proof</p>
                                                    <small class="text-muted">Max 2MB • JPG, PNG, JPEG</small>
                                                </div>
                                                <input type="file" class="d-none" name="payment_proof"
                                                    accept="image/jpeg,image/png,image/jpg" required
                                                    id="paymentProofInput">
                                                <div id="imagePreview" class="upload-preview" style="display: none;">
                                                    <img id="preview" src="" alt="Preview">
                                                    <button type="button" class="btn-remove-preview"
                                                        onclick="removePreview()">
                                                        <i class="bi bi-x"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn-upload w-100 mt-3" id="btnUpload">
                                                <i class="bi bi-upload me-2"></i>Upload Payment Proof
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Order Items -->
                        <div class="col-lg-4">
                            <div class="success-card">
                                <div class="success-card-header">
                                    <i class="bi bi-bag me-2"></i>
                                    <h5 class="mb-0">Order Items</h5>
                                </div>
                                <div class="success-card-body p-0">
                                    <div class="order-items">
                                        @foreach ($transaction->details as $detail)
                                            <div class="order-item">
                                                <div class="item-image">
                                                    @if ($detail->produk->images->isNotEmpty())
                                                        <img src="{{ asset('storage/' . $detail->produk->images->first()->image_url) }}"
                                                            alt="{{ $detail->produk->name }}">
                                                    @else
                                                        <div class="no-image">No Image</div>
                                                    @endif
                                                </div>
                                                <div class="item-details">
                                                    <h6 class="item-name">{{ Str::limit($detail->produk->name, 35) }}</h6>
                                                    @if ($detail->size || $detail->color)
                                                        <div class="item-variants">
                                                            @if ($detail->size)
                                                                <span class="variant">Size:
                                                                    {{ $detail->size->size }}</span>
                                                            @endif
                                                            @if ($detail->color)
                                                                <span class="variant">Color:
                                                                    {{ $detail->color->name }}</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    <div class="item-price">
                                                        <span class="quantity">Qty: {{ $detail->qty }}</span>
                                                        <span class="price">Rp
                                                            {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="order-totals">
                                        <div class="total-row">
                                            <span>Subtotal</span>
                                            <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="total-row">
                                            <span>Shipping</span>
                                            <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="total-row grand-total">
                                            <span>Total Amount</span>
                                            <span class="text-success">Rp
                                                {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons mt-4">
                                <a href="{{ route('customer.orders') }}" class="btn-action btn-primary w-100 mb-2">
                                    <i class="bi bi-bag me-2"></i>View My Orders
                                </a>
                                <a href="{{ route('customer.products') }}" class="btn-action btn-outline w-100">
                                    <i class="bi bi-arrow-left me-2"></i>Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Payment Proof Modal -->
    <div class="modal fade" id="paymentProofModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment Proof</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $transaction->payment_proof ? asset('storage/' . $transaction->payment_proof) : '' }}"
                        alt="Payment Proof" class="img-fluid" style="max-height: 70vh;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="{{ $transaction->payment_proof ? asset('storage/' . $transaction->payment_proof) : '#' }}"
                        class="btn btn-primary" download>
                        <i class="bi bi-download me-2"></i>Download
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .success-brown-theme {
            background: linear-gradient(135deg, #f5f1ed 0%, #ffffff 100%);
            min-height: 100vh;
        }

        /* Print Styles */
        @media print {

            .breadcrumb__area,
            .success-alert-card,
            .action-buttons,
            .btn-print,
            .success-card-header i,
            .upload-success,
            #uploadProofForm {
                display: none !important;
            }

            .success-card {
                border: 2px solid #000 !important;
                box-shadow: none !important;
                margin-bottom: 20px;
            }

            .success-card-header {
                background: #f8f9fa !important;
                color: #000 !important;
                border-bottom: 2px solid #000;
            }

            .text-success {
                color: #000 !important;
                font-weight: bold;
            }

            .order-items {
                max-height: none !important;
            }
        }

        /* Success Alert Card */
        .success-alert-card {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            border: 2px solid #28a745;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.1);
        }

        .success-alert-content {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .success-alert-icon {
            font-size: 40px;
            color: #28a745;
        }

        .success-alert-text h4 {
            color: #155724;
            margin-bottom: 5px;
        }

        .success-alert-text p {
            color: #0f5132;
            margin-bottom: 0;
        }

        /* Success Cards */
        .success-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(139, 111, 71, 0.1);
            border: 2px solid #D4A574;
            margin-bottom: 25px;
            overflow: hidden;
        }

        .success-card-header {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            padding: 20px;
            border-bottom: 2px solid #D4A574;
            display: flex;
            align-items: center;
        }

        .success-card-header h5 {
            margin: 0;
            font-weight: 700;
        }

        .success-card-body {
            padding: 25px;
        }

        /* Info Items */
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .info-label {
            font-size: 12px;
            color: #8B6F47;
            font-weight: 600;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 16px;
            font-weight: 700;
            color: #5a4a3a;
        }

        /* Status Badge */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
            border: 1px solid #ffeaa7;
        }

        /* Bank Details */
        .bank-details {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px solid #e9ecef;
        }

        .bank-logo {
            font-size: 40px;
        }

        .bank-info h6 {
            margin: 0 0 5px 0;
            color: #5a4a3a;
            font-weight: 700;
        }

        .account-number {
            font-size: 24px;
            font-weight: 700;
            color: #A0826D;
            margin-bottom: 2px;
        }

        .account-name {
            color: #8B6F47;
            font-weight: 600;
        }

        /* Payment Alert */
        .payment-alert {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 14px;
            margin-top: 15px;
            display: flex;
            align-items: center;
        }

        .payment-alert i {
            margin-right: 8px;
            font-size: 18px;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #D4A574;
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #faf7f4;
            position: relative;
        }

        .upload-area:hover {
            border-color: #A0826D;
            background: #f5f1ed;
        }

        .upload-area i {
            font-size: 40px;
            color: #D4A574;
            margin-bottom: 10px;
            display: block;
        }

        .upload-preview {
            position: relative;
            max-width: 200px;
            margin: 0 auto;
        }

        .upload-preview img {
            width: 100%;
            border-radius: 8px;
            border: 2px solid #D4A574;
            object-fit: contain;
        }

        .btn-remove-preview {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.7);
            transition: background-color 0.3s ease;
        }

        .btn-remove-preview:hover {
            background: #b02a37;
        }

        /* Upload Success */
        .upload-success {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #d4edda;
            border-radius: 10px;
            border: 2px solid #c3e6cb;
        }

        .upload-success-icon {
            font-size: 30px;
            color: #28a745;
        }

        .btn-view-proof {
            background: #28a745;
            color: white;
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-view-proof:hover {
            background: #218838;
            color: white;
        }

        /* Order Items */
        .order-items {
            max-height: 400px;
            overflow-y: auto;
        }

        .order-item {
            display: flex;
            gap: 12px;
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #D4A574;
            flex-shrink: 0;
        }

        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .no-image {
            width: 100%;
            height: 100%;
            background: #f5f1ed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #8B6F47;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: #5a4a3a;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .item-variants {
            margin-bottom: 5px;
        }

        .variant {
            font-size: 11px;
            color: #8B6F47;
            background: #f5f1ed;
            padding: 2px 6px;
            border-radius: 4px;
            margin-right: 5px;
        }

        .item-price {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .quantity {
            font-size: 12px;
            color: #8B6F47;
        }

        .price {
            font-weight: 700;
            color: #A0826D;
            font-size: 14px;
        }

        /* Order Totals */
        .order-totals {
            padding: 20px;
            background: #faf7f4;
            border-top: 2px solid #D4A574;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            color: #5a4a3a;
        }

        .grand-total {
            border-top: 2px solid #D4A574;
            margin-top: 10px;
            padding-top: 15px;
            font-weight: 700;
            font-size: 18px;
        }

        /* Action Buttons */
        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 20px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid;
        }

        .btn-primary {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            border-color: #A0826D;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(160, 130, 109, 0.3);
            color: white;
        }

        .btn-outline {
            background: transparent;
            color: #A0826D;
            border-color: #D4A574;
        }

        .btn-outline:hover {
            background: #f5f1ed;
            color: #8B6F47;
        }

        /* Upload Button */
        .btn-upload {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
            border: none;
            padding: 15px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-upload:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-upload:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .success-alert-content {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .bank-details {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .order-item {
                padding: 12px 0;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Click upload area to trigger file input
            $('#uploadArea').click(function() {
                $('#paymentProofInput').click();
            });

            // Image preview
            $('#paymentProofInput').change(function() {
                const file = this.files[0];
                if (file) {
                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Swal.fire({
                            icon: 'error',
                            title: 'File Too Large',
                            text: 'File size must be less than 2MB',
                            confirmButtonColor: '#A0826D'
                        });
                        $(this).val('');
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid File Type',
                            text: 'Only JPG, PNG, and JPEG files are allowed',
                            confirmButtonColor: '#A0826D'
                        });
                        $(this).val('');
                        return;
                    }

                    // Show preview
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview').attr('src', e.target.result);
                        $('#imagePreview').fadeIn(300);
                        $('#uploadPlaceholder').hide();
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Remove preview function
            window.removePreview = function() {
                $('#paymentProofInput').val('');
                $('#imagePreview').fadeOut(300);
                $('#uploadPlaceholder').fadeIn(300);
            }

            // View payment proof in modal
            window.viewPaymentProof = function() {
                const modal = new bootstrap.Modal(document.getElementById('paymentProofModal'));
                modal.show();
            }

            // Upload form submission
            $('#uploadProofForm').submit(function(e) {
                e.preventDefault();

                const fileInput = $('#paymentProofInput')[0];
                if (!fileInput.files || fileInput.files.length === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'No File Selected',
                        text: 'Please select a payment proof image to upload',
                        confirmButtonColor: '#A0826D'
                    });
                    return;
                }

                const formData = new FormData(this);
                const btn = $('#btnUpload');

                btn.prop('disabled', true).html(
                    '<i class="bi bi-hourglass-split spinner-border spinner-border-sm me-2"></i>Uploading...'
                );

                $.ajax({
                    url: '{{ route('customer.payment.upload', $transaction->id_transaksi) }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: 'Payment proof uploaded successfully!',
                                confirmButtonColor: '#A0826D'
                            }).then(() => {
                                location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to upload payment proof';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: message,
                            confirmButtonColor: '#A0826D'
                        });
                        btn.prop('disabled', false).html(
                            '<i class="bi bi-upload me-2"></i>Upload Payment Proof');
                    }
                });
            });
        });
    </script>
@endpush
