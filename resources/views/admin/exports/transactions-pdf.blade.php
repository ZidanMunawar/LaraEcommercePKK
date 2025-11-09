<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice_number }} - ZynHope Apparel</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #fff;
        }

        .header {
            border-bottom: 2px solid #A0826D;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 20px;
            font-weight: bold;
            color: #A0826D;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            color: #333;
        }

        .info-section {
            margin-bottom: 15px;
            padding: 10px;
            background: #FFF5E6;
            border-radius: 5px;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
            color: #A0826D;
            font-size: 13px;
        }

        .info-row {
            margin-bottom: 3px;
            display: flex;
        }

        .info-label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
            color: #8B6F47;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 11px;
        }

        th {
            background: #A0826D;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            border: 1px solid #8B6F47;
        }

        td {
            padding: 8px;
            border: 1px solid #dee2e6;
            font-size: 10px;
        }

        tr:nth-child(even) {
            background: #f8f9fa;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            margin-top: 20px;
            width: 300px;
            margin-left: auto;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .total-final {
            font-weight: bold;
            border-top: 2px solid #A0826D;
            border-bottom: none;
            font-size: 14px;
            color: #A0826D;
            padding: 10px 0;
            margin-top: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 10px;
        }

        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-paid {
            background: #28a745;
            color: white;
        }

        .status-pending {
            background: #ffc107;
            color: #000;
        }

        .status-failed {
            background: #dc3545;
            color: white;
        }

        .approval-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px dashed #dee2e6;
        }

        .approval-box {
            text-align: center;
            margin-top: 40px;
        }

        .approval-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 200px;
            display: inline-block;
        }

        .approval-name {
            margin-top: 5px;
            font-weight: bold;
            color: #A0826D;
        }

        .approval-role {
            font-size: 10px;
            color: #666;
        }

        .notes-box {
            background: #fff3cd;
            padding: 12px;
            border-radius: 6px;
            border-left: 4px solid #ffc107;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">ZYN HOPE APPAREL</div>
        <div style="font-size: 11px; color: #666;">
            Jl. Buah Batu No. 456, Bandung | zynhopeapparel@gmail.com | 0838-6594-1815
        </div>

        <div class="invoice-title">INVOICE</div>

        <div style="display: grid; grid-template-columns: auto auto auto; gap: 15px; margin: 5px 0; font-size: 11px;">
            <div><strong>No. Pesanan:</strong> {{ $order_number }}</div>
            <div><strong>Tanggal:</strong> {{ $order_date }}</div>
            <div><strong>Jatuh Tempo:</strong> {{ $due_date }}</div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 20px;">
        <!-- Customer Info -->
        <div class="info-section">
            <div class="section-title">INFORMASI PELANGGAN</div>
            <div class="info-row">
                <span class="info-label">Nama:</span> {{ $customer['name'] }}
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span> {{ $customer['email'] }}
            </div>
            <div class="info-row">
                <span class="info-label">Telepon:</span> {{ $customer['phone'] }}
            </div>
            <div class="info-row">
                <span class="info-label">Alamat:</span>
                <div style="margin-top: 5px;">{{ $customer['address'] }}</div>
            </div>
        </div>

        <!-- Shipping & Payment Info -->
        <div class="info-section">
            <div class="section-title">PENGIRIMAN & PEMBAYARAN</div>
            <div class="info-row">
                <span class="info-label">Kurir:</span> {{ $shipping['method'] }}
            </div>
            <div class="info-row">
                <span class="info-label">No. Resi:</span> {{ $shipping['tracking_number'] }}
            </div>
            <div class="info-row">
                <span class="info-label">Alamat Kirim:</span>
                <div style="margin-top: 5px;">{{ $shipping['address'] }}</div>
            </div>
            <div class="info-row">
                <span class="info-label">Pembayaran:</span> {{ $payment['method'] }}
            </div>
            <div class="info-row">
                <span class="info-label">Status:</span>
                <span class="status-badge status-{{ $payment['status'] == 'Lunas' ? 'paid' : 'pending' }}">
                    {{ $payment['status'] }}
                </span>
            </div>
            @if ($payment['paid_at'] != '-')
                <div class="info-row">
                    <span class="info-label">Dibayar:</span> {{ $payment['paid_at'] }}
                </div>
            @endif
        </div>
    </div>

    <!-- Items Table -->
    <div>
        <div class="section-title">DETAIL PRODUK</div>
        <table>
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="35%">Produk</th>
                    <th width="15%">Harga</th>
                    <th width="10%" class="text-center">Qty</th>
                    <th width="15%">Diskon</th>
                    <th width="20%" class="text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <div style="font-weight: bold;">{{ $item['product_name'] }}</div>
                            @if ($item['variant'])
                                <div style="font-size: 9px; color: #666;">{{ $item['variant'] }}</div>
                            @endif
                        </td>
                        <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-right">
                            @if ($item['discount'] > 0)
                                - Rp {{ number_format($item['discount'], 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-right" style="font-weight: bold;">
                            Rp {{ number_format($item['subtotal'], 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="totals">
        <div class="total-row">
            <span>Subtotal:</span>
            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Diskon:</span>
            <span>- Rp {{ number_format($discount_amount, 0, ',', '.') }}</span>
        </div>
        <div class="total-row">
            <span>Ongkos Kirim:</span>
            <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
        </div>
        <div class="total-row total-final">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    <!-- Notes & Approval -->
    <div class="approval-section">
        @if ($notes)
            <div class="notes-box">
                <strong>Catatan Pesanan:</strong><br>
                {{ $notes }}
            </div>
        @endif

        @if ($approved_by)
            <div class="approval-box">
                <div>Disetujui oleh,</div>
                <div class="approval-line"></div>
                <div class="approval-name">{{ $approved_by['name'] }}</div>
                <div class="approval-role">{{ ucfirst($approved_by['role']) }}</div>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>Terima kasih telah berbelanja di Zyn Hope Apparel</strong></p>
        <p>Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan</p>
        <p style="margin-top: 10px;">
            &copy; {{ date('Y') }} Zyn Hope Apparel. All rights reserved.<br>
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}
        </p>
    </div>
</body>

</html>
