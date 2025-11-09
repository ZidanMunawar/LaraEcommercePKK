<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Laporan Penjualan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            padding: 15px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #0d6efd;
            padding-bottom: 15px;
        }

        .header h1 {
            font-size: 20px;
            color: #0d6efd;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header .subtitle {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }

        .info-box {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #0d6efd;
        }

        .info-box h3 {
            font-size: 12px;
            margin-bottom: 8px;
            color: #0d6efd;
        }

        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }

        .summary-item {
            display: table-cell;
            width: 25%;
            padding: 8px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        .summary-item strong {
            display: block;
            font-size: 9px;
            color: #666;
            margin-bottom: 5px;
        }

        .summary-item .value {
            font-size: 14px;
            font-weight: bold;
            color: #0d6efd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table thead {
            background: #0d6efd;
            color: white;
        }

        table th {
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #0d6efd;
        }

        table td {
            padding: 6px 5px;
            font-size: 8px;
            border: 1px solid #dee2e6;
            vertical-align: top;
        }

        table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: #000;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #6c757d;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p class="subtitle">E-Commerce Management System</p>
        <p class="subtitle">Periode: {{ $dateRange['start']->format('d M Y') }} -
            {{ $dateRange['end']->format('d M Y') }}</p>
        <p class="subtitle">Dicetak: {{ $exportDate }}</p>
    </div>

    <!-- Summary Statistics -->
    <div class="summary-grid">
        <div class="summary-item">
            <strong>Total Penjualan</strong>
            <span class="value">Rp {{ number_format($summary['total_sales'], 0, ',', '.') }}</span>
        </div>
        <div class="summary-item">
            <strong>Total Transaksi</strong>
            <span class="value">{{ number_format($summary['total_transactions']) }}</span>
        </div>
        <div class="summary-item">
            <strong>Produk Terjual</strong>
            <span class="value">{{ number_format($summary['total_products_sold']) }}</span>
        </div>
        <div class="summary-item">
            <strong>Rata-rata</strong>
            <span class="value">Rp {{ number_format($summary['average_order_value'], 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Produk Terlaris -->
    @if ($topProducts->isNotEmpty())
        <div class="info-box">
            <h3>Produk Terlaris</h3>
            <table>
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="55%">Nama Produk</th>
                        <th width="20%" class="text-center">Terjual</th>
                        <th width="20%" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($topProducts as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td><strong>{{ $item->produk->name ?? 'N/A' }}</strong></td>
                            <td class="text-center">{{ $item->total_qty }} unit</td>
                            <td class="text-right"><strong>Rp
                                    {{ number_format($item->total_sales, 0, ',', '.') }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <!-- Daftar Transaksi -->
    <h3 style="margin-top: 20px; margin-bottom: 10px; color: #0d6efd;">Daftar Transaksi</h3>
    <table>
        <thead>
            <tr>
                <th width="10%">Tanggal</th>
                <th width="12%">ID Transaksi</th>
                <th width="20%">Customer</th>
                <th width="13%" class="text-right">Subtotal</th>
                <th width="10%" class="text-right">Ongkir</th>
                <th width="13%" class="text-right">Total</th>
                <th width="10%">Bayar</th>
                <th width="12%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $trx)
                <tr>
                    <td>{{ $trx->created_at->format('d/m/Y') }}</td>
                    <td><strong>{{ $trx->transaction_id }}</strong></td>
                    <td>{{ $trx->customer->nama_lengkap ?? 'N/A' }}</td>
                    <td class="text-right">Rp {{ number_format($trx->subtotal, 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($trx->shipping_cost, 0, ',', '.') }}</td>
                    <td class="text-right"><strong>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        @php
                            $paymentClass = match ($trx->payment_status) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                default => 'danger',
                            };
                            $paymentText = match ($trx->payment_status) {
                                'paid' => 'Lunas',
                                'pending' => 'Pending',
                                default => 'Gagal',
                            };
                        @endphp
                        <span class="badge badge-{{ $paymentClass }}">{{ $paymentText }}</span>
                    </td>
                    <td>
                        @php
                            $statusClass = match ($trx->status) {
                                'completed' => 'success',
                                'pending' => 'warning',
                                default => 'danger',
                            };
                            $statusText = match ($trx->status) {
                                'completed' => 'Selesai',
                                'pending' => 'Pending',
                                'processing' => 'Diproses',
                                'shipped' => 'Dikirim',
                                default => 'Batal',
                            };
                        @endphp
                        <span class="badge badge-{{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Dokumen ini dibuat secara otomatis oleh sistem.</strong></p>
        <p>&copy; {{ date('Y') }} ZynHope E-Commerce. All Rights Reserved.</p>
    </div>
</body>

</html>
