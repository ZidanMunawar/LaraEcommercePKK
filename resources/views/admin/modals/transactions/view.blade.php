<!-- Modal View Transaction Details -->
<div class="modal fade" id="viewTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details - <span id="viewOrderId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Customer Info -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0"><ion-icon name="person-outline"></ion-icon> Customer Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="40%"><strong>Name:</strong></td>
                                        <td id="viewCustomerName">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td id="viewCustomerEmail">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Phone:</strong></td>
                                        <td id="viewCustomerPhone">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Address:</strong></td>
                                        <td id="viewCustomerAddress">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="col-md-6 mb-3">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0"><ion-icon name="cart-outline"></ion-icon> Order Information</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="40%"><strong>Order Date:</strong></td>
                                        <td id="viewOrderDate">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span id="viewOrderStatus" class="badge">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Status:</strong></td>
                                        <td><span id="viewPaymentStatus" class="badge">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Payment Method:</strong></td>
                                        <td id="viewPaymentMethod">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping Method:</strong></td>
                                        <td id="viewShippingMethod">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Resi Number:</strong></td>
                                        <td id="viewResiNumber">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Notes:</strong></td>
                                        <td id="viewNotes">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="card mb-3">
                    <div class="card-header bg-info text-white">
                        <h6 class="mb-0"><ion-icon name="list-outline"></ion-icon> Order Items</h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Variant</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Discount</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="viewOrderItems">
                                    <tr>
                                        <td colspan="6" class="text-center py-4">Loading...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0"><ion-icon name="calculator-outline"></ion-icon> Order Summary</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td><strong>Subtotal:</strong></td>
                                        <td class="text-end" id="viewSubtotal">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Discount:</strong></td>
                                        <td class="text-end text-danger" id="viewDiscount">- Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Shipping Cost:</strong></td>
                                        <td class="text-end" id="viewShippingCost">Rp 0</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td><strong>Total:</strong></td>
                                        <td class="text-end" id="viewTotal"><strong class="fs-5 text-success">Rp
                                                0</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
