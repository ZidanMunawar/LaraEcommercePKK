<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        $period = $request->get('period', 'month');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');

        $dateRange = $this->getDateRange($period, $startDate, $endDate);
        $summary = $this->getSalesSummary($dateRange['start'], $dateRange['end']);
        $chartData = $this->getChartData($dateRange['start'], $dateRange['end']);
        $topProducts = $this->getTopProducts($dateRange['start'], $dateRange['end']);

        $transactions = Transaksi::with(['customer', 'shippingMethod', 'approvedBy'])
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.pages.reports.sales', compact(
            'summary',
            'chartData',
            'topProducts',
            'transactions',
            'period',
            'startDate',
            'endDate'
        ));
    }

    private function getDateRange($period, $startDate = null, $endDate = null)
    {
        $now = Carbon::now();

        switch ($period) {
            case 'today':
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay(),
                ];

            case 'week':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek(),
                ];

            case 'month':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                ];

            case 'year':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear(),
                ];

            case 'custom':
                return [
                    'start' => $startDate ? Carbon::parse($startDate)->startOfDay() : $now->copy()->startOfMonth(),
                    'end' => $endDate ? Carbon::parse($endDate)->endOfDay() : $now->copy()->endOfMonth(),
                ];

            default:
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                ];
        }
    }

    private function getSalesSummary($startDate, $endDate)
    {
        $totalSales = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->sum('total_amount');

        $totalTransactions = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->count();

        $pendingTransactions = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'pending')
            ->count();

        $cancelledTransactions = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'cancelled')
            ->count();

        $totalProductsSold = DetailTransaksi::whereHas('transaksi', function ($query) use ($startDate, $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate])
                ->where('status', 'completed');
        })->sum('qty');

        $averageOrderValue = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;

        return [
            'total_sales' => $totalSales,
            'total_transactions' => $totalTransactions,
            'pending_transactions' => $pendingTransactions,
            'cancelled_transactions' => $cancelledTransactions,
            'total_products_sold' => $totalProductsSold,
            'average_order_value' => $averageOrderValue,
        ];
    }

    private function getChartData($startDate, $endDate)
    {
        $data = Transaksi::whereBetween('created_at', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $labels = [];
        $sales = [];
        $transactions = [];

        foreach ($data as $item) {
            $labels[] = Carbon::parse($item->date)->format('d M');
            $sales[] = (float) $item->total;
            $transactions[] = (int) $item->count;
        }

        return [
            'labels' => $labels,
            'sales' => $sales,
            'transactions' => $transactions,
        ];
    }

    private function getTopProducts($startDate, $endDate)
    {
        return DetailTransaksi::with('produk')
            ->whereHas('transaksi', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('status', 'completed');
            })
            ->select('id_produk', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(harga * qty) as total_sales'))
            ->groupBy('id_produk')
            ->orderBy('total_qty', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Export laporan - FIX VERSION
     */
    public function export(Request $request)
    {
        try {
            $format = $request->get('format', 'excel');
            $period = $request->get('period', 'month');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $dateRange = $this->getDateRange($period, $startDate, $endDate);
            $summary = $this->getSalesSummary($dateRange['start'], $dateRange['end']);

            $transactions = Transaksi::with(['customer', 'shippingMethod'])
                ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
                ->orderBy('created_at', 'desc')
                ->get();

            $topProducts = $this->getTopProducts($dateRange['start'], $dateRange['end']);

            if ($transactions->isEmpty()) {
                return back()->with('warning', 'Tidak ada data untuk di-export pada periode ini');
            }

            if ($format === 'pdf') {
                return $this->exportPDF($transactions, $summary, $topProducts, $dateRange);
            } else {
                return $this->exportCSV($transactions, $summary, $dateRange);
            }

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            return back()->with('error', 'Gagal export laporan: ' . $e->getMessage());
        }
    }

    /**
     * Export ke PDF - FIXED
     */
    private function exportPDF($transactions, $summary, $topProducts, $dateRange)
    {
        try {
            $pdf = Pdf::loadView('admin.exports.sales-report-pdf', [
                'transactions' => $transactions,
                'summary' => $summary,
                'topProducts' => $topProducts,
                'dateRange' => $dateRange,
                'exportDate' => now()->format('d M Y H:i')
            ]);

            $pdf->setPaper('a4', 'portrait');
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);

            $filename = 'Laporan_Penjualan_' . date('Ymd_His') . '.pdf';

            // PENTING: return download, bukan stream
            return $pdf->download($filename);

        } catch (\Exception $e) {
            \Log::error('PDF Export Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Export ke CSV - FIXED (No format angka, biar Excel baca number)
     */
    private function exportCSV($transactions, $summary, $dateRange)
    {
        $filename = 'Laporan_Penjualan_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($transactions, $summary, $dateRange) {
            $file = fopen('php://output', 'w');

            // UTF-8 BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header Summary
            fputcsv($file, ['LAPORAN PENJUALAN']);
            fputcsv($file, ['Periode', $dateRange['start']->format('d/m/Y') . ' - ' . $dateRange['end']->format('d/m/Y')]);
            fputcsv($file, []);
            fputcsv($file, ['Total Penjualan', $summary['total_sales']]);
            fputcsv($file, ['Total Transaksi', $summary['total_transactions']]);
            fputcsv($file, ['Produk Terjual', $summary['total_products_sold']]);
            fputcsv($file, ['Rata-rata Transaksi', round($summary['average_order_value'], 0)]);
            fputcsv($file, []);

            // Header Tabel (NO FORMAT, number murni biar Excel baca)
            fputcsv($file, [
                'Tanggal',
                'ID Transaksi',
                'Nama Customer',
                'Email',
                'No Telp',
                'Subtotal',
                'Ongkir',
                'Diskon',
                'Total',
                'Metode Bayar',
                'Status Bayar',
                'Status Pesanan',
                'Kurir'
            ]);

            // Data Transaksi (NUMBER MURNI, TANPA FORMAT)
            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->created_at->format('d/m/Y H:i'),
                    $trx->transaction_id,
                    $trx->customer->nama_lengkap ?? 'N/A',
                    $trx->customer->email ?? 'N/A',
                    $trx->shipping_phone ?? 'N/A',
                    $trx->subtotal, // NUMBER MURNI
                    $trx->shipping_cost, // NUMBER MURNI
                    $trx->discount_amount, // NUMBER MURNI
                    $trx->total_amount, // NUMBER MURNI
                    strtoupper($trx->metode_pembayaran),
                    $this->translatePaymentStatus($trx->payment_status),
                    $this->translateStatus($trx->status),
                    $trx->shippingMethod->name ?? 'N/A'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function transactionDetail($id)
    {
        try {
            $transaction = Transaksi::with([
                'customer',
                'shippingMethod',
                'details.produk',
                'details.size',
                'details.color',
                'approvedBy'
            ])->findOrFail($id);

            return response()->json([
                'success' => true,
                'transaction' => $transaction,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ], 404);
        }
    }

    private function translateStatus($status)
    {
        $translations = [
            'pending' => 'Menunggu',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];
        return $translations[$status] ?? $status;
    }

    private function translatePaymentStatus($status)
    {
        $translations = [
            'pending' => 'Menunggu',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan'
        ];
        return $translations[$status] ?? $status;
    }
}
