<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Data Produk - ZynHope Apparel</title>
    <style>
        @page {
            margin: 20px;
            size: landscape;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #A0826D;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #A0826D;
            margin-bottom: 5px;
        }

        .report-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }

        .report-info {
            font-size: 10px;
            color: #666;
        }

        .filters {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 4px solid #A0826D;
        }

        .filters strong {
            color: #A0826D;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        th {
            background: #A0826D;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
        }

        td {
            padding: 6px;
            border: 1px solid #ddd;
            font-size: 8px;
            vertical-align: top;
        }

        tr:nth-child(even) {
            background: #f9f9f9;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
        }

        .badge-success {
            background: #28a745;
            color: white;
        }

        .badge-warning {
            background: #ffc107;
            color: black;
        }

        .badge-danger {
            background: #dc3545;
            color: white;
        }

        .badge-secondary {
            background: #6c757d;
            color: white;
        }

        .product-image {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #ddd;
        }

        .summary {
            margin-top: 20px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 5px;
            font-size: 9px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #ddd;
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
        <div class="company-name">ZYN HOPE APPAREL</div>
        <div class="report-title">LAPORAN DATA PRODUK</div>
        <div class="report-info">
            Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }} |
            Halaman: <span class="page-number"></span>
        </div>
    </div>

    {{-- <!-- Filter Info -->
    @if (!empty(array_filter($filters)))
        <div class="filters">
            <strong>Filter yang diterapkan:</strong><br>
            @if (!empty($filters['category']))
                • Kategori: {{ \App\Models\Category::find($filters['category'])->name ?? 'N/A' }}<br>
            @endif
            @if (!empty($filters['audience']))
                • Audience: {{ \App\Models\Audience::find($filters['audience'])->name ?? 'N/A' }}<br>
            @endif
            @if (!empty($filters['availability']))
                • Ketersediaan: {{ $filters['availability'] == 'available' ? 'Tersedia' : 'Habis' }}<br>
            @endif
            @if (!empty($filters['featured']))
                • Unggulan: {{ $filters['featured'] == 'featured' ? 'Ya' : 'Tidak' }}<br>
            @endif
            @if (!empty($filters['date_from']) || !empty($filters['date_to']))
                • Tanggal:
                {{ $filters['date_from'] ?? 'Semua' }}
                sampai
                {{ $filters['date_to'] ?? 'Sekarang' }}<br>
            @endif
        </div>
    @endif --}}

    <div style="font-size: 11px; margin-top: 10px;">
        <strong>Filter yang diterapkan:</strong><br>
        • Kategori: {{ $filters['category'] }}<br>
        • Status: {{ $filters['status'] }}<br>
        • Pencarian: {{ $filters['search'] }}<br>
        • Urutan: {{ $filters['sort'] }}<br>
        • Tanggal: {{ $filters['date_range'] }}
    </div>

    <!-- Products Table -->
    <table>
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="8%">Gambar</th>
                <th width="15%">Nama Produk</th>
                <th width="10%">Kategori</th>
                <th width="8%">Harga</th>
                <th width="6%">Stok</th>
                <th width="8%">Status</th>
                <th width="10%">Warna</th>
                <th width="8%">Ukuran</th>
                <th width="8%">Audience</th>
                <th width="8%">Flags</th>
                <th width="7%">Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $index => $product)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        @if ($product->images->isNotEmpty())
                            <img src="{{ storage_path('app/public/' . $product->images->first()->image_url) }}"
                                class="product-image" alt="{{ $product->name }}">
                        @else
                            <div
                                style="width: 40px; height: 40px; background: #f0f0f0; display: flex; align-items: center; justify-content: center; border-radius: 3px;">
                                <span style="font-size: 6px; color: #999;">No Image</span>
                            </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $product->name }}</strong>
                        @if ($product->description)
                            <br><small
                                style="color: #666;">{{ Str::limit(strip_tags($product->description), 50) }}</small>
                        @endif
                    </td>
                    <td>
                        @foreach ($product->categories as $category)
                            <span class="badge badge-secondary">{{ $category->name }}</span><br>
                        @endforeach
                    </td>
                    <td>
                        <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                        @if ($product->old_price && $product->old_price > $product->price)
                            <br><small style="color: #dc3545; text-decoration: line-through;">
                                Rp {{ number_format($product->old_price, 0, ',', '.') }}
                            </small>
                        @endif
                    </td>
                    <td class="text-center">{{ $product->quantity }}</td>
                    <td class="text-center">
                        @if ($product->is_available && $product->quantity > 0)
                            <span class="badge badge-success">Tersedia</span>
                        @elseif($product->quantity == 0)
                            <span class="badge badge-danger">Habis</span>
                        @else
                            <span class="badge badge-warning">Tidak Aktif</span>
                        @endif
                    </td>
                    <td>
                        @foreach ($product->colors->take(3) as $color)
                            <span
                                style="display: inline-block; width: 12px; height: 12px; background: {{ $color->code }}; border: 1px solid #ddd; border-radius: 2px; margin-right: 2px;"
                                title="{{ $color->name }}"></span>
                        @endforeach
                        @if ($product->colors->count() > 3)
                            <small>+{{ $product->colors->count() - 3 }}</small>
                        @endif
                    </td>
                    <td>
                        @foreach ($product->sizes->take(3) as $size)
                            <span class="badge badge-secondary" style="margin-bottom: 1px;">{{ $size->size }}</span>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($product->audiences->take(2) as $audience)
                            <small>{{ $audience->name }}</small><br>
                        @endforeach
                    </td>
                    <td>
                        @if ($product->is_new)
                            <span class="badge badge-success">Baru</span><br>
                        @endif
                        @if ($product->is_featured)
                            <span class="badge badge-warning">Unggulan</span><br>
                        @endif
                        @if ($product->is_best_seller)
                            <span class="badge badge-danger">Best Seller</span>
                        @endif
                    </td>
                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Di bagian Summary Information -->
    <div class="summary-info">
        <div class="summary-grid">
            <div class="summary-item">
                <div class="summary-label">Total Produk</div>
                <div class="summary-value">{{ number_format($filters['total_products']) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Tersedia</div>
                <div class="summary-value">{{ number_format($filters['total_available']) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Habis</div>
                <div class="summary-value">{{ number_format($filters['total_unavailable']) }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Produk Baru</div>
                <div class="summary-value">{{ number_format($filters['total_new']) }}</div>
            </div>
        </div>
        {{--
        <div style="font-size: 11px; margin-top: 10px;">
            <strong>Filter yang diterapkan:</strong><br>
            • Kategori: {{ $filters['category'] }}<br>
            • Status: {{ $filters['status'] }}<br>
            • Pencarian: {{ $filters['search'] }}<br>
            • Urutan: {{ $filters['sort'] }}<br>
            • Tanggal: {{ $filters['date_range'] }}
        </div> --}}
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy; {{ date('Y') }} ZynHope Apparel - Laporan ini dibuat secara otomatis oleh sistem
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
            $size = 8;
            $font = $fontMetrics->getFont("DejaVu Sans");
            $width = $fontMetrics->get_text_width($text, $font, $size) / 2;
            $x = ($pdf->get_width() - $width) / 2;
            $y = $pdf->get_height() - 20;
            $pdf->page_text($x, $y, $text, $font, $size);
        }
    </script>
</body>

</html>
