<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Invoice {{ $order->transaction_id }} - ZynHope Apparel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #A0826D;
            padding-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #A0826D;
            margin-bottom: 5px;
        }

        .invoice-title {
            font-size: 20px;
            margin: 10px 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            background: #f5f1ed;
            padding: 8px 12px;
            font-weight: bold;
            border-left: 4px solid #A0826D;
        }

        .row {
            display: flex;
            margin-bottom: 8px;
        }

        .col-6 {
            width: 50%;
        }

        .label {
            font-weight: bold;
            color: #8B6F47;
            min-width: 120px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .table th {
            background: #A0826D;
            color: white;
            padding: 10px;
            text-align: left;
        }

        .table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .total-row {
            font-weight: bold;
            background: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="company-name">ZynHope Apparel</div>
        <div class="invoice-title">INVOICE</div>
        <div>Order #: {{ $order->transaction_id }}</div>
        <div>Date: {{ $order->created_at->format('d F Y') }}</div>
    </div>

    <div class="row">
        <div class="col-6">
            <div class="section">
                <div class="section-title">Bill To</div>
                <div><strong>{{ $order->customer->name }}</strong></div>
                <div>Email: {{ $order->customer->email }}</div>
                <div>Phone: {{ $order->customer->phone ?? 'N/A' }}</div>
            </div>
        </div>
        <div class="col-6">
            <div class="section">
                <div class="section-title">Order Details</div>
                <div class="row"><span class="label">Order ID:</span> {{ $order->transaction_id }}</div>
                <div class="row"><span class="label">Order Date:</span>
                    {{ $order->created_at->format('d M Y, H:i') }}</div>
                <div class="row"><span class="label">Status:</span> {{ ucfirst($order->payment_status) }}</div>
            </div>
        </div>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Variant</th>
                <th class="text-right">Price</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->details as $detail)
                <tr>
                    <td>{{ $detail->produk->name }}</td>
                    <td>
                        @if ($detail->size || $detail->color)
                            @if ($detail->size)
                                Size: {{ $detail->size->size }}
                            @endif
                            @if ($detail->color)
                                @if ($detail->size)
                                    |
                                @endifColor: {{ $detail->color->name }}
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right">Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $detail->qty }}</td>
                    <td class="text-right">Rp {{ number_format($detail->harga * $detail->qty, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Subtotal:</td>
                <td class="text-right">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">Shipping:</td>
                <td class="text-right">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Thank you for your business!<br>
        ZynHope Apparel - Quality Fashion for Everyone<br>
        Contact: support@zynhope.com | www.zynhope.com
    </div>
</body>

</html>
