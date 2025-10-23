@if (isset($adminUser))
    <!-- Delete Admin Modal -->
    <div class="modal fade" id="deleteAdminModal{{ $adminUser->id_admin }}" tabindex="-1"
        aria-labelledby="deleteAdminModalLabel{{ $adminUser->id_admin }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteAdminModalLabel{{ $adminUser->id_admin }}">
                        <ion-icon name="warning" class="align-middle"></ion-icon> Delete Admin
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.users.admins.destroy', $adminUser->id_admin) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="text-center mb-3">
                            <ion-icon name="alert-circle" style="font-size: 64px; color: #dc3545;"></ion-icon>
                        </div>
                        <p class="text-center">Are you sure you want to delete this admin?</p>

                        <!-- Admin Preview -->
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-1"><strong>Username:</strong> {{ $adminUser->username }}</p>
                                <p class="mb-1"><strong>Full Name:</strong> {{ $adminUser->nama_lengkap }}</p>
                                <p class="mb-1"><strong>Email:</strong> {{ $adminUser->email }}</p>
                                <p class="mb-1"><strong>Role:</strong>
                                    <span class="badge bg-primary">{{ ucfirst($adminUser->role) }}</span>
                                </p>
                                <p class="mb-0"><strong>Status:</strong>
                                    <span
                                        class="badge bg-{{ $adminUser->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($adminUser->status) }}
                                    </span>
                                </p>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0" role="alert">
                            <small>
                                <ion-icon name="warning" class="align-middle"></ion-icon>
                                <strong>Warning:</strong> This action cannot be undone.
                                The admin account will be permanently deleted.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
