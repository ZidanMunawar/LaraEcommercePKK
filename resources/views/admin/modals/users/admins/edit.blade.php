@if (isset($adminUser))
    <!-- Edit Admin Modal -->
    <div class="modal fade" id="editAdminModal{{ $adminUser->id_admin }}" tabindex="-1"
        aria-labelledby="editAdminModalLabel{{ $adminUser->id_admin }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.users.admins.update', $adminUser->id_admin) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAdminModalLabel{{ $adminUser->id_admin }}">
                            Edit Admin - {{ $adminUser->username }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Username -->
                        <div class="mb-3">
                            <label for="edit_username_{{ $adminUser->id_admin }}" class="form-label">
                                Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="edit_username_{{ $adminUser->id_admin }}" name="username"
                                value="{{ old('username', $adminUser->username) }}" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="edit_password_{{ $adminUser->id_admin }}" class="form-label">
                                Password <span class="text-muted">(Leave blank to keep current)</span>
                            </label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="edit_password_{{ $adminUser->id_admin }}" name="password"
                                placeholder="Enter new password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 6 characters</small>
                        </div>

                        <!-- Full Name -->
                        <div class="mb-3">
                            <label for="edit_nama_lengkap_{{ $adminUser->id_admin }}" class="form-label">
                                Full Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                id="edit_nama_lengkap_{{ $adminUser->id_admin }}" name="nama_lengkap"
                                value="{{ old('nama_lengkap', $adminUser->nama_lengkap) }}" required>
                            @error('nama_lengkap')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="edit_email_{{ $adminUser->id_admin }}" class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                id="edit_email_{{ $adminUser->id_admin }}" name="email"
                                value="{{ old('email', $adminUser->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="edit_no_telp_{{ $adminUser->id_admin }}" class="form-label">
                                Phone Number <span class="text-muted">(Optional)</span>
                            </label>
                            <input type="text" class="form-control @error('no_telp') is-invalid @enderror"
                                id="edit_no_telp_{{ $adminUser->id_admin }}" name="no_telp"
                                value="{{ old('no_telp', $adminUser->no_telp) }}">
                            @error('no_telp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-3">
                            <label for="edit_role_{{ $adminUser->id_admin }}" class="form-label">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('role') is-invalid @enderror"
                                id="edit_role_{{ $adminUser->id_admin }}" name="role" required>
                                <option value="owner"
                                    {{ old('role', $adminUser->role) == 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="admin"
                                    {{ old('role', $adminUser->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="petugas"
                                    {{ old('role', $adminUser->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label for="edit_status_{{ $adminUser->id_admin }}" class="form-label">
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                id="edit_status_{{ $adminUser->id_admin }}" name="status" required>
                                <option value="active"
                                    {{ old('status', $adminUser->status) == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive"
                                    {{ old('status', $adminUser->status) == 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
