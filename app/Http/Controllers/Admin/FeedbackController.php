<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $query = Feedback::with(['customer', 'transaksi'])
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && in_array($request->status, ['approved', 'pending'])) {
            $query->{$request->status}();
        }

        // Filter by rating
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        // Filter by search
        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_pelanggan', 'like', '%' . $request->search . '%')
                    ->orWhere('pesan', 'like', '%' . $request->search . '%')
                    ->orWhereHas('customer', function ($q) use ($request) {
                        $q->where('email', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $feedback = $query->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.pages.feedback.partials.table-rows', compact('feedback'))->render(),
                'pagination' => view('admin.pages.feedback.partials.pagination', compact('feedback'))->render()
            ]);
        }

        return view('admin.pages.feedback.index', compact('feedback'));
    }

    public function show($id)
    {
        $feedback = Feedback::with(['customer', 'transaksi'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $feedback
        ]);
    }

    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $feedback = Feedback::findOrFail($id);
            $feedback->approve();
        });

        return response()->json([
            'success' => true,
            'message' => 'Feedback approved successfully'
        ]);
    }

    public function reject($id)
    {
        DB::transaction(function () use ($id) {
            $feedback = Feedback::findOrFail($id);
            $feedback->reject();
        });

        return response()->json([
            'success' => true,
            'message' => 'Feedback rejected successfully'
        ]);
    }

    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();
        });

        return response()->json([
            'success' => true,
            'message' => 'Feedback deleted successfully'
        ]);
    }

    public function statistics()
    {
        $totalFeedback = Feedback::count();
        $approvedFeedback = Feedback::approved()->count();
        $pendingFeedback = Feedback::pending()->count();

        $ratingStats = Feedback::select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->orderBy('rating', 'desc')
            ->get();

        $averageRating = Feedback::approved()->avg('rating');

        return response()->json([
            'total' => $totalFeedback,
            'approved' => $approvedFeedback,
            'pending' => $pendingFeedback,
            'average_rating' => round($averageRating, 1),
            'rating_stats' => $ratingStats
        ]);
    }
}
