@extends('admin.layouts.mainLayout')
@section('title', 'Manage Customers')

@section('content')
    <!--start breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">User Management</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><ion-icon
                                name="home-sharp"></ion-icon></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Customers</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <!-- Customers Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Customers</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><ion-icon
                            name="search-sharp"></ion-icon></div>
                    <input class="form-control ps-5" type="text" placeholder="Search Customers">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example Row for Customers -->
                        <tr>
                            <td>1</td>
                            <td>customer123</td>
                            <td>Customer Name</td>
                            <td>customer@example.com</td>
                            <td>081234567890</td>
                            <td>
                                <div class="table-actions d-flex align-items-center gap-2 fs-3">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#viewCustomerModal1"><ion-icon
                                            name="eye-outline"></ion-icon>View</button>
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#resetPasswordModal1"><ion-icon
                                            name="lock-closed-outline"></ion-icon>Reset Password</button>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                        data-bs-target="#sendNotificationModal1"><ion-icon
                                            name="send-outline"></ion-icon>Send Notification</button>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#viewChatModal1"><ion-icon
                                            name="chatbubble-ellipses-outline"></ion-icon>View Chat</button>
                                </div>
                            </td>
                        </tr>
                        <!-- Repeat for other rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal View Customer Details -->
    <div class="modal fade" id="viewCustomerModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Details - customer123</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Full Name:</strong> Customer Name</p>
                    <p><strong>Email:</strong> customer@example.com</p>
                    <p><strong>Phone:</strong> 081234567890</p>
                    <p><strong>Address:</strong> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus sit amet
                        ex vel purus faucibus placerat.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reset Password -->
    <div class="modal fade" id="resetPasswordModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reset Password for customer123</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newPassword" placeholder="Enter new password">
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmPassword"
                                placeholder="Confirm new password">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Reset Password</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Send Notification -->
    <div class="modal fade" id="sendNotificationModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Notification to customer123</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="notificationMessage" class="form-label">Notification Message</label>
                            <textarea class="form-control" id="notificationMessage" rows="3" placeholder="Enter your message"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send Notification</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal View Chat -->
    <div class="modal fade" id="viewChatModal1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">View Chat with customer123</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Customer:</strong> Hi, I need help with my order.</p>
                    <p><strong>You:</strong> Sure, how can I assist you?</p>
                    <!-- Repeat chat messages here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
