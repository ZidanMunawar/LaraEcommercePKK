@extends('customer.layouts.app')

@section('title', 'Checkout - ZynHope Apparel')

@section('content')
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Checkout</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Home</a></li>
                                    <li><a href="{{ route('customer.cart') }}">Cart</a></li>
                                    <li><span>Checkout</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Area -->
    <section class="checkout-area section-space">
        <div class="container">
            <form id="checkoutForm">
                @csrf
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-6">
                        <div class="checkbox-form">
                            <h3 class="mb-15">Billing Details</h3>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Full Name <span class="required">*</span></label>
                                        <input type="text" name="nama_lengkap" value="{{ $customer->nama_lengkap }}"
                                            required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Email Address <span class="required">*</span></label>
                                        <input type="email" name="email" value="{{ $customer->email }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Phone <span class="required">*</span></label>
                                        <input type="text" name="no_telp" value="{{ $customer->no_telp }}" required>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Street Address <span class="required">*</span></label>
                                        <textarea name="alamat" rows="2" placeholder="Jl. Merdeka No. 123, RT 01/RW 02" required>{{ $customer->alamat }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Province <span class="required">*</span></label>
                                        <select id="province" class="form-select" required>
                                            <option value="">-- Select Province --</option>
                                        </select>
                                        <input type="hidden" name="province_code" id="province_code">
                                        <input type="hidden" name="province_name" id="province_name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>City/Regency <span class="required">*</span></label>
                                        <select id="regency" class="form-select" required disabled>
                                            <option value="">-- Select Province First --</option>
                                        </select>
                                        <input type="hidden" name="regency_code" id="regency_code">
                                        <input type="hidden" name="regency_name" id="regency_name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>District <span class="required">*</span></label>
                                        <select id="district" class="form-select" required disabled>
                                            <option value="">-- Select City First --</option>
                                        </select>
                                        <input type="hidden" name="district_code" id="district_code">
                                        <input type="hidden" name="district_name" id="district_name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkout-form-list">
                                        <label>Village <span class="required">*</span></label>
                                        <select id="village" class="form-select" required disabled>
                                            <option value="">-- Select District First --</option>
                                        </select>
                                        <input type="hidden" name="village_code" id="village_code">
                                        <input type="hidden" name="village_name" id="village_name">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Postal Code</label>
                                        <input type="text" name="postal_code" placeholder="12345"
                                            value="{{ $customer->postal_code }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="checkout-form-list">
                                        <label>Order Notes (Optional)</label>
                                        <textarea name="catatan" rows="3" placeholder="Notes about your order..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Your Order -->
                    <div class="col-lg-6">
                        <div class="your-order">
                            <h3>Your Order</h3>
                            <div class="your-order-table table-responsive">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product-name">Product</th>
                                            <th class="product-total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cartItems as $item)
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    {{ $item->produk->name }}
                                                    @if ($item->size || $item->color)
                                                        <br>
                                                        <small class="text-muted">
                                                            @if ($item->size)
                                                                Size: {{ $item->size->size }}
                                                            @endif
                                                            @if ($item->color)
                                                                | Color: {{ $item->color->name }}
                                                            @endif
                                                        </small>
                                                    @endif
                                                    <strong class="product-quantity"> × {{ $item->qty }}</strong>
                                                </td>
                                                <td class="product-total">
                                                    <span class="amount">Rp
                                                        {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="cart-subtotal">
                                            <th>Subtotal</th>
                                            <td><span class="amount">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                            </td>
                                        </tr>
                                        <tr class="shipping">
                                            <th>Shipping Method</th>
                                            <td>
                                                @if ($shippingMethods->isNotEmpty())
                                                    <ul>
                                                        @foreach ($shippingMethods as $method)
                                                            <li>
                                                                <input type="radio" name="shipping_method"
                                                                    value="{{ $method->id }}"
                                                                    id="shipping_{{ $method->id }}"
                                                                    data-cost="{{ $method->cost }}"
                                                                    {{ $loop->first ? 'checked' : '' }} required>
                                                                <label for="shipping_{{ $method->id }}">
                                                                    {{ $method->name }}:
                                                                    <span class="amount">Rp
                                                                        {{ number_format($method->cost, 0, ',', '.') }}</span>
                                                                    @if ($method->estimated_days)
                                                                        <small>({{ $method->estimated_days }})</small>
                                                                    @endif
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr class="order-total">
                                            <th>Total</th>
                                            <td>
                                                <strong>
                                                    <span class="amount" id="totalAmount">
                                                        Rp
                                                        {{ number_format($subtotal + ($shippingMethods->first()->cost ?? 0), 0, ',', '.') }}
                                                    </span>
                                                </strong>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                            <!-- Payment Method -->
                            <div class="payment-method mt-4">
                                <h4 class="mb-3">Payment Method</h4>
                                <div class="accordion" id="paymentAccordion">
                                    <!-- BCA -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#bca">
                                                <input type="radio" name="payment_method" value="transfer_bca"
                                                    id="pay_bca" checked required>
                                                <label for="pay_bca" class="ms-2">Transfer Bank BCA</label>
                                            </button>
                                        </h2>
                                        <div id="bca" class="accordion-collapse collapse show"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body">
                                                <p><strong>Bank BCA</strong></p>
                                                <p>Account Number: <strong>1234567890</strong></p>
                                                <p>Account Name: <strong>ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- GoPay -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#gopay">
                                                <input type="radio" name="payment_method" value="gopay"
                                                    id="pay_gopay">
                                                <label for="pay_gopay" class="ms-2">GoPay</label>
                                            </button>
                                        </h2>
                                        <div id="gopay" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body">
                                                <p><strong>GoPay Number: 081234567890</strong></p>
                                                <p>Name: <strong>ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DANA -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#dana">
                                                <input type="radio" name="payment_method" value="dana"
                                                    id="pay_dana">
                                                <label for="pay_dana" class="ms-2">DANA</label>
                                            </button>
                                        </h2>
                                        <div id="dana" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body">
                                                <p><strong>DANA Number: 081234567890</strong></p>
                                                <p>Name: <strong>ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SeaBank -->
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#seabank">
                                                <input type="radio" name="payment_method" value="seabank"
                                                    id="pay_seabank">
                                                <label for="pay_seabank" class="ms-2">SeaBank</label>
                                            </button>
                                        </h2>
                                        <div id="seabank" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body">
                                                <p><strong>SeaBank Account: 901234567890</strong></p>
                                                <p>Account Name: <strong>ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-button-payment mt-4">
                                    <button class="fill-btn w-100" type="submit" id="btnPlaceOrder">
                                        <span class="fill-btn-inner">
                                            <span class="fill-btn-normal">Place Order</span>
                                            <span class="fill-btn-hover">Place Order</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const API_BASE = 'https://www.emsifa.com/api-wilayah-indonesia/api';
            const subtotal = {{ $subtotal }};

            // Existing data
            const existingProvinceCode = '{{ $customer->province_code ?? '' }}';
            const existingRegencyCode = '{{ $customer->regency_code ?? '' }}';
            const existingDistrictCode = '{{ $customer->district_code ?? '' }}';
            const existingVillageCode = '{{ $customer->village_code ?? '' }}';

            // Load Provinces
            loadProvinces();

            function loadProvinces() {
                $('#province').html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/provinces.json`, function(data) {
                    let options = '<option value="">-- Select Province --</option>';
                    data.forEach(item => {
                        const selected = item.id == existingProvinceCode ? 'selected' : '';
                        options +=
                            `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                    });
                    $('#province').html(options);

                    if (existingProvinceCode) {
                        $('#province').trigger('change');
                    }
                });
            }

            // Province Change
            $('#province').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#province_code').val(id);
                $('#province_name').val(name);
                $('#regency').prop('disabled', true).html(
                    '<option value="">-- Select Province First --</option>');
                $('#district').prop('disabled', true).html(
                    '<option value="">-- Select City First --</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Select District First --</option>');

                if (id) {
                    loadRegencies(id);
                }
            });

            function loadRegencies(provinceId) {
                $('#regency').prop('disabled', false).html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/regencies/${provinceId}.json`, function(data) {
                    let options = '<option value="">-- Select City/Regency --</option>';
                    data.forEach(item => {
                        const selected = item.id == existingRegencyCode ? 'selected' : '';
                        options +=
                            `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                    });
                    $('#regency').html(options);

                    if (existingRegencyCode) {
                        $('#regency').trigger('change');
                    }
                });
            }

            // Regency Change
            $('#regency').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#regency_code').val(id);
                $('#regency_name').val(name);
                $('#district').prop('disabled', true).html(
                    '<option value="">-- Select City First --</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Select District First --</option>');

                if (id) {
                    loadDistricts(id);
                }
            });

            function loadDistricts(regencyId) {
                $('#district').prop('disabled', false).html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/districts/${regencyId}.json`, function(data) {
                    let options = '<option value="">-- Select District --</option>';
                    data.forEach(item => {
                        const selected = item.id == existingDistrictCode ? 'selected' : '';
                        options +=
                            `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                    });
                    $('#district').html(options);

                    if (existingDistrictCode) {
                        $('#district').trigger('change');
                    }
                });
            }

            // District Change
            $('#district').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#district_code').val(id);
                $('#district_name').val(name);
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Select District First --</option>');

                if (id) {
                    loadVillages(id);
                }
            });

            function loadVillages(districtId) {
                $('#village').prop('disabled', false).html('<option value="">Loading...</option>');

                $.get(`${API_BASE}/villages/${districtId}.json`, function(data) {
                    let options = '<option value="">-- Select Village --</option>';
                    data.forEach(item => {
                        const selected = item.id == existingVillageCode ? 'selected' : '';
                        options +=
                            `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                    });
                    $('#village').html(options);
                });
            }

            // Village Change
            $('#village').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');

                $('#village_code').val(id);
                $('#village_name').val(name);
            });

            // Update total when shipping method changes
            $('input[name="shipping_method"]').change(function() {
                const shippingCost = parseFloat($(this).data('cost'));
                const total = subtotal + shippingCost;
                $('#totalAmount').text('Rp ' + total.toLocaleString('id-ID'));
            });

            // Sync radio with accordion
            $('.accordion-button').click(function() {
                const radio = $(this).find('input[type="radio"]');
                radio.prop('checked', true);
            });

            // Form submission
            $('#checkoutForm').submit(function(e) {
                e.preventDefault();

                const btn = $('#btnPlaceOrder');
                btn.prop('disabled', true).text('Processing...');

                $.ajax({
                    url: '{{ route('customer.checkout.process') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response
                            .redirect_url; // ✅ Ke upload page dulu
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON?.message || 'Failed to process order');
                        btn.prop('disabled', false).html(`
                    <span class="fill-btn-inner">
                        <span class="fill-btn-normal">Place Order</span>
                        <span class="fill-btn-hover">Place Order</span>
                    </span>
                `);
                    }
                });
            });
        });
    </script>
@endpush
