<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="logoutModalLabel">
                    <ion-icon name="log-out" class="align-middle me-2"></ion-icon>
                    Confirm Logout
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body text-center py-4">
                <ion-icon name="help-circle" style="font-size: 64px; color: #ff6b6b;"></ion-icon>
                <h5 class="mt-3 mb-2">Are you sure you want to logout?</h5>
                <p class="text-muted mb-0">You will need to login again to access the admin panel.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <ion-icon name="close" class="align-middle me-1"></ion-icon>
                    Cancel
                </button>
                <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        <ion-icon name="log-out" class="align-middle me-1"></ion-icon>
                        Yes, Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
