<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\PaymentLog;
use App\Services\IpaymuService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentCallbackController extends Controller
{
    protected $ipaymu;

    public function __construct(IpaymuService $ipaymu)
    {
        $this->ipaymu = $ipaymu;
    }

    public function receive(Request $request)
    {
        try {
            $signature = $request->header('signature');
            $body = $request->all();

            Log::info('iPaymu Callback Received', $body);

            // Verify signature
            if (!$this->ipaymu->verifyCallback($body, $signature)) {
                Log::error('Invalid iPaymu signature');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $referenceId = $body['reference_id'] ?? null;
            $status = $body['status'] ?? null;
            $statusCode = $body['status_code'] ?? null;

            if (!$referenceId) {
                return response()->json(['message' => 'Reference ID not found'], 400);
            }

            // Find transaction
            $transaction = Transaksi::where('transaction_id', $referenceId)->first();

            if (!$transaction) {
                Log::error('Transaction not found: ' . $referenceId);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Log payment
            PaymentLog::create([
                'id_transaksi' => $transaction->id_transaksi,
                'transaction_id' => $referenceId,
                'order_id' => $referenceId,
                'payment_type' => $body['payment_method'] ?? 'iPaymu',
                'gross_amount' => $body['amount'] ?? $transaction->total_amount,
                'transaction_status' => $status,
                'status_code' => $statusCode,
                'response_midtrans' => json_encode($body)
            ]);

            // Update transaction based on status
            // Status: 0 = pending, 1 = paid, 2 = expired, 3 = failed
            if ($statusCode == 1 || $status == 'berhasil') {
                $transaction->payment_status = 'paid';
                $transaction->paid_at = now();
                $transaction->status = 'processing';
                $transaction->payment_type = $body['payment_method'] ?? 'iPaymu';
            } else if ($statusCode == 2 || $status == 'expired') {
                $transaction->payment_status = 'failed';
                $transaction->status = 'cancelled';
            } else if ($statusCode == 3 || $status == 'failed') {
                $transaction->payment_status = 'failed';
            }

            $transaction->save();

            return response()->json(['message' => 'Payment notification processed']);

        } catch (\Exception $e) {
            Log::error('iPaymu Callback Error: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error processing notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
