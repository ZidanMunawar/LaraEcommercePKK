<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice {{ $invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 10px;
            color: #333;
            line-height: 1.2;
        }

        .header {
            border-bottom: 2px solid #FF6600;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #FF6600;
        }

        .invoice-title {
            font-size: 16px;
            font-weight: bold;
            margin: 8px 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }

        .info-box {
            padding: 6px;
            background: #FFF5E6;
            border-left: 3px solid #FF6600;
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 4px;
            color: #FF6600;
            font-size: 11px;
        }

        .info-row {
            margin-bottom: 2px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 70px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 10px;
        }

        th {
            background: #FF6600;
            color: white;
            padding: 6px 4px;
            text-align: left;
        }

        td {
            padding: 5px 4px;
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            width: 200px;
            margin-left: auto;
            margin-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
        }

        .total-final {
            font-weight: bold;
            border-top: 1px solid #FF6600;
            margin-top: 3px;
            padding-top: 5px;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 9px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
        }

        .status {
            display: inline-block;
            padding: 1px 6px;
            background: #FF6600;
            color: white;
            border-radius: 2px;
            font-size: 9px;
            font-weight: bold;
        }

        .meta-info {
            display: grid;
            grid-template-columns: auto auto auto;
            gap: 15px;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">ZYN HOPE APPAREL</div>
        <div>Jl. Buah Batu No. 456, Bandung</div>
        <div>zynhopeapparel@gmail.com | 0838-6594-1815</div>

        <div class="invoice-title">INVOICE</div>

        <div class="meta-info">
            <div><strong>No. Pesanan:</strong> {{ $order_number }}</div>
            <div><strong>Tanggal:</strong> {{ $order_date }}</div>
        </div>
        <div><strong>Jatuh Tempo:</strong> {{ $due_date }}</div>
    </div>

    <div class="info-grid">
        <div class="info-box">
            <div class="section-title">PELANGGAN</div>
            <div class="info-row"><span class="info-label">Nama:</span> {{ $customer['name'] }}</div>
            <div class="info-row"><span class="info-label">Email:</span> {{ $customer['email'] }}</div>
            <div class="info-row"><span class="info-label">Telp:</span> {{ $customer['phone'] }}</div>
            <div class="info-row"><span class="info-label">Alamat:</span> {{ $customer['address'] }}</div>
        </div>

        <div class="info-box">
            <div class="section-title">PENGIRIMAN & BAYAR</div>
            <div class="info-row"><span class="info-label">Kurir:</span> {{ $shipping['method'] }}</div>
            <div class="info-row"><span class="info-label">Resi:</span> {{ $shipping['tracking_number'] }}</div>
            <div class="info-row"><span class="info-label">Bayar:</span> {{ $payment['method'] }}</div>
            <div class="info-row"><span class="info-label">Status:</span> <span
                    class="status">{{ $payment['status'] }}</span></div>
            @if ($payment['paid_at'] != '-')
                <div class="info-row"><span class="info-label">Dibayar:</span> {{ $payment['paid_at'] }}</div>
            @endif
        </div>
    </div>

    <div class="section-title">DETAIL PRODUK</div>
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="41%">Produk</th>
                <th width="15%">Harga</th>
                <th width="8%">Qty</th>
                <th width="16%">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div>{{ $item['product_name'] }}</div>
                        @if ($item['variant'])
                            <div style="font-size:9px;color:#666;">{{ $item['variant'] }}</div>
                        @endif
                    </td>
                    <td>Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
            <span>Ongkir:</span>
            <span>Rp {{ number_format($shipping_cost, 0, ',', '.') }}</span>
        </div>
        <div class="total-row total-final">
            <span>TOTAL:</span>
            <span>Rp {{ number_format($total_amount, 0, ',', '.') }}</span>
        </div>
    </div>

    @if ($notes)
        <div class="info-box" style="margin-top: 8px;">
            <div class="section-title">CATATAN</div>
            {{ $notes }}
        </div>
    @endif

    @if ($approved_by)
        <div style="margin-top: 20px; text-align: center;">
            <div>Disetujui,</div>
            <div style="margin-top: 25px; border-top: 1px solid #333; width: 150px; display: inline-block;"></div>
            <div style="margin-top: 3px; font-weight: bold;">{{ $approved_by['name'] }}</div>
            <div style="font-size: 9px;">{{ $approved_by['role'] }}</div>
        </div>
    @endif

    <div class="footer">
        <div><strong>Terima kasih berbelanja di Zyn Hope Apparel</strong></div>
        <div>Invoice sah tanpa tanda tangan</div>
        <div style="margin-top: 3px;">
            &copy; {{ date('Y') }} Zyn Hope Apparel |
            Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
        </div>
    </div>
</body>

</html>
