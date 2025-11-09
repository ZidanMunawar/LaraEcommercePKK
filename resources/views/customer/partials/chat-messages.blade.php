{{-- resources/views/customer/partials/chat-messages.blade.php --}}
@foreach ($messages as $message)
    <div class="message-wrapper mb-4 {{ $message->sender_type === 'customer' ? 'text-end' : '' }}"
        data-message-id="{{ $message->id_messages }}">
        <div
            class="d-flex {{ $message->sender_type === 'customer' ? 'justify-content-end' : 'justify-content-start' }} align-items-end">
            @if ($message->sender_type === 'admin')
                <div class="flex-shrink-0 me-3">
                    <div
                        style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; border: 2px solid white;">
                        {{ substr($message->sender->nama_lengkap, 0, 1) }}
                    </div>
                </div>
            @endif

            <div class="flex-grow-0" style="max-width: 70%;">
                <div class="card {{ $message->sender_type === 'customer' ? '' : '' }}"
                    style="border: 2px solid {{ $message->sender_type === 'customer' ? '#A0826D' : '#D4A574' }};
                        background: {{ $message->sender_type === 'customer' ? 'linear-gradient(135deg, #A0826D, #8B6F47)' : '#FFFFFF' }};
                        border-radius: 18px;
                        {{ $message->sender_type === 'customer' ? 'border-bottom-right-radius: 4px;' : 'border-bottom-left-radius: 4px;' }}">
                    <div class="card-body p-3">
                        @if ($message->message_type === 'image')
                            <div class="text-center">
                                <img src="{{ asset('storage/' . $message->image_url) }}" alt="Chat Image"
                                    class="img-fluid rounded" style="max-height: 200px; cursor: pointer;"
                                    onclick="openImageModal('{{ asset('storage/' . $message->image_url) }}')">
                                @if ($message->isi_pesan)
                                    <p class="mt-2 mb-0"
                                        style="color: {{ $message->sender_type === 'customer' ? 'white' : '#2c2c2c' }};">
                                        {{ $message->isi_pesan }}</p>
                                @endif
                            </div>
                        @else
                            <p class="mb-0"
                                style="color: {{ $message->sender_type === 'customer' ? 'white' : '#2c2c2c' }};">
                                {{ $message->isi_pesan }}</p>
                        @endif
                    </div>
                </div>
                <small class="text-muted mt-1 d-block" style="color: #8B6F47 !important;">
                    {{ $message->created_at->format('H:i') }} •
                    {{ $message->created_at->format('M j') }}
                    @if ($message->is_read && $message->sender_type === 'customer')
                        • <i class="bi bi-check2-all text-success"></i>
                    @endif
                </small>
            </div>

            @if ($message->sender_type === 'customer')
                <div class="flex-shrink-0 ms-3">
                    <div
                        style="width: 35px; height: 35px; border-radius: 50%; background: linear-gradient(135deg, #A0826D, #8B6F47); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 14px; border: 2px solid #f9f7f4;">
                        {{ substr(Auth::guard('customer')->user()->nama_lengkap, 0, 1) }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endforeach
