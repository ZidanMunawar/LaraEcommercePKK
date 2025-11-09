<!-- Modal Edit Status Pesanan -->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <ion-icon name="create-outline" class="align-middle"></ion-icon>
                    Ubah Status Pesanan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editStatusTransactionId">

                <div class="mb-3">
                    <label for="editStatus" class="form-label fw-bold">Status Pesanan</label>
                    <select class="form-select" id="editStatus">
                        <option value="pending">🟡 Menunggu</option>
                        <option value="processing">🔵 Diproses</option>
                        <option value="shipped">🚚 Dikirim</option>
                        <option value="completed">✅ Selesai</option>
                        <option value="cancelled">❌ Dibatalkan</option>
                    </select>
                    <div class="form-text">
                        <small><strong>Alur Status Normal:</strong></small><br>
                        <small>🟡 Menunggu → 🔵 Diproses → 🚚 Dikirim → ✅ Selesai</small>
                    </div>
                </div>

                <!-- Warning untuk status cancelled -->
                <div class="alert alert-warning d-none" id="cancelWarning">
                    <ion-icon name="warning-outline"></ion-icon>
                    <strong>Peringatan!</strong> Membatalkan pesanan akan:<br>
                    • Mengembalikan stok produk ke inventory<br>
                    • Tidak dapat diubah kembali secara otomatis<br>
                    • Pelanggan akan menerima notifikasi pembatalan
                </div>

                <!-- Info untuk status processing -->
                <div class="alert alert-info d-none" id="processingInfo">
                    <ion-icon name="information-circle-outline"></ion-icon>
                    <strong>Info:</strong> Mengubah status ke "Diproses" akan:<br>
                    • Otomatis menyetujui pesanan ini<br>
                    • Mengurangi stok produk dari inventory<br>
                    • Tidak dapat dibatalkan tanpa mengembalikan stok manual
                </div>

                <!-- Info untuk status aktif dari cancelled -->
                <div class="alert alert-success d-none" id="activateInfo">
                    <ion-icon name="checkmark-circle-outline"></ion-icon>
                    <strong>Info:</strong> Mengaktifkan pesanan dari status dibatalkan akan:<br>
                    • Mengurangi stok produk dari inventory<br>
                    • Melanjutkan proses pesanan normal<br>
                    • Pastikan stok produk masih tersedia
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <ion-icon name="close-outline"></ion-icon> Batal
                </button>
                <button type="button" class="btn btn-primary" id="submitStatusUpdate" onclick="submitStatusUpdate()">
                    <ion-icon name="checkmark-outline"></ion-icon> Perbarui Status
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        // Fungsi untuk menampilkan warning/info berdasarkan status yang dipilih
        function updateStatusWarning() {
            const selectedStatus = document.getElementById('editStatus').value;
            const currentStatus = document.getElementById('editStatus').getAttribute('data-current-status');

            // Sembunyikan semua alert terlebih dahulu
            document.getElementById('cancelWarning').classList.add('d-none');
            document.getElementById('processingInfo').classList.add('d-none');
            document.getElementById('activateInfo').classList.add('d-none');

            // Tampilkan alert berdasarkan kondisi
            if (selectedStatus === 'cancelled' && currentStatus !== 'cancelled') {
                // Status berubah menjadi cancelled
                document.getElementById('cancelWarning').classList.remove('d-none');
            } else if (selectedStatus === 'processing' && currentStatus === 'cancelled') {
                // Status berubah dari cancelled ke processing
                document.getElementById('activateInfo').classList.remove('d-none');
            } else if (selectedStatus === 'processing') {
                // Status berubah ke processing
                document.getElementById('processingInfo').classList.remove('d-none');
            }
        }

        // Update modal edit status dengan current status
        window.openEditStatus = function(id, currentStatus) {
            console.log('✏️ Opening Edit Status Modal - ID:', id, '| Status:', currentStatus);
            const idInput = document.getElementById('editStatusTransactionId');
            const statusSelect = document.getElementById('editStatus');

            if (idInput) idInput.value = id;
            if (statusSelect) {
                statusSelect.value = currentStatus;
                statusSelect.setAttribute('data-current-status', currentStatus);
            }

            // Update warning berdasarkan status awal
            setTimeout(updateStatusWarning, 100);
        };

        // Event listener untuk perubahan status
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('editStatus');
            if (statusSelect) {
                statusSelect.addEventListener('change', updateStatusWarning);
            }
        });

        // Update submit status dengan konfirmasi khusus untuk cancelled
        window.submitStatusUpdate = function() {
            console.log('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            console.log('📤 Submitting Status Update');

            const id = document.getElementById('editStatusTransactionId')?.value;
            const status = document.getElementById('editStatus')?.value;
            const currentStatus = document.getElementById('editStatus')?.getAttribute('data-current-status');
            const btn = document.getElementById('submitStatusUpdate');

            if (!id || !status) {
                alert('Missing transaction ID or status');
                return;
            }

            console.log('   ID:', id, '| Current Status:', currentStatus, '| New Status:', status);

            // Konfirmasi khusus untuk status cancelled
            let confirmMessage = `Ubah status pesanan menjadi "${getStatusText(status)}"?`;

            if (status === 'cancelled' && currentStatus !== 'cancelled') {
                confirmMessage =
                    `⚠️ PERINGATAN! Anda akan membatalkan pesanan ini.\n\nTindakan ini akan:\n• Mengembalikan stok produk ke inventory\n• Tidak dapat diubah otomatis\n• Pelanggan akan diberitahu\n\nYakin ingin membatalkan pesanan?`;
            } else if (status !== 'cancelled' && currentStatus === 'cancelled') {
                confirmMessage =
                    `🔄 Mengaktifkan kembali pesanan dari status dibatalkan.\n\nTindakan ini akan:\n• Mengurangi stok produk dari inventory\n• Melanjutkan proses pesanan normal\n\nYakin ingin mengaktifkan pesanan?`;
            }

            if (!confirm(confirmMessage)) return;

            btn.disabled = true;
            btn.innerHTML = '<ion-icon name="hourglass-outline"></ion-icon> Memproses...';

            fetch(`${BASE_URL}/${id}/status`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('📥 Response:', data);
                    if (data.success) {
                        // Toast success dengan pesan khusus
                        showCustomToast('success', data.message);
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Failed to update status');
                    }
                })
                .catch(error) {
                    console.error('❌ Error:', error);
                    showCustomToast('error', 'Error: ' + error.message);
                    btn.disabled = false;
                    btn.innerHTML = '<ion-icon name="checkmark-outline"></ion-icon> Perbarui Status';
                });
        };

        // Helper function untuk teks status
        function getStatusText(status) {
            const statusMap = {
                'pending': 'Menunggu',
                'processing': 'Diproses',
                'shipped': 'Dikirim',
                'completed': 'Selesai',
                'cancelled': 'Dibatalkan'
            };
            return statusMap[status] || status;
        }

        // Helper function untuk toast notification
        function showCustomToast(type, message) {
            // Anda bisa menggunakan library toast atau alert sederhana
            if (type === 'success') {
                alert('✅ ' + message);
            } else {
                alert('❌ ' + message);
            }
        }
    </script>
@endpush
