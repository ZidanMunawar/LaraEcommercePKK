@extends('admin.layouts.mainLayout')
@section('title', 'Laporan Penjualan')

@section('content')
    <!-- Breadcrumb -->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Laporan</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <ion-icon name="home-sharp"></ion-icon>
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Laporan Penjualan</li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
                <ion-icon name="download-outline" class="align-middle"></ion-icon>
                Export Laporan
            </button>
        </div>
    </div>

    <!-- Filter Periode -->
    <div class="card mb-3">
        <div class="card-body">
            <form action="{{ route('admin.reports.sales') }}" method="GET" id="filterForm">
                <div class="row align-items-end">
                    <!-- Pilihan Periode -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label fw-bold">
                            <ion-icon name="calendar-outline" class="align-middle me-1"></ion-icon>
                            Periode
                        </label>
                        <select class="form-select" name="period" id="periodSelect">
                            <option value="today" {{ $period == 'today' ? 'selected' : '' }}>Hari Ini</option>
                            <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                            <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Kustom</option>
                        </select>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="col-md-3 mb-3" id="startDateGroup"
                        style="display: {{ $period == 'custom' ? 'block' : 'none' }};">
                        <label class="form-label fw-bold">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}"
                            max="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Tanggal Akhir -->
                    <div class="col-md-3 mb-3" id="endDateGroup"
                        style="display: {{ $period == 'custom' ? 'block' : 'none' }};">
                        <label class="form-label fw-bold">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}"
                            max="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Tombol Filter -->
                    <div class="col-md-3 mb-3">
                        <button type="submit" class="btn btn-primary w-100">
                            <ion-icon name="search-outline" class="align-middle me-1"></ion-icon>
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Ringkasan Statistik -->
    <div class="row g-3 mb-3">
        <!-- Total Penjualan -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card radius-10 border-start border-4 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-1">Total Penjualan</p>
                            <h4 class="my-1 text-success fw-bold">
                                Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}
                            </h4>
                            <p class="mb-0 font-13">Transaksi Selesai</p>
                        </div>
                        <div class="widget-icon bg-success text-white">
                            <ion-icon name="cash-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card radius-10 border-start border-4 border-primary">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-1">Total Transaksi</p>
                            <h4 class="my-1 text-primary fw-bold">
                                {{ number_format($summary['total_transactions']) }}
                            </h4>
                            <p class="mb-0 font-13">Transaksi Berhasil</p>
                        </div>
                        <div class="widget-icon bg-primary text-white">
                            <ion-icon name="cart-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk Terjual -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card radius-10 border-start border-4 border-info">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-1">Produk Terjual</p>
                            <h4 class="my-1 text-info fw-bold">
                                {{ number_format($summary['total_products_sold']) }}
                            </h4>
                            <p class="mb-0 font-13">Total Unit</p>
                        </div>
                        <div class="widget-icon bg-info text-white">
                            <ion-icon name="bag-handle-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rata-rata Transaksi -->
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card radius-10 border-start border-4 border-warning">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="mb-1">Rata-rata Transaksi</p>
                            <h4 class="my-1 text-warning fw-bold">
                                Rp {{ number_format($summary['average_order_value'], 0, ',', '.') }}
                            </h4>
                            <p class="mb-0 font-13">Per Transaksi</p>
                        </div>
                        <div class="widget-icon bg-warning text-white">
                            <ion-icon name="stats-chart-outline"></ion-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Transaksi -->
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="card border-warning border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Menunggu Pembayaran</p>
                            <h3 class="mb-0 text-warning">{{ $summary['pending_transactions'] }}</h3>
                        </div>
                        <ion-icon name="time-outline" style="font-size: 48px;" class="text-warning"></ion-icon>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-success border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Transaksi Selesai</p>
                            <h3 class="mb-0 text-success">{{ $summary['total_transactions'] }}</h3>
                        </div>
                        <ion-icon name="checkmark-circle-outline" style="font-size: 48px;"
                            class="text-success"></ion-icon>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-danger border-start border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1">Transaksi Dibatalkan</p>
                            <h3 class="mb-0 text-danger">{{ $summary['cancelled_transactions'] }}</h3>
                        </div>
                        <ion-icon name="close-circle-outline" style="font-size: 48px;" class="text-danger"></ion-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Penjualan -->
    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">
                <ion-icon name="bar-chart-outline" class="align-middle me-2"></ion-icon>
                Grafik Penjualan Harian
            </h5>
        </div>
        <div class="card-body">
            <canvas id="salesChart" height="80"></canvas>
        </div>
    </div>

    <!-- Produk Terlaris & Transaksi Terbaru -->
    <div class="row g-3 mb-3">
        <!-- Produk Terlaris -->
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <ion-icon name="trophy-outline" class="align-middle me-2"></ion-icon>
                        Produk Terlaris
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Produk</th>
                                    <th class="text-center">Terjual</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $index => $item)
                                    <tr>
                                        <td class="text-center">
                                            @if ($index == 0)
                                                <span class="badge bg-warning text-dark">1</span>
                                            @elseif($index == 1)
                                                <span class="badge bg-secondary">2</span>
                                            @elseif($index == 2)
                                                <span class="badge bg-danger">3</span>
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td><strong>{{ $item->produk->name ?? 'N/A' }}</strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary">{{ $item->total_qty }}</span>
                                        </td>
                                        <td class="text-end">
                                            <strong class="text-success">
                                                Rp {{ number_format($item->total_sales, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-4">
                                            <ion-icon name="file-tray-outline"
                                                style="font-size: 48px; opacity: 0.3;"></ion-icon>
                                            <p class="mb-0 mt-2" style="opacity: 0.7;">Belum ada data produk terlaris</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaksi Terbaru -->
        <div class="col-lg-7">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <ion-icon name="list-outline" class="align-middle me-2"></ion-icon>
                        Transaksi Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID Transaksi</th>
                                    <th>Pelanggan</th>
                                    <th class="text-end">Total</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transactions->take(5) as $transaction)
                                    <tr>
                                        <td><small style="opacity: 0.7;">{{ $transaction->transaction_id }}</small></td>
                                        <td>{{ $transaction->customer->nama_lengkap ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <strong class="text-success">
                                                Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = match ($transaction->status) {
                                                    'completed' => 'success',
                                                    'pending' => 'warning',
                                                    'processing' => 'info',
                                                    'shipped' => 'primary',
                                                    default => 'danger',
                                                };
                                                $statusText = match ($transaction->status) {
                                                    'completed' => 'Selesai',
                                                    'pending' => 'Pending',
                                                    'processing' => 'Diproses',
                                                    'shipped' => 'Dikirim',
                                                    default => 'Dibatalkan',
                                                };
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary view-detail-btn"
                                                data-id="{{ $transaction->id_transaksi }}" data-bs-toggle="tooltip"
                                                title="Lihat Detail">
                                                <ion-icon name="eye-outline"></ion-icon>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <ion-icon name="file-tray-outline"
                                                style="font-size: 48px; opacity: 0.3;"></ion-icon>
                                            <p class="mb-0 mt-2" style="opacity: 0.7;">Belum ada transaksi</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Semua Transaksi -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">
                <ion-icon name="receipt-outline" class="align-middle me-2"></ion-icon>
                Semua Transaksi
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>ID Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Pengiriman</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Ongkir</th>
                            <th class="text-end">Total</th>
                            <th>Pembayaran</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>
                                    <small
                                        style="opacity: 0.7;">{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                                </td>
                                <td><strong>{{ $transaction->transaction_id }}</strong></td>
                                <td>
                                    {{ $transaction->customer->nama_lengkap ?? 'N/A' }}<br>
                                    <small style="opacity: 0.7;">{{ $transaction->customer->email ?? '' }}</small>
                                </td>
                                <td><small style="opacity: 0.7;">{{ $transaction->shippingMethod->name ?? 'N/A' }}</small>
                                </td>
                                <td class="text-end">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                                <td class="text-end">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</td>
                                <td class="text-end">
                                    <strong class="text-success">
                                        Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
                                    <span
                                        class="badge bg-secondary">{{ strtoupper($transaction->metode_pembayaran) }}</span>
                                    <br>
                                    @if ($transaction->payment_status == 'paid')
                                        <small class="text-success">
                                            <ion-icon name="checkmark-circle-outline"></ion-icon> Lunas
                                        </small>
                                    @elseif($transaction->payment_status == 'pending')
                                        <small class="text-warning">
                                            <ion-icon name="time-outline"></ion-icon> Pending
                                        </small>
                                    @else
                                        <small class="text-danger">
                                            <ion-icon name="close-circle-outline"></ion-icon> Gagal
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClass = match ($transaction->status) {
                                            'completed' => 'success',
                                            'pending' => 'warning',
                                            'processing' => 'info',
                                            'shipped' => 'primary',
                                            default => 'danger',
                                        };
                                        $statusText = match ($transaction->status) {
                                            'completed' => 'Selesai',
                                            'pending' => 'Pending',
                                            'processing' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            default => 'Batal',
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">
                                        <ion-icon name="ellipse" style="font-size: 8px;"></ion-icon>
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary view-detail-btn"
                                        data-id="{{ $transaction->id_transaksi }}">
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <ion-icon name="file-tray-outline" style="font-size: 64px; opacity: 0.3;"></ion-icon>
                                    <p class="mb-0 mt-2" style="opacity: 0.7;">Belum ada data transaksi pada periode ini
                                    </p>
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

    <!-- Modal Export -->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <ion-icon name="download-outline" class="align-middle me-2"></ion-icon>
                        Export Laporan Penjualan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.reports.export') }}" method="GET">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Format Laporan</label>
                            <div class="d-grid gap-2">
                                <label class="btn btn-outline-success text-start">
                                    <input type="radio" name="format" value="excel" checked hidden>
                                    <ion-icon name="document-text-outline" class="align-middle me-2"></ion-icon>
                                    <strong>Microsoft Excel (.xlsx)</strong>
                                    <br>
                                    <small style="opacity: 0.7;">Format spreadsheet untuk analisis data</small>
                                </label>
                                <label class="btn btn-outline-danger text-start">
                                    <input type="radio" name="format" value="pdf" hidden>
                                    <ion-icon name="document-outline" class="align-middle me-2"></ion-icon>
                                    <strong>PDF Document (.pdf)</strong>
                                    <br>
                                    <small style="opacity: 0.7;">Format dokumen siap cetak</small>
                                </label>
                            </div>
                        </div>

                        <div class="alert alert-info mb-0">
                            <ion-icon name="information-circle-outline" class="align-middle me-1"></ion-icon>
                            Laporan akan diekspor sesuai dengan filter periode yang dipilih
                        </div>

                        <input type="hidden" name="period" value="{{ $period }}">
                        <input type="hidden" name="start_date" value="{{ $startDate }}">
                        <input type="hidden" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline" class="align-middle me-1"></ion-icon>
                            Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <ion-icon name="download-outline" class="align-middle me-1"></ion-icon>
                            Download Laporan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <ion-icon name="receipt-outline" class="align-middle me-2"></ion-icon>
                        Detail Transaksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modalContent">
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3" style="opacity: 0.7;">Memuat data transaksi...</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <ion-icon name="close-outline" class="align-middle me-1"></ion-icon>
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        // Toggle custom date
        document.getElementById('periodSelect').addEventListener('change', function() {
            const startGroup = document.getElementById('startDateGroup');
            const endGroup = document.getElementById('endDateGroup');

            if (this.value === 'custom') {
                startGroup.style.display = 'block';
                endGroup.style.display = 'block';
            } else {
                startGroup.style.display = 'none';
                endGroup.style.display = 'none';
            }
        });

        // Chart
        const chartData = @json($chartData);
        const ctx = document.getElementById('salesChart').getContext('2d');

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: chartData.sales,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y',
                }, {
                    label: 'Jumlah Transaksi',
                    data: chartData.transactions,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.4,
                    fill: true,
                    yAxisID: 'y1',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) label += ': ';
                                if (context.dataset.yAxisID === 'y') {
                                    label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.y);
                                } else {
                                    label += context.parsed.y + ' transaksi';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        grid: {
                            drawOnChartArea: false,
                        },
                    },
                }
            }
        });

        // Detail modal
        document.querySelectorAll('.view-detail-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const transactionId = this.getAttribute('data-id');
                const modal = new bootstrap.Modal(document.getElementById('detailModal'));
                const modalContent = document.getElementById('modalContent');

                modal.show();

                modalContent.innerHTML = `
                    <div class="text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-3" style="opacity: 0.7;">Memuat data transaksi...</p>
                    </div>
                `;

                fetch(`/admin/reports/transaction/${transactionId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const trx = data.transaction;

                            modalContent.innerHTML = `
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <h6 style="opacity: 0.7;" class="mb-3">Informasi Transaksi</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td width="40%"><strong>ID Transaksi</strong></td>
                                                <td>: ${trx.transaction_id}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Tanggal</strong></td>
                                                <td>: ${new Date(trx.created_at).toLocaleString('id-ID')}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>: <span class="badge bg-${getStatusColor(trx.status)}">${getStatusLabel(trx.status)}</span></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Pembayaran</strong></td>
                                                <td>: ${trx.metode_pembayaran.toUpperCase()}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 style="opacity: 0.7;" class="mb-3">Informasi Pelanggan</h6>
                                        <table class="table table-sm">
                                            <tr>
                                                <td width="40%"><strong>Nama</strong></td>
                                                <td>: ${trx.customer.nama_lengkap}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td>: ${trx.customer.email}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>No. Telp</strong></td>
                                                <td>: ${trx.shipping_phone || '-'}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Alamat</strong></td>
                                                <td>: ${trx.shipping_address || '-'}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <hr>
                                <h6 style="opacity: 0.7;" class="mb-3">Detail Produk</h6>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Produk</th>
                                                <th>Varian</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-end">Harga</th>
                                                <th class="text-end">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            ${trx.details.map(detail => `
                                                                <tr>
                                                                    <td><strong>${detail.produk.name}</strong></td>
                                                                    <td>${detail.size ? detail.size.size : '-'} / ${detail.color ? detail.color.name : '-'}</td>
                                                                    <td class="text-center">${detail.qty}</td>
                                                                    <td class="text-end">Rp ${formatRupiah(detail.harga)}</td>
                                                                    <td class="text-end">Rp ${formatRupiah(detail.harga * detail.qty)}</td>
                                                                </tr>
                                                            `).join('')}
                                        </tbody>
                                        <tfoot class="table-light">
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Subtotal:</strong></td>
                                                <td class="text-end"><strong>Rp ${formatRupiah(trx.subtotal)}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Ongkir (${trx.shipping_method ? trx.shipping_method.name : 'N/A'}):</strong></td>
                                                <td class="text-end"><strong>Rp ${formatRupiah(trx.shipping_cost)}</strong></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4" class="text-end"><strong>Diskon:</strong></td>
                                                <td class="text-end"><strong class="text-danger">- Rp ${formatRupiah(trx.discount_amount)}</strong></td>
                                            </tr>
                                            <tr class="table-success">
                                                <td colspan="4" class="text-end"><h5 class="mb-0 text-dark">TOTAL:</h5></td>
                                                <td class="text-end"><h5 class="mb-0 text-success">Rp ${formatRupiah(trx.total_amount)}</h5></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                ${trx.catatan ? `
                                                    <div class="alert alert-info mt-3">
                                                        <strong><ion-icon name="chatbox-outline"></ion-icon> Catatan:</strong><br>
                                                        ${trx.catatan}
                                                    </div>
                                                ` : ''}
                            `;
                        }
                    })
                    .catch(error => {
                        modalContent.innerHTML = `
                            <div class="alert alert-danger">
                                <ion-icon name="warning-outline" class="align-middle me-1"></ion-icon>
                                Gagal memuat data transaksi. Silakan coba lagi.
                            </div>
                        `;
                    });
            });
        });

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
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

        function getStatusLabel(status) {
            const labels = {
                'pending': 'Pending',
                'processing': 'Diproses',
                'shipped': 'Dikirim',
                'completed': 'Selesai',
                'cancelled': 'Dibatalkan'
            };
            return labels[status] || status;
        }

        // Tooltips
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>

    <style>
        .card.radius-10 {
            border-radius: 10px !important;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card.radius-10:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1) !important;
        }

        .widget-icon {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        #salesChart {
            max-height: 400px;
        }

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .btn-outline-success:has(input:checked) {
            background-color: #198754;
            color: white;
            border-color: #198754;
        }

        .btn-outline-danger:has(input:checked) {
            background-color: #dc3545;
            color: white;
            border-color: #dc3545;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
@endsection
