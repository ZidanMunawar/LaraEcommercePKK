@extends('admin.layouts.mainLayout')
@section('title', 'Kelola Transaksi')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Manajemen Transaksi</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Transaksi</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            {{-- <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                <ion-icon name="download-outline" class="align-middle"></ion-icon>
                Export
            </button> --}}
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 mb-3">
        <div class="col">
            <div class="card radius-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div>
                            <p class="mb-0 text-secondary">Total Orders</p>
                            <h4 class="my-1" id="stat-total">{{ $transactions->total() }}</h4>
                        </div>
                        <div class="ms-auto widget-icon bg-primary text-white">
                            <ion-icon name="cart-outline"></ion-icon>
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
                            <h4 class="my-1 text-warning" id="stat-pending">
                                {{ $transactions->where('status', 'pending')->count() }}
                            </h4>
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
                            <p class="mb-0 text-secondary">Processing</p>
                            <h4 class="my-1 text-info" id="stat-processing">
                                {{ $transactions->where('status', 'processing')->count() }}
                            </h4>
                        </div>
                        <div class="ms-auto widget-icon bg-info text-white">
                            <ion-icon name="hourglass-outline"></ion-icon>
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
                            <p class="mb-0 text-secondary">Completed</p>
                            <h4 class="my-1 text-success" id="stat-completed">
                                {{ $transactions->where('status', 'completed')->count() }}
                            </h4>
                        </div>
                        <div class="ms-auto widget-icon bg-success text-white">
                            <ion-icon name="checkmark-done-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <h5 class="mb-0">Semua Transaksi</h5>
                <div class="ms-auto">
                    <form method="GET" class="d-flex gap-2">
                        <!-- Filter Status -->
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses
                            </option>
                            <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                            </option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>

                        <!-- Filter Payment -->
                        <select name="payment_status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Semua Pembayaran</option>
                            <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Menunggu
                            </option>
                            <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Lunas
                            </option>
                            <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Gagal
                            </option>
                        </select>

                        <!-- Search -->
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari..."
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-sm btn-primary">
                            <ion-icon name="search-outline"></ion-icon>
                        </button>
                    </form>
                </div>
            </div>


            <!-- TABLE UTAMA TRANSAKSI -->
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Transaksi</th>
                            <th>Customer</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th>Approved By</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $transaction->transaction_id ?? '#' . str_pad($transaction->id_transaksi, 6, '0', STR_PAD_LEFT) }}
                                    </strong>
                                    @if ($transaction->resi_number)
                                        <br><small style="opacity: 0.7;">Resi: {{ $transaction->resi_number }}</small>
                                    @endif
                                </td>
                                <td>
                                    {{ $transaction->customer->nama_lengkap ?? 'N/A' }}<br>
                                    <small style="opacity: 0.7;">{{ $transaction->customer->email ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <small
                                        style="opacity: 0.7;">{{ $transaction->created_at->format('d M Y H:i') }}</small>
                                </td>
                                <td><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></td>
                                <td>
                                    @php
                                        $paymentClass = match ($transaction->payment_status) {
                                            'paid' => 'success',
                                            'pending' => 'warning',
                                            'failed' => 'danger',
                                            default => 'secondary',
                                        };
                                        $paymentText = match ($transaction->payment_status) {
                                            'paid' => 'Lunas',
                                            'pending' => 'Menunggu',
                                            'failed' => 'Gagal',
                                            default => 'Unknown',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $paymentClass }}">{{ $paymentText }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = match ($transaction->status) {
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                            default => 'secondary',
                                        };
                                        $statusText = match ($transaction->status) {
                                            'pending' => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                            default => 'Unknown',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                                {{-- KOLOM APPROVED BY --}}
                                <td>
                                    @if ($transaction->approvedBy)
                                        <small>
                                            {{ $transaction->approvedBy->nama_lengkap }}<br>
                                            <span class="badge bg-secondary">{{ $transaction->approvedBy->role }}</span>
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <!-- Lihat detail (modal) -->
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                            data-bs-target="#viewTransactionModal"
                                            onclick="loadTransactionDetails({{ $transaction->id_transaksi }})"
                                            title="Lihat Detail">
                                            <ion-icon name="eye-outline"></ion-icon>
                                        </button>

                                        <!-- Generate Invoice -->
                                        <a href="{{ route('admin.transactions.invoice', $transaction->id_transaksi) }}"
                                            class="btn btn-sm btn-dark" title="Download Invoice" target="_blank">
                                            <ion-icon name="document-text-outline"></ion-icon>
                                        </a>
                                        <!-- Edit status pesanan -->
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editStatusModal"
                                            onclick="openEditStatus({{ $transaction->id_transaksi }}, '{{ $transaction->status }}')"
                                            title="Ubah Status">
                                            <ion-icon name="create-outline"></ion-icon>
                                        </button>

                                        <!-- Tambah resi (jika belum dikirim/selesai) -->
                                        @if ($transaction->status != 'shipped' && $transaction->status != 'completed')
                                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                data-bs-target="#addResiModal"
                                                onclick="openAddResi({{ $transaction->id_transaksi }})"
                                                title="Tambah Resi">
                                                <ion-icon name="cube-outline"></ion-icon>
                                            </button>
                                        @endif

                                        <!-- Verifikasi pembayaran (jika ada bukti & pending) -->
                                        @if ($transaction->payment_proof && $transaction->payment_status == 'pending')
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#verifyPaymentModal"
                                                onclick="loadPaymentVerification({{ $transaction->id_transaksi }})"
                                                title="Verifikasi Pembayaran">
                                                <ion-icon name="card-outline"></ion-icon>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <ion-icon name="receipt-outline" style="font-size: 64px; color: #ccc;"></ion-icon>
                                    <p class="text-muted mt-2 mb-0">Belum ada transaksi</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($transactions->hasPages())
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Include Modals -->
    @include('admin.modals.transactions.view')
    @include('admin.modals.transactions.edit-status')
    @include('admin.modals.transactions.add-resi')
    @include('admin.modals.transactions.verify-payment')
    @include('admin.modals.transactions.export')


    <!-- JAVASCRIPT -->
    <script>
        (function() {
            'use strict';

            console.log('🚀 Transaction Management Page Loaded');
            console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

            // ==========================================
            // CONFIGURATION
            // ==========================================
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            console.log('🔑 CSRF Token:', csrfToken ? '✓ Found' : '✗ NOT FOUND');

            if (!csrfToken) {
                console.error(
                    '❌ CSRF Token missing! Add <meta name="csrf-token" content="{{ csrf_token() }}"> to layout');
            }

            // BASE URL - Sesuaikan dengan route lu (dobel atau single)
            const BASE_URL = '/admin/transactions/transactions'; // Ganti jadi '/admin/transactions' jika route udah fix
            console.log('🌐 Base URL:', BASE_URL);

            // ==========================================
            // HELPER FUNCTIONS
            // ==========================================

            function safeSetText(elementId, value) {
                const element = document.getElementById(elementId);
                if (element) {
                    element.textContent = value || '-';
                    return true;
                } else {
                    console.warn(`⚠️ Element #${elementId} not found in DOM`);
                    return false;
                }
            }

            function safeSetHTML(elementId, html) {
                const element = document.getElementById(elementId);
                if (element) {
                    element.innerHTML = html;
                    return true;
                } else {
                    console.warn(`⚠️ Element #${elementId} not found in DOM`);
                    return false;
                }
            }

            function getStatusColor(status) {
                const colors = {
                    'pending': 'warning',
                    'processing': 'info',
                    'shipped': 'primary',
                    'completed': 'success',
                    'cancelled': 'danger'
                };
                return colors[status] || 'secondary';
            }

            function getPaymentColor(status) {
                const colors = {
                    'pending': 'warning',
                    'paid': 'success',
                    'failed': 'danger',
                    'refunded': 'info'
                };
                return colors[status] || 'secondary';
            }

            function formatRupiah(amount) {
                return 'Rp ' + parseInt(amount || 0).toLocaleString('id-ID');
            }

            // ==========================================
            // LOAD TRANSACTION DETAILS
            // ==========================================
            window.loadTransactionDetails = function(id) {
                console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                console.log('🔍 Loading Transaction Details');
                console.log('📌 Transaction ID:', id);

                const url = `${BASE_URL}/${id}`;
                console.log('📍 Request URL:', url);

                fetch(url, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                    .then(response => {
                        console.log('📡 Response Status:', response.status, response.ok ? '✓' : '✗');
                        if (!response.ok) throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                        return response.json();
                    })
                    .then(data => {
                        console.log('📦 Raw Response:', data);
                        if (data.success) {
                            console.log('✅ Data received successfully');
                            populateViewModal(data.data);
                        } else {
                            throw new Error(data.message || 'API returned success: false');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Fetch Error:', error);
                        alert('Failed to load transaction: ' + error.message);
                    });
            };

            // ==========================================
            // POPULATE VIEW MODAL
            // ==========================================
            function populateViewModal(data) {
                console.log('🎨 Populating View Modal');

                try {
                    safeSetText('viewOrderId', data.transaction_id || '#' + data.id_transaksi);
                    safeSetText('viewCustomerName', data.customer?.nama_lengkap);
                    safeSetText('viewCustomerEmail', data.customer?.email);
                    safeSetText('viewCustomerPhone', data.shipping_phone || data.customer?.no_telp);

                    let address = [];
                    if (data.shipping_address) address.push(data.shipping_address);
                    if (data.shipping_village_name) address.push(data.shipping_village_name);
                    if (data.shipping_district_name) address.push(data.shipping_district_name);
                    if (data.shipping_regency_name) address.push(data.shipping_regency_name);
                    if (data.shipping_province_name) address.push(data.shipping_province_name);
                    if (data.shipping_postal_code) address.push(data.shipping_postal_code);
                    safeSetText('viewCustomerAddress', address.join(', '));

                    const orderDate = new Date(data.created_at);
                    safeSetText('viewOrderDate', orderDate.toLocaleDateString('id-ID', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit'
                    }));

                    const statusBadge = document.getElementById('viewOrderStatus');
                    if (statusBadge) {
                        const statusText = (data.status || 'unknown').charAt(0).toUpperCase() + (data.status ||
                            'unknown').slice(1);
                        statusBadge.textContent = statusText;
                        statusBadge.className = 'badge bg-' + getStatusColor(data.status);
                    }

                    const paymentBadge = document.getElementById('viewPaymentStatus');
                    if (paymentBadge) {
                        const paymentText = (data.payment_status || 'unknown').charAt(0).toUpperCase() + (data
                            .payment_status || 'unknown').slice(1);
                        paymentBadge.textContent = paymentText;
                        paymentBadge.className = 'badge bg-' + getPaymentColor(data.payment_status);
                    }

                    safeSetText('viewPaymentMethod', (data.metode_pembayaran || '-').toUpperCase().replace('_', ' '));
                    safeSetText('viewShippingMethod', data.shipping_method?.name);
                    safeSetText('viewResiNumber', data.resi_number || 'Not available');
                    safeSetText('viewNotes', data.catatan || 'No notes');

                    const itemsBody = document.getElementById('viewOrderItems');
                    if (!itemsBody) {
                        console.error('❌ Element #viewOrderItems not found');
                    } else if (data.details && Array.isArray(data.details) && data.details.length > 0) {
                        console.log('✓ Found', data.details.length, 'items');

                        const itemsHTML = data.details.map((item, index) => {
                            const subtotal = (parseFloat(item.harga || 0) * parseInt(item.qty || 0)) -
                                parseFloat(item.diskon || 0);
                            let variantHTML = [];
                            if (item.size && item.size.size) {
                                variantHTML.push(
                                    `<span class="badge bg-secondary">Size: ${item.size.size}</span>`);
                            }
                            if (item.color && item.color.name) {
                                variantHTML.push(
                                    `<span class="badge bg-primary ms-1">Color: ${item.color.name}</span>`);
                            }

                            return `
                            <tr>
                                <td>${item.product_name || 'Unknown Product'}</td>
                                <td>${variantHTML.length > 0 ? variantHTML.join(' ') : '-'}</td>
                                <td>${formatRupiah(item.harga)}</td>
                                <td class="text-center">${item.qty || 0}</td>
                                <td class="text-end"><strong>${formatRupiah(subtotal)}</strong></td>
                            </tr>
                        `;
                        }).join('');

                        itemsBody.innerHTML = itemsHTML;
                        console.log('✅ Items rendered successfully');
                    } else {
                        console.warn('⚠️ No items found');
                        itemsBody.innerHTML =
                            '<tr><td colspan="6" class="text-center text-muted py-4">No items found</td></tr>';
                    }

                    safeSetText('viewSubtotal', formatRupiah(data.subtotal));
                    safeSetText('viewDiscount', '- ' + formatRupiah(data.discount_amount));
                    safeSetText('viewShippingCost', formatRupiah(data.shipping_cost));
                    safeSetHTML('viewTotal',
                        `<strong class="fs-5 text-success">${formatRupiah(data.total_amount)}</strong>`);

                    console.log('✅ Modal populated successfully');
                } catch (error) {
                    console.error('❌ Error populating modal:', error);
                    alert('Error displaying data: ' + error.message);
                }
            }

            // ==========================================
            // OPEN EDIT STATUS MODAL
            // ==========================================
            window.openEditStatus = function(id, currentStatus) {
                console.log('✏️ Opening Edit Status Modal - ID:', id, '| Status:', currentStatus);
                const idInput = document.getElementById('editStatusTransactionId');
                const statusSelect = document.getElementById('editStatus');
                if (idInput) idInput.value = id;
                if (statusSelect) statusSelect.value = currentStatus;
            };

            // ==========================================
            // OPEN ADD RESI MODAL
            // ==========================================
            window.openAddResi = function(id) {
                console.log('📦 Opening Add Resi Modal - ID:', id);

                fetch(`${BASE_URL}/${id}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const transaction = data.data;
                            const idInput = document.getElementById('addResiTransactionId');
                            const resiInput = document.getElementById('resiNumber');

                            if (idInput) idInput.value = id;

                            if (transaction.resi_number) {
                                if (resiInput) resiInput.value = transaction.resi_number;

                                const modalBody = document.querySelector('#addResiModal .modal-body');
                                let warningDiv = document.getElementById('resiWarning');

                                if (!warningDiv) {
                                    warningDiv = document.createElement('div');
                                    warningDiv.id = 'resiWarning';
                                    warningDiv.className = 'alert alert-info';
                                    modalBody.insertBefore(warningDiv, modalBody.firstChild);
                                }

                                warningDiv.innerHTML = `
                            <ion-icon name="information-circle-outline"></ion-icon>
                            <strong>Existing Resi:</strong> This order already has resi number <strong>${transaction.resi_number}</strong>.
                            You can update it by entering a new resi number below.
                        `;
                            } else {
                                if (resiInput) resiInput.value = '';
                                const warningDiv = document.getElementById('resiWarning');
                                if (warningDiv) warningDiv.remove();
                            }
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error loading resi:', error);
                        const idInput = document.getElementById('addResiTransactionId');
                        const resiInput = document.getElementById('resiNumber');
                        if (idInput) idInput.value = id;
                        if (resiInput) resiInput.value = '';
                    });
            };
            window.loadPaymentVerification = function(id) {
                console.log('💳 Loading Payment Verification - ID:', id);

                fetch(`${BASE_URL}/${id}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            populateVerifyModal(data.data);
                        } else {
                            throw new Error(data.message || 'Failed to load payment details');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        alert('Error: ' + error.message);
                    });
            };

            function populateVerifyModal(data) {
                console.log('💳 Populating Verify Payment Modal');
                console.log('   Transaction ID:', data.id_transaksi);

                try {
                    // PENTING: Set hidden input dengan .value
                    const idInput = document.getElementById('verifyPaymentTransactionId');
                    if (idInput) {
                        idInput.value = data.id_transaksi;
                        console.log('✓ Set transaction ID:', data.id_transaksi);
                    } else {
                        console.error('❌ Element #verifyPaymentTransactionId not found!');
                    }

                    safeSetText('verifyOrderNumber', data.transaction_id || '#' + data.id_transaksi);
                    safeSetText('verifyTotalAmount', formatRupiah(data.total_amount));
                    safeSetText('verifyPaymentMethod', (data.metode_pembayaran || '-').toUpperCase().replace('_', ' '));

                    const proofImg = document.getElementById('paymentProofImage');
                    if (proofImg && data.payment_proof) {
                        proofImg.src = '/storage/' + data.payment_proof;
                        proofImg.style.display = 'block';
                    } else if (proofImg) {
                        proofImg.style.display = 'none';
                    }

                    if (data.payment_proof_uploaded_at) {
                        const uploadDate = new Date(data.payment_proof_uploaded_at);
                        safeSetText('verifyUploadedAt', uploadDate.toLocaleString('id-ID'));
                    } else {
                        safeSetText('verifyUploadedAt', 'Not available');
                    }

                    const actionSelect = document.getElementById('verifyAction');
                    const rejectReason = document.getElementById('rejectReason');
                    const rejectDiv = document.getElementById('rejectReasonDiv');

                    if (actionSelect) actionSelect.value = '';
                    if (rejectReason) rejectReason.value = '';
                    if (rejectDiv) rejectDiv.style.display = 'none';

                    console.log('✅ Verify modal populated');
                } catch (error) {
                    console.error('❌ Error populating verify modal:', error);
                    alert('Error: ' + error.message);
                }
            }
            window.submitStatusUpdate = function() {
                console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                console.log('📤 Submitting Status Update');

                const id = document.getElementById('editStatusTransactionId')?.value;
                const status = document.getElementById('editStatus')?.value;
                const btn = document.getElementById('submitStatusUpdate');

                if (!id || !status) {
                    alert('Missing transaction ID or status');
                    return;
                }

                console.log('   ID:', id, '| New Status:', status);

                if (!confirm(`Change status to "${status}"?`)) return;

                btn.disabled = true;
                btn.textContent = 'Updating...';

                fetch(`${BASE_URL}/${id}/status`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('📥 Response:', data);
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            throw new Error(data.message || 'Failed to update status');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        alert('Error: ' + error.message);
                        btn.disabled = false;
                        btn.innerHTML = '<ion-icon name="checkmark-outline"></ion-icon> Update Status';
                    });
            };
            window.submitResiUpdate = function() {
                console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                console.log('📤 Submitting Resi Update');

                const id = document.getElementById('addResiTransactionId')?.value;
                const resi = document.getElementById('resiNumber')?.value?.trim();
                const btn = document.getElementById('submitResiUpdate');

                if (!id) {
                    alert('Missing transaction ID');
                    return;
                }

                if (!resi) {
                    alert('Please enter resi number');
                    return;
                }

                console.log('   ID:', id, '| Resi:', resi);

                btn.disabled = true;
                btn.textContent = 'Updating...';

                fetch(`${BASE_URL}/${id}/resi`, {
                        method: 'PUT',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            resi_number: resi
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('📥 Response:', data);
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            throw new Error(data.message || 'Failed to update resi');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        alert('Error: ' + error.message);
                        btn.disabled = false;
                        btn.innerHTML = '<ion-icon name="cube-outline"></ion-icon> Submit Resi';
                    });
            };
            window.submitPaymentVerification = function() {
                console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
                console.log('📤 Submitting Payment Verification');

                const id = document.getElementById('verifyPaymentTransactionId')?.value;
                const action = document.getElementById('verifyAction')?.value;
                const rejectReason = document.getElementById('rejectReason')?.value?.trim();
                const btn = document.getElementById('submitPaymentVerification');

                console.log('   Retrieved ID:', id);
                console.log('   Action:', action);

                if (!id) {
                    alert('Missing transaction ID');
                    console.error('❌ Transaction ID not found in hidden input');
                    return;
                }

                if (!action) {
                    alert('Please select an action (Approve or Reject)');
                    return;
                }

                if (action === 'reject' && !rejectReason) {
                    alert('Please enter reject reason');
                    return;
                }

                if (!confirm(`Are you sure you want to ${action} this payment?`)) return;

                btn.disabled = true;
                btn.textContent = 'Processing...';

                const payload = {
                    action: action
                };
                if (action === 'reject' && rejectReason) {
                    payload.reject_reason = rejectReason;
                }

                console.log('📦 Payload:', payload);

                fetch(`${BASE_URL}/${id}/verify-payment`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(payload)
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('📥 Response:', data);
                        if (data.success) {
                            alert(data.message);
                            location.reload();
                        } else {
                            throw new Error(data.message || 'Failed to verify payment');
                        }
                    })
                    .catch(error => {
                        console.error('❌ Error:', error);
                        alert('Error: ' + error.message);
                        btn.disabled = false;
                        btn.innerHTML = '<ion-icon name="checkmark-outline"></ion-icon> Submit Verification';
                    });
            };
            window.handleExport = function() {
                console.log('📥 Exporting transactions...');

                // Get selected export type
                const exportType = document.querySelector('input[name="exportType"]:checked')?.value || 'csv';
                console.log('   Export type:', exportType);

                // Get current filters
                const params = new URLSearchParams(window.location.search);
                const status = params.get('status') || '';
                const paymentStatus = params.get('payment_status') || '';
                const search = params.get('search') || '';

                // Build export URL
                let exportUrl = `${BASE_URL}/export?type=${exportType}`;
                if (status) exportUrl += `&status=${status}`;
                if (paymentStatus) exportUrl += `&payment_status=${paymentStatus}`;
                if (search) exportUrl += `&search=${encodeURIComponent(search)}`;

                console.log('📍 Export URL:', exportUrl);

                // Close modal
                const modal = bootstrap.Modal.getInstance(document.getElementById('exportModal'));
                if (modal) modal.hide();

                // Trigger download
                window.location.href = exportUrl;
            };
            const verifyAction = document.getElementById('verifyAction');
            if (verifyAction) {
                verifyAction.addEventListener('change', function() {
                    const rejectDiv = document.getElementById('rejectReasonDiv');
                    const rejectReason = document.getElementById('rejectReason');

                    if (this.value === 'reject') {
                        if (rejectDiv) rejectDiv.style.display = 'block';
                        if (rejectReason) rejectReason.required = true;
                    } else {
                        if (rejectDiv) rejectDiv.style.display = 'none';
                        if (rejectReason) {
                            rejectReason.required = false;
                            rejectReason.value = '';
                        }
                    }
                });
            }

            console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            console.log('✅ All functions loaded successfully');
            console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        })();
    </script>
    <!-- Export Modal -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <ion-icon name="download-outline"></ion-icon> Export Transactions
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Export Format</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportType" id="exportCSV"
                                value="csv" checked>
                            <label class="form-check-label" for="exportCSV">
                                <strong>CSV</strong> - Excel compatible spreadsheet
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exportType" id="exportPDF"
                                value="pdf">
                            <label class="form-check-label" for="exportPDF">
                                <strong>PDF</strong> - Printable document
                            </label>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <ion-icon name="information-circle-outline"></ion-icon>
                        <strong>Note:</strong> Export will include current filters (status, payment status, search).
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="handleExport()">
                        <ion-icon name="download-outline"></ion-icon> Download
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
