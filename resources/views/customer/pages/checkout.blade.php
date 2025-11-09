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
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><a href="{{ route('customer.cart') }}">Keranjang</a></li>
                                    <li><span>Checkout</span></li>
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
            <form id="checkoutForm">
                @csrf
                <div class="row">
                    <!-- Billing Details -->
                    <div class="col-lg-6">
                        <div class="checkbox-form">
                            <h3 class="mb-15" style="color: #A0826D; font-weight: 700;">Detail Pengiriman</h3>
                            <div class="row g-3">
                                <div class="col-md-12">
                                    <label style="color: #8B6F47; font-weight: 600;">Nama Lengkap <span
                                            style="color: #dc3545;">*</span></label>
                                    <input type="text" name="nama_lengkap" value="{{ $customer->nama_lengkap }}" required
                                        style="border: 2px solid #D4A574; border-radius: 8px; width: 100%; padding: 10px;">
                                </div>

                                <div class="col-md-6">
                                    <label style="color: #8B6F47; font-weight: 600;">Email <span
                                            style="color: #dc3545;">*</span></label>
                                    <input type="email" name="email" value="{{ $customer->email }}" required
                                        style="border: 2px solid #D4A574; border-radius: 8px; width: 100%; padding: 10px;">
                                </div>

                                <div class="col-md-6">
                                    <label style="color: #8B6F47; font-weight: 600;">No. Telepon <span
                                            style="color: #dc3545;">*</span></label>
                                    <input type="text" name="no_telp" value="{{ $customer->no_telp }}" required
                                        style="border: 2px solid #D4A574; border-radius: 8px; width: 100%; padding: 10px;">
                                </div>

                                <div class="col-md-12">
                                    <label style="color: #8B6F47; font-weight: 600;">Alamat Lengkap <span
                                            style="color: #dc3545;">*</span></label>
                                    <textarea name="alamat" rows="2" required
                                        style="border: 2px solid #D4A574; border-radius: 8px; width: 100%; padding: 10px;">{{ $customer->alamat }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <label style="color: #8B6F47; font-weight: 600;">Provinsi <span
                                            style="color: #dc3545;">*</span></label>
                                    <select id="province" class="form-select" required
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 10px;">
                                        <option value="">-- Pilih Provinsi --</option>
                                    </select>
                                    <input type="hidden" name="province_name" id="province_name"
                                        value="{{ $customer->province_name }}">
                                </div>

                                <div class="col-md-6">
                                    <label style="color: #8B6F47; font-weight: 600;">Kota/Kabupaten <span
                                            style="color: #dc3545;">*</span></label>
                                    <select id="regency" class="form-select" required disabled
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 10px;">
                                        <option value="">-- Pilih Provinsi Dulu --</option>
                                    </select>
                                    <input type="hidden" name="regency_name" id="regency_name"
                                        value="{{ $customer->regency_name }}">
                                </div>

                                <div class="col-md-6">
                                    <label style="color: #8B6F47; font-weight: 600;">Kecamatan <span
                                            style="color: #dc3545;">*</span></label>
                                    <select id="district" class="form-select" required disabled
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 10px;">
                                        <option value="">-- Pilih Kota Dulu --</option>
                                    </select>
                                    <input type="hidden" name="district_name" id="district_name"
                                        value="{{ $customer->district_name }}">
                                </div>

                                <div class="col-md-6">
                                    <label style="color: #8B6F47; font-weight: 600;">Kelurahan <span
                                            style="color: #dc3545;">*</span></label>
                                    <select id="village" class="form-select" required disabled
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 10px;">
                                        <option value="">-- Pilih Kecamatan Dulu --</option>
                                    </select>
                                    <input type="hidden" name="village_name" id="village_name"
                                        value="{{ $customer->village_name }}">
                                </div>

                                <div class="col-md-12">
                                    <label style="color: #8B6F47; font-weight: 600;">Kode Pos</label>
                                    <input type="text" name="postal_code" placeholder="12345"
                                        value="{{ $customer->postal_code }}"
                                        style="border: 2px solid #D4A574; border-radius: 8px; width: 100%; padding: 10px;">
                                </div>

                                <div class="col-md-12">
                                    <label style="color: #8B6F47; font-weight: 600;">Catatan (Opsional)</label>
                                    <textarea name="catatan" rows="3" placeholder="Catatan tentang pesanan..."
                                        style="border: 2px solid #D4A574; border-radius: 8px; width: 100%; padding: 10px;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="col-lg-6">
                        <div class="your-order"
                            style="background: #f5f1ed; padding: 20px; border-radius: 12px; border: 2px solid #D4A574;">
                            <h3 style="color: #A0826D; font-weight: 700; margin-bottom: 20px;">Ringkasan Pesanan</h3>

                            <!-- Items List -->
                            <div
                                style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #D4A574; max-height: 300px; overflow-y: auto;">
                                @foreach ($cartItems as $item)
                                    <div
                                        style="border-bottom: 1px solid #e9ecef; padding-bottom: 10px; margin-bottom: 10px;">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span
                                                style="font-weight: 600; color: #8B6F47;">{{ $item->produk->name }}</span>
                                            <span style="color: #A0826D; font-weight: 700;">Rp
                                                {{ number_format($item->harga * $item->qty, 0, ',', '.') }}</span>
                                        </div>
                                        <small class="text-muted">
                                            Qty: {{ $item->qty }} |
                                            @if ($item->size)
                                                Size: {{ $item->size->size }}
                                            @endif
                                            @if ($item->color)
                                                | Color: {{ $item->color->name }}
                                            @endif
                                        </small>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Discount Code -->
                            <div
                                style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #D4A574;">
                                <label style="color: #8B6F47; font-weight: 600; display: block; margin-bottom: 8px;">Kode
                                    Promo</label>
                                <div class="input-group" style="display: flex; gap: 5px;">
                                    <input type="text" name="kode_diskon" id="kode_diskon"
                                        placeholder="Masukkan kode promo" class="form-control"
                                        style="border: 2px solid #D4A574; border-radius: 8px; padding: 10px; flex: 1;">
                                    <button type="button" id="btnApplyDiskon" class="btn"
                                        style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; border-radius: 8px; font-weight: 700; padding: 10px 15px; white-space: nowrap;">Terapkan</button>
                                </div>
                                <div id="diskonInfo" style="margin-top: 10px;"></div>
                            </div>

                            <!-- Shipping Method -->
                            <div
                                style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #D4A574;">
                                <label style="color: #8B6F47; font-weight: 600; display: block; margin-bottom: 8px;">Metode
                                    Pengiriman</label>
                                @foreach ($shippingMethods as $method)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input shipping-method" type="radio"
                                            name="shipping_method" id="shipping_{{ $method->id }}"
                                            value="{{ $method->id }}" data-cost="{{ $method->cost }}"
                                            {{ $loop->first ? 'checked' : '' }} required style="cursor: pointer;">
                                        <label class="form-check-label" for="shipping_{{ $method->id }}"
                                            style="color: #2c2c2c; cursor: pointer;">
                                            {{ $method->name }} - <strong style="color: #A0826D;">Rp
                                                {{ number_format($method->cost, 0, ',', '.') }}</strong>
                                        </label>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Payment Method Accordion -->
                            <div
                                style="background: white; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #D4A574;">
                                <label style="color: #8B6F47; font-weight: 600; display: block; margin-bottom: 8px;">Metode
                                    Pembayaran</label>
                                <div class="accordion" id="paymentAccordion">
                                    <!-- BCA -->
                                    <div class="accordion-item"
                                        style="border: 1px solid #D4A574; margin-bottom: 8px; border-radius: 6px;">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#bca"
                                                style="background: linear-gradient(135deg, #E8D4B8, #D4A574); color: #8B6F47; font-weight: 700; padding: 12px;">
                                                <input type="radio" name="payment_method" value="transfer_bca"
                                                    id="pay_bca" checked required
                                                    style="cursor: pointer; margin-right: 10px;">
                                                <label for="pay_bca" style="cursor: pointer; margin: 0;">Transfer Bank
                                                    BCA</label>
                                            </button>
                                        </h2>
                                        <div id="bca" class="accordion-collapse collapse show"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body" style="background: white; padding: 12px;">
                                                <p style="margin: 0; color: #2c2c2c;"><strong>Bank BCA</strong></p>
                                                <p style="margin: 5px 0; color: #666;">No. Rekening: <strong
                                                        style="color: #A0826D;">1234567890</strong></p>
                                                <p style="margin: 5px 0 0 0; color: #666;">Atas Nama: <strong
                                                        style="color: #A0826D;">ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- GoPay -->
                                    <div class="accordion-item"
                                        style="border: 1px solid #D4A574; margin-bottom: 8px; border-radius: 6px;">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#gopay"
                                                style="background: linear-gradient(135deg, #E8D4B8, #D4A574); color: #8B6F47; font-weight: 700; padding: 12px;">
                                                <input type="radio" name="payment_method" value="gopay"
                                                    id="pay_gopay" style="cursor: pointer; margin-right: 10px;">
                                                <label for="pay_gopay" style="cursor: pointer; margin: 0;">GoPay</label>
                                            </button>
                                        </h2>
                                        <div id="gopay" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body" style="background: white; padding: 12px;">
                                                <p style="margin: 0; color: #2c2c2c;"><strong>No. GoPay:</strong> <strong
                                                        style="color: #A0826D;">081234567890</strong></p>
                                                <p style="margin: 5px 0 0 0; color: #666;">Atas Nama: <strong
                                                        style="color: #A0826D;">ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DANA -->
                                    <div class="accordion-item"
                                        style="border: 1px solid #D4A574; margin-bottom: 8px; border-radius: 6px;">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#dana"
                                                style="background: linear-gradient(135deg, #E8D4B8, #D4A574); color: #8B6F47; font-weight: 700; padding: 12px;">
                                                <input type="radio" name="payment_method" value="dana"
                                                    id="pay_dana" style="cursor: pointer; margin-right: 10px;">
                                                <label for="pay_dana" style="cursor: pointer; margin: 0;">DANA</label>
                                            </button>
                                        </h2>
                                        <div id="dana" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body" style="background: white; padding: 12px;">
                                                <p style="margin: 0; color: #2c2c2c;"><strong>No. DANA:</strong> <strong
                                                        style="color: #A0826D;">081234567890</strong></p>
                                                <p style="margin: 5px 0 0 0; color: #666;">Atas Nama: <strong
                                                        style="color: #A0826D;">ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SeaBank -->
                                    <div class="accordion-item"
                                        style="border: 1px solid #D4A574; margin-bottom: 0; border-radius: 6px;">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#seabank"
                                                style="background: linear-gradient(135deg, #E8D4B8, #D4A574); color: #8B6F47; font-weight: 700; padding: 12px;">
                                                <input type="radio" name="payment_method" value="seabank"
                                                    id="pay_seabank" style="cursor: pointer; margin-right: 10px;">
                                                <label for="pay_seabank"
                                                    style="cursor: pointer; margin: 0;">SeaBank</label>
                                            </button>
                                        </h2>
                                        <div id="seabank" class="accordion-collapse collapse"
                                            data-bs-parent="#paymentAccordion">
                                            <div class="accordion-body" style="background: white; padding: 12px;">
                                                <p style="margin: 0; color: #2c2c2c;"><strong>No. SeaBank:</strong> <strong
                                                        style="color: #A0826D;">901234567890</strong></p>
                                                <p style="margin: 5px 0 0 0; color: #666;">Atas Nama: <strong
                                                        style="color: #A0826D;">ZynHope Apparel</strong></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Total Summary -->
                            <div
                                style="background: linear-gradient(135deg, #E8D4B8, #D4A574); padding: 15px; border-radius: 8px; margin-bottom: 15px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #8B6F47; font-weight: 600;">Subtotal</span>
                                    <span id="displaySubtotal" style="color: #8B6F47; font-weight: 700;">Rp
                                        {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #8B6F47; font-weight: 600;">Diskon</span>
                                    <span id="displayDiscount" style="color: #dc3545; font-weight: 700;">- Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span style="color: #8B6F47; font-weight: 600;">Pengiriman</span>
                                    <span id="displayShipping" style="color: #8B6F47; font-weight: 700;">Rp
                                        {{ number_format($shippingMethods->first()->cost ?? 0, 0, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between"
                                    style="border-top: 2px solid rgba(139, 111, 71, 0.3); padding-top: 10px;">
                                    <span style="color: #8B6F47; font-weight: 700; font-size: 16px;">TOTAL</span>
                                    <span id="displayTotal" style="color: #8B6F47; font-weight: 700; font-size: 18px;">Rp
                                        {{ number_format($subtotal + ($shippingMethods->first()->cost ?? 0), 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-lg w-100"
                                style="background: linear-gradient(135deg, #A0826D, #8B6F47); color: white; font-weight: 700; border: none; border-radius: 8px; padding: 12px;">
                                <i class="bi bi-check-circle me-2"></i>Pesan Sekarang
                            </button>
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
            let discountAmount = 0;

            // Data customer dari backend
            const customerData = {
                province_name: "{{ $customer->province_name }}",
                regency_name: "{{ $customer->regency_name }}",
                district_name: "{{ $customer->district_name }}",
                village_name: "{{ $customer->village_name }}"
            };

            // ========== LOAD PROVINCES & AUTO SELECT ==========
            $.get(`${API_BASE}/provinces.json`, function(data) {
                let options = '<option value="">-- Pilih Provinsi --</option>';
                data.forEach(item => {
                    const selected = item.name === customerData.province_name ? 'selected' : '';
                    options +=
                        `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                });
                $('#province').html(options);

                // Jika ada data customer, trigger change untuk load selanjutnya
                if (customerData.province_name) {
                    $('#province').trigger('change');
                }
            });

            // ========== PROVINCE CHANGE ==========
            $('#province').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');
                $('#province_name').val(name);
                $('#regency').prop('disabled', true).html('<option value="">Loading...</option>');
                $('#district').prop('disabled', true).html(
                    '<option value="">-- Pilih Kota Dulu --</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Pilih Kecamatan Dulu --</option>');

                if (id) {
                    $.get(`${API_BASE}/regencies/${id}.json`, function(data) {
                        let options = '<option value="">-- Pilih Kota/Kabupaten --</option>';
                        data.forEach(item => {
                            const selected = item.name === customerData.regency_name ?
                                'selected' : '';
                            options +=
                                `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                        });
                        $('#regency').prop('disabled', false).html(options);

                        // Auto select regency jika ada data
                        if (customerData.regency_name) {
                            $('#regency').trigger('change');
                        }
                    });
                }
            });

            // ========== REGENCY CHANGE ==========
            $('#regency').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');
                $('#regency_name').val(name);
                $('#district').prop('disabled', true).html('<option value="">Loading...</option>');
                $('#village').prop('disabled', true).html(
                    '<option value="">-- Pilih Kecamatan Dulu --</option>');

                if (id) {
                    $.get(`${API_BASE}/districts/${id}.json`, function(data) {
                        let options = '<option value="">-- Pilih Kecamatan --</option>';
                        data.forEach(item => {
                            const selected = item.name === customerData.district_name ?
                                'selected' : '';
                            options +=
                                `<option value="${item.id}" data-name="${item.name}" ${selected}>${item.name}</option>`;
                        });
                        $('#district').prop('disabled', false).html(options);

                        // Auto select district jika ada data
                        if (customerData.district_name) {
                            $('#district').trigger('change');
                        }
                    });
                }
            });

            // ========== DISTRICT CHANGE ==========
            $('#district').change(function() {
                const id = $(this).val();
                const name = $(this).find('option:selected').data('name');
                $('#district_name').val(name);
                $('#village').prop('disabled', true).html('<option value="">Loading...</option>');

                if (id) {
                    $.get(`${API_BASE}/villages/${id}.json`, function(data) {
                        let options = '<option value="">-- Pilih Kelurahan --</option>';
                        data.forEach(item => {
                            const selected = item.name === customerData.village_name ?
                                'selected' : '';
                            options +=
                                `<option value="${item.name}" ${selected}>${item.name}</option>`;
                        });
                        $('#village').prop('disabled', false).html(options);

                        // Auto set village name
                        if (customerData.village_name) {
                            $('#village_name').val(customerData.village_name);
                        }
                    });
                }
            });

            // ========== VILLAGE CHANGE ==========
            $('#village').change(function() {
                const name = $(this).val();
                $('#village_name').val(name);
            });

            // ========== APPLY DISCOUNT (REAL DATABASE) ==========
            $('#btnApplyDiskon').click(function() {
                const kodeDiskon = $('#kode_diskon').val();

                if (!kodeDiskon) {
                    Swal.fire('Peringatan', 'Masukkan kode promo!', 'warning');
                    return;
                }

                $.ajax({
                    url: '{{ route('customer.checkout.validate-promo') }}',
                    method: 'POST',
                    data: {
                        kode_diskon: kodeDiskon,
                        subtotal: subtotal,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            discountAmount = res.discount_amount;
                            updateTotal();

                            let discountText = res.discount_type === 'percentage' ?
                                `${res.discount_value}%` :
                                `Rp ${Number(res.discount_value).toLocaleString('id-ID')}`;

                            $('#diskonInfo').html(`
                                <div class="alert alert-success" style="background: #e8f5e9; border: 1px solid #81c784; color: #27ae60; padding: 10px; border-radius: 6px; margin: 10px 0;">
                                    <i class="bi bi-check-circle me-2"></i><strong>Diskon ${discountText} berhasil diterapkan!</strong>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', xhr.responseJSON?.message ||
                            'Kode promo tidak valid', 'error');
                        $('#diskonInfo').html('');
                        discountAmount = 0;
                        updateTotal();
                    }
                });
            });

            // ========== SHIPPING CHANGE ==========
            $('.shipping-method').change(function() {
                updateTotal();
            });

            // ========== SYNC PAYMENT METHOD WITH ACCORDION ==========
            $('.accordion-button').click(function() {
                const radio = $(this).find('input[type="radio"]');
                radio.prop('checked', true);
            });

            // ========== UPDATE TOTAL ==========
            function updateTotal() {
                const shippingCost = parseFloat($('input[name="shipping_method"]:checked').data('cost'));
                const total = (subtotal - discountAmount) + shippingCost;

                $('#displayDiscount').text('- Rp ' + discountAmount.toLocaleString('id-ID'));
                $('#displayShipping').text('Rp ' + shippingCost.toLocaleString('id-ID'));
                $('#displayTotal').text('Rp ' + total.toLocaleString('id-ID'));
            }

            // ========== FORM SUBMIT ==========
            $('#checkoutForm').submit(function(e) {
                e.preventDefault();

                // Validasi data wilayah
                if (!$('#province_name').val() || !$('#regency_name').val() ||
                    !$('#district_name').val() || !$('#village_name').val()) {
                    Swal.fire({
                        title: 'Data Alamat Belum Lengkap',
                        text: 'Mohon lengkapi data provinsi, kota, kecamatan, dan kelurahan',
                        icon: 'warning',
                        confirmButtonColor: '#A0826D'
                    });
                    return;
                }

                const btn = $('button[type="submit"]');
                btn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-2"></i>Memproses...');

                $.ajax({
                    url: '{{ route('customer.checkout.process') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Sukses!',
                                text: 'Pesanan berhasil dibuat. Silakan upload bukti pembayaran.',
                                icon: 'success',
                                confirmButtonColor: '#A0826D'
                            }).then(() => {
                                window.location.href = res.redirect_url;
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Gagal!',
                            text: xhr.responseJSON?.message ||
                                'Gagal memproses pesanan',
                            icon: 'error',
                            confirmButtonColor: '#A0826D'
                        });
                        btn.prop('disabled', false).html(
                            '<i class="bi bi-check-circle me-2"></i>Pesan Sekarang');
                    }
                });
            });
        });
    </script>
@endpush
