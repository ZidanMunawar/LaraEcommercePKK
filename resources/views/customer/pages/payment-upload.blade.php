@extends('customer.layouts.app')

@section('title', 'Upload Payment Proof - ZynHope Apparel')

@section('content')
    <!-- Header -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title text-white">Complete Payment</h2>
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

    <section class="section-space payment-brown-theme">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if (session('info'))
                        <div class="payment-alert payment-alert-info">
                            <i class="bi bi-info-circle-fill"></i>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    <!-- Progress Steps -->
                    <div class="payment-progress mb-5">
                        <div class="progress-step completed">
                            <div class="step-number">1</div>
                            <div class="step-label">Order Placed</div>
                        </div>
                        <div class="progress-line completed"></div>
                        <div class="progress-step completed">
                            <div class="step-number">2</div>
                            <div class="step-label">Payment</div>
                        </div>
                        <div class="progress-line active"></div>
                        <div class="progress-step active">
                            <div class="step-number">3</div>
                            <div class="step-label">Upload Proof</div>
                        </div>
                        <div class="progress-line"></div>
                        <div class="progress-step">
                            <div class="step-number">4</div>
                            <div class="step-label">Processing</div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <!-- Left Column - Order & Payment Info -->
                        <div class="col-lg-6">
                            <!-- Order Summary Card -->
                            <div class="payment-card h-100">
                                <div class="payment-card-header">
                                    <i class="bi bi-receipt me-2"></i>
                                    <h5 class="mb-0">Order Summary</h5>
                                </div>
                                <div class="payment-card-body">
                                    <div class="order-info">
                                        <div class="info-row">
                                            <span class="info-label">Order ID</span>
                                            <span class="info-value text-primary">{{ $transaction->transaction_id }}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Total Amount</span>
                                            <span class="info-value text-success fw-bold fs-5">Rp
                                                {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Payment Method</span>
                                            <span class="payment-method-badge">
                                                {{ strtoupper(str_replace('_', ' ', $transaction->metode_pembayaran)) }}
                                            </span>
                                        </div>
                                        <div class="info-row">
                                            <span class="info-label">Order Date</span>
                                            <span
                                                class="info-value">{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column - Payment Details -->
                        <div class="col-lg-6">
                            <div class="payment-card h-100">
                                <div class="payment-card-header">
                                    <i class="bi bi-credit-card me-2"></i>
                                    <h5 class="mb-0">Payment Details</h5>
                                </div>
                                <div class="payment-card-body">
                                    <div class="payment-instructions">
                                        @switch($transaction->metode_pembayaran)
                                            @case('transfer_bca')
                                                <div class="bank-details">
                                                    <div class="bank-logo">
                                                        <i class="bi bi-bank2 text-primary"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">Bank BCA</h6>
                                                        <div class="account-number">1234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('transfer_bni')
                                                <div class="bank-details">
                                                    <div class="bank-logo">
                                                        <i class="bi bi-bank2 text-warning"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">Bank BNI</h6>
                                                        <div class="account-number">0987654321</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('transfer_mandiri')
                                                <div class="bank-details">
                                                    <div class="bank-logo">
                                                        <i class="bi bi-bank2 text-danger"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">Bank Mandiri</h6>
                                                        <div class="account-number">1122334455</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('gopay')
                                                <div class="bank-details">
                                                    <div class="bank-logo">
                                                        <i class="bi bi-phone-fill text-success"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">GoPay</h6>
                                                        <div class="account-number">081234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('dana')
                                                <div class="bank-details">
                                                    <div class="bank-logo">
                                                        <i class="bi bi-phone-fill text-info"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">DANA</h6>
                                                        <div class="account-number">081234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break

                                            @case('seabank')
                                                <div class="bank-details">
                                                    <div class="bank-logo">
                                                        <i class="bi bi-bank2 text-purple"></i>
                                                    </div>
                                                    <div class="bank-info">
                                                        <h6 class="bank-name">SeaBank</h6>
                                                        <div class="account-number">901234567890</div>
                                                        <div class="account-name">ZynHope Apparel</div>
                                                    </div>
                                                </div>
                                            @break
                                        @endswitch

                                        <div class="amount-warning mt-3">
                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                            <div>
                                                <strong class="d-block mb-1">Transfer Exact Amount</strong>
                                                <div class="exact-amount">Rp
                                                    {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Section - Full Width -->
                        <div class="col-12">
                            <div class="payment-card upload-card">
                                <div class="payment-card-header">
                                    <i class="bi bi-cloud-upload me-2"></i>
                                    <h5 class="mb-0">Upload Payment Proof</h5>
                                </div>
                                <div class="payment-card-body">
                                    <div class="upload-required mb-4">
                                        <i class="bi bi-info-circle-fill"></i>
                                        <span>Required to process your order - Upload within 24 hours</span>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-8">
                                            <form id="uploadProofForm" enctype="multipart/form-data">
                                                @csrf

                                                <label for="paymentProofInput" class="upload-area" id="uploadArea">
                                                    <div class="upload-placeholder" id="uploadPlaceholder">
                                                        <i class="bi bi-cloud-arrow-up"></i>
                                                        <p class="mb-2 fw-bold">Click to upload payment proof</p>
                                                        <small class="text-muted">Max 2MB • JPG, PNG, JPEG</small>
                                                    </div>
                                                    <input type="file" class="d-none" name="payment_proof"
                                                        accept="image/jpeg,image/png,image/jpg" required
                                                        id="paymentProofInput">
                                                    <div id="imagePreview" class="upload-preview" style="display: none;">
                                                        <img id="preview" src="" alt="Preview">
                                                        <button type="button" class="btn-remove-preview"
                                                            onclick="removePreview(event)">
                                                            <i class="bi bi-x-lg"></i>
                                                        </button>
                                                    </div>
                                                </label>

                                                <button type="submit" class="btn-upload w-100 mt-4" id="btnUpload">
                                                    <i class="bi bi-upload me-2"></i>Upload Payment Proof
                                                </button>
                                            </form>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="upload-tips h-100">
                                                <h6 class="mb-3">
                                                    <i class="bi bi-lightbulb-fill me-2"></i>Upload Tips
                                                </h6>
                                                <ul class="mb-0">
                                                    <li>Ensure complete transaction details are visible</li>
                                                    <li>Amount and date must be clear</li>
                                                    <li>Accepted: JPG, PNG, JPEG</li>
                                                    <li>Max file size: 2MB</li>
                                                    <li>Upload within 24 hours</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support Info -->
                    <div class="support-info text-center mt-5">
                        <p class="mb-2">
                            <i class="bi bi-question-circle me-2"></i>
                            Need help with payment?
                            <a href="{{ route('customer.contact') }}" class="support-link">Contact Support</a>
                        </p>
                        <small class="text-muted">We're here to help you complete your payment</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .payment-brown-theme {
            background: linear-gradient(135deg, #f8f5f2 0%, #ffffff 100%);
            min-height: 100vh;
        }

        /* Progress Steps */
        .payment-progress {
            display: flex;
            align-items: center;
            justify-content: center;
            max-width: 600px;
            margin: 0 auto;
            gap: 10px;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
            flex: 1;
        }

        .progress-line {
            flex: 1;
            height: 3px;
            background: #e9ecef;
            margin: 0 -5px;
            position: relative;
            top: -15px;
        }

        .progress-line.completed {
            background: linear-gradient(90deg, #28a745, #20c997);
        }

        .progress-line.active {
            background: linear-gradient(90deg, #20c997, #A0826D);
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e9ecef;
            color: #6c757d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 8px;
            border: 3px solid #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .step-label {
            font-size: 12px;
            font-weight: 600;
            color: #6c757d;
            text-align: center;
        }

        .progress-step.completed .step-number {
            background: #28a745;
            color: white;
        }

        .progress-step.active .step-number {
            background: #A0826D;
            color: white;
            border-color: #D4A574;
        }

        .progress-step.completed .step-label,
        .progress-step.active .step-label {
            color: #2c3e50;
        }

        /* Cards */
        .payment-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(139, 111, 71, 0.08);
            border: 1px solid rgba(212, 165, 116, 0.3);
            overflow: hidden;
        }

        .payment-card-header {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            padding: 20px;
            border-bottom: 1px solid rgba(212, 165, 116, 0.3);
        }

        .payment-card-header h5 {
            margin: 0;
            font-weight: 600;
            font-size: 18px;
        }

        .payment-card-body {
            padding: 25px;
        }

        /* Upload Card */
        .upload-card {
            border-color: rgba(220, 53, 69, 0.2);
        }

        .upload-card .payment-card-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
        }

        /* Info Rows */
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f8f9fa;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #2c3e50;
        }

        /* Payment Method Badge */
        .payment-method-badge {
            background: #17a2b8;
            color: white;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
        }

        /* Bank Details */
        .bank-details {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .bank-logo {
            font-size: 32px;
        }

        .bank-info h6 {
            margin: 0 0 5px 0;
            color: #2c3e50;
            font-weight: 600;
        }

        .account-number {
            font-size: 18px;
            font-weight: 700;
            color: #A0826D;
            margin-bottom: 2px;
        }

        .account-name {
            color: #6c757d;
            font-weight: 500;
        }

        /* Amount Warning */
        .amount-warning {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px;
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            color: #856404;
        }

        .amount-warning i {
            font-size: 20px;
            color: #ffc107;
        }

        .exact-amount {
            font-size: 18px;
            font-weight: 700;
            color: #dc3545;
        }

        /* Upload Area */
        .upload-area {
            display: block;
            border: 2px dashed #D4A574;
            border-radius: 10px;
            padding: 40px 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #faf7f4;
        }

        .upload-area:hover {
            border-color: #A0826D;
            background: #f5f1ed;
        }

        .upload-placeholder i {
            font-size: 48px;
            color: #D4A574;
            margin-bottom: 15px;
        }

        .upload-preview {
            position: relative;
            max-width: 100%;
        }

        .upload-preview img {
            width: 100%;
            border-radius: 8px;
            border: 2px solid #D4A574;
            max-height: 200px;
            object-fit: contain;
        }

        .btn-remove-preview {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #dc3545;
            color: white;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-remove-preview:hover {
            background: #c82333;
            transform: scale(1.1);
        }

        /* Upload Button */
        .btn-upload {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-upload:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-upload:disabled {
            background: #6c757d;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Upload Tips */
        .upload-tips {
            background: #e7f3ff;
            border: 1px solid #b3d9ff;
            border-radius: 10px;
            padding: 20px;
        }

        .upload-tips h6 {
            color: #0066cc;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .upload-tips ul {
            margin: 0;
            padding-left: 20px;
            color: #004d99;
        }

        .upload-tips li {
            margin-bottom: 8px;
            font-size: 14px;
            line-height: 1.4;
        }

        /* Alerts */
        .payment-alert {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-weight: 500;
        }

        .payment-alert-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        /* Upload Required */
        .upload-required {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            color: #721c24;
            font-weight: 500;
        }

        /* Support Info */
        .support-info {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .support-link {
            color: #A0826D !important;
            font-weight: 600;
            text-decoration: none;
        }

        .support-link:hover {
            color: #8B6F47 !important;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .payment-progress {
                flex-wrap: wrap;
                gap: 15px;
            }

            .progress-line {
                display: none;
            }

            .progress-step {
                width: 45%;
            }

            .bank-details {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .upload-area {
                padding: 30px 20px;
            }
        }

        .text-purple {
            color: #6f42c1 !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // File input change handler
            $('#paymentProofInput').on('change', function(e) {
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
            window.removePreview = function(event) {
                event.preventDefault();
                event.stopPropagation();
                $('#paymentProofInput').val('');
                $('#imagePreview').fadeOut(300);
                $('#uploadPlaceholder').fadeIn(300);
            }

            // Upload form submission
            $('#uploadProofForm').on('submit', function(e) {
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
                    '<span class="spinner-border spinner-border-sm me-2"></span>Uploading...');

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
                                title: 'Upload Successful!',
                                text: 'Your payment proof has been uploaded successfully',
                                confirmButtonColor: '#A0826D',
                                confirmButtonText: 'Continue'
                            }).then(() => {
                                if (response.redirect_url) {
                                    window.location.href = response.redirect_url;
                                } else {
                                    window.location.href =
                                        '{{ route('customer.orders') }}';
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        let message = 'Failed to upload payment proof. Please try again.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
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
