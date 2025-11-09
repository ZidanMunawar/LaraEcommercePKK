@if (isset($adminUser))
    <!-- Modal Edit Admin -->
    <div class="modal fade" id="editAdminModal{{ $adminUser->id_admin }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.users.admins.update', $adminUser->id_admin) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title">
                            <ion-icon name="pencil-outline" class="align-middle"></ion-icon>
                            Edit Admin
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <!-- Info -->
                        <div class="alert alert-info">
                            <ion-icon name="information-circle"></ion-icon>
                            Anda sedang mengedit admin: <strong>{{ $adminUser->username }}</strong>
                        </div>

                        <div class="row">
                            <!-- Username -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_username_{{ $adminUser->id_admin }}" class="form-label">
                                    Username <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="edit_username_{{ $adminUser->id_admin }}"
                                    name="username" value="{{ old('username', $adminUser->username) }}" required>
                            </div>

                            <!-- Password -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_password_{{ $adminUser->id_admin }}" class="form-label">
                                    Password Baru <span class="text-muted">(Opsional)</span>
                                </label>
                                <input type="password" class="form-control"
                                    id="edit_password_{{ $adminUser->id_admin }}" name="password"
                                    placeholder="Kosongkan jika tidak ingin mengubah">
                                <small class="text-muted">Minimal 6 karakter</small>
                            </div>
                        </div>

                        <!-- Nama Lengkap -->
                        <div class="mb-3">
                            <label for="edit_nama_lengkap_{{ $adminUser->id_admin }}" class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="edit_nama_lengkap_{{ $adminUser->id_admin }}"
                                name="nama_lengkap" value="{{ old('nama_lengkap', $adminUser->nama_lengkap) }}"
                                required>
                        </div>

                        <div class="row">
                            <!-- Email -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_email_{{ $adminUser->id_admin }}" class="form-label">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control" id="edit_email_{{ $adminUser->id_admin }}"
                                    name="email" value="{{ old('email', $adminUser->email) }}" required>
                            </div>

                            <!-- No Telepon -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_no_telp_{{ $adminUser->id_admin }}" class="form-label">
                                    No. Telepon <span class="text-muted">(Opsional)</span>
                                </label>
                                <input type="text" class="form-control" id="edit_no_telp_{{ $adminUser->id_admin }}"
                                    name="no_telp" value="{{ old('no_telp', $adminUser->no_telp) }}">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Role -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_role_{{ $adminUser->id_admin }}" class="form-label">
                                    Role <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="edit_role_{{ $adminUser->id_admin }}" name="role"
                                    required>
                                    <option value="owner"
                                        {{ old('role', $adminUser->role) == 'owner' ? 'selected' : '' }}>
                                        Owner</option>
                                    <option value="admin"
                                        {{ old('role', $adminUser->role) == 'admin' ? 'selected' : '' }}>
                                        Admin</option>
                                    <option value="petugas"
                                        {{ old('role', $adminUser->role) == 'petugas' ? 'selected' : '' }}>Petugas
                                    </option>
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="edit_status_{{ $adminUser->id_admin }}" class="form-label">
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="edit_status_{{ $adminUser->id_admin }}" name="status"
                                    required>
                                    <option value="active"
                                        {{ old('status', $adminUser->status) == 'active' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $adminUser->status) == 'inactive' ? 'selected' : '' }}>
                                        Nonaktif
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Info Terakhir Diubah -->
                        <div class="text-muted small">
                            <ion-icon name="time-outline"></ion-icon>
                            Terakhir diubah: {{ $adminUser->updated_at->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <ion-icon name="close-outline"></ion-icon> Batal
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <ion-icon name="save-outline"></ion-icon> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
