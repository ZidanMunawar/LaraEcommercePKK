<!-- Modal Lihat Detail Transaksi -->
<div class="modal fade" id="viewTransactionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <!-- HEADER MODAL -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <ion-icon name="receipt-outline" class="align-middle"></ion-icon>
                    <!-- Nama/Kode Pesanan DITAMPILKAN di sini -->
                    Detail Transaksi - <span id="viewOrderId"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <!-- ISI MODAL -->
            <div class="modal-body">
                <div class="row">
                    <!-- KIRI: Info Customer -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <ion-icon name="person-outline" class="align-middle"></ion-icon>
                                    Informasi Customer
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <!-- Kolom nama, email, no telp, alamat customer -->
                                    <tr>
                                        <td width="35%"><strong>Nama:</strong></td>
                                        <td id="viewCustomerName">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Email:</strong></td>
                                        <td id="viewCustomerEmail">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. HP:</strong></td>
                                        <td id="viewCustomerPhone">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Alamat:</strong></td>
                                        <td id="viewCustomerAddress">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- KANAN: Info Pesanan -->
                    <div class="col-md-6 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <ion-icon name="cart-outline" class="align-middle"></ion-icon>
                                    Informasi Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td width="40%"><strong>Tanggal:</strong></td>
                                        <td id="viewOrderDate">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td><span id="viewOrderStatus" class="badge">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status Bayar:</strong></td>
                                        <td><span id="viewPaymentStatus" class="badge">-</span></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Metode Bayar:</strong></td>
                                        <td id="viewPaymentMethod">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Metode Kirim:</strong></td>
                                        <td id="viewShippingMethod">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>No. Resi:</strong></td>
                                        <td id="viewResiNumber">-</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Catatan:</strong></td>
                                        <td id="viewNotes">-</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- DAFTAR PRODUK/ITEM PESANAN -->
                <div class="card mb-3">
                    <div class="card-header bg-warning">
                        <h6 class="mb-0">
                            <ion-icon name="list-outline" class="align-middle"></ion-icon>
                            Item Pesanan
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <!-- Tabel Items, dynamic dari JS -->
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Produk</th>
                                        <th>Varian</th>
                                        <th>Harga</th>
                                        <th width="80" class="text-center">Qty</th>
                                        {{-- <th>Diskon</th> --}}
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="viewOrderItems">
                                    <!-- Dynamic isi dari JS, default spinner -->
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="spinner-border spinner-border-sm" role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- RINGKASAN PESANAN: SUBTOTAL, DISKON, ONGKIR, TOTAL -->
                <div class="row">
                    <div class="col-md-6 offset-md-6">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <h6 class="mb-0">
                                    <ion-icon name="calculator-outline" class="align-middle"></ion-icon>
                                    Ringkasan Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-sm table-borderless mb-0">
                                    <tr>
                                        <td><strong>Subtotal:</strong></td>
                                        <td class="text-end" id="viewSubtotal">Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Diskon:</strong></td>
                                        <td class="text-end text-danger" id="viewDiscount">- Rp 0</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Ongkir:</strong></td>
                                        <td class="text-end" id="viewShippingCost">Rp 0</td>
                                    </tr>
                                    <tr class="border-top">
                                        <td><strong class="fs-5">Total:</strong></td>
                                        <td class="text-end" id="viewTotal">
                                            <!-- Besar, hijau, cetak tebal -->
                                            <strong class="fs-5 text-success">Rp 0</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- AKHIR MODAL FOOTER -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <ion-icon name="close-outline"></ion-icon> Tutup
                </button>
            </div>
        </div>
    </div>
</div>
