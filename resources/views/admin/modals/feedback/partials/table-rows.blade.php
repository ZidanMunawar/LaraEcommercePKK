@foreach ($feedback as $item)
    <tr>
        <td>{{ $loop->iteration + ($feedback->currentPage() - 1) * $feedback->perPage() }}</td>
        <td>
            <div>
                <strong>{{ $item->nama_pelanggan }}</strong>
                <br>
                <small class="text-muted">{{ $item->customer->email }}</small>
            </div>
        </td>
        <td>
            <span class="text-warning">
                {{ str_repeat('⭐', $item->rating) }}
            </span>
            <small class="text-muted">({{ $item->rating }}/5)</small>
        </td>
        <td>
            <div class="text-truncate" style="max-width: 200px;" title="{{ $item->pesan }}">
                {{ $item->pesan }}
            </div>
        </td>
        <td>
            @if ($item->transaksi)
                <span class="badge bg-info">{{ $item->transaksi->transaction_id }}</span>
            @else
                <span class="text-muted">N/A</span>
            @endif
        </td>
        <td>
            @if ($item->is_approved)
                <span class="badge bg-success">Approved</span>
            @else
                <span class="badge bg-warning">Pending</span>
            @endif
        </td>
        <td>{{ $item->created_at->format('M d, Y H:i') }}</td>
        <td>
            <div class="d-flex gap-1">
                <button class="btn btn-sm btn-outline-primary view-feedback" data-id="{{ $item->id_feedback }}">
                    <ion-icon name="eye"></ion-icon>
                </button>
                @if (!$item->is_approved)
                    <button class="btn btn-sm btn-outline-success approve-feedback" data-id="{{ $item->id_feedback }}">
                        <ion-icon name="checkmark"></ion-icon>
                    </button>
                @else
                    <button class="btn btn-sm btn-outline-warning reject-feedback" data-id="{{ $item->id_feedback }}">
                        <ion-icon name="close"></ion-icon>
                    </button>
                @endif
                <button class="btn btn-sm btn-outline-danger delete-feedback" data-id="{{ $item->id_feedback }}">
                    <ion-icon name="trash"></ion-icon>
                </button>
            </div>
        </td>
    </tr>
@endforeach

@if ($feedback->isEmpty())
    <tr>
        <td colspan="8" class="text-center py-4">
            <div class="text-muted">
                <ion-icon name="chatbubble-ellipses" style="font-size: 3rem;"></ion-icon>
                <p class="mt-2 mb-0">No feedback found</p>
            </div>
        </td>
    </tr>
@endif
