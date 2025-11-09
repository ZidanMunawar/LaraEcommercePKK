@if (isset($adminUser))
    <!-- Modal Hapus Admin -->
    <div class="modal fade" id="deleteAdminModal{{ $adminUser->id_admin }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <ion-icon name="warning-outline" class="align-middle"></ion-icon>
                        Konfirmasi Hapus Admin
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.users.admins.destroy', $adminUser->id_admin) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <!-- Peringatan -->
                        <div class="alert alert-warning">
                            <ion-icon name="alert-circle"></ion-icon>
                            <strong>Perhatian!</strong> Tindakan ini tidak dapat dibatalkan.
                        </div>

                        <!-- Konfirmasi -->
                        <p class="text-center mb-3">
                            Apakah Anda yakin ingin menghapus admin ini?
                        </p>

                        <!-- Preview Admin -->
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-2">
                                    <strong>Username:</strong> {{ $adminUser->username }}
                                </p>
                                <p class="mb-2">
                                    <strong>Nama Lengkap:</strong> {{ $adminUser->nama_lengkap }}
                                </p>
                                <p class="mb-2">
                                    <strong>Email:</strong> {{ $adminUser->email }}
                                </p>
                                <p class="mb-2">
                                    <strong>Role:</strong>
                                    @if ($adminUser->role == 'owner')
                                        <span class="badge bg-danger">Owner</span>
                                    @elseif($adminUser->role == 'admin')
                                        <span class="badge bg-primary">Admin</span>
                                    @else
                                        <span class="badge bg-info">Petugas</span>
                                    @endif
                                </p>
                                <p class="mb-0">
                                    <strong>Status:</strong>
                                    <span
                                        class="badge bg-{{ $adminUser->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $adminUser->status == 'active' ? 'Aktif' : 'Nonaktif' }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <!-- Info Tambahan -->
                        <div class="alert alert-danger mt-3 mb-0">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Peringatan:</strong> Akun admin akan dihapus secara permanen.
                            </small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <ion-icon name="trash-outline"></ion-icon> Ya, Hapus Admin!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
