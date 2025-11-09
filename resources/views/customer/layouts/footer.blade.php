<footer class="footer-bg">
    <div class="footer-area pt-100 pb-20">
        <div class="footer-style-4">
            <div class="container">
                <div class="footer-grid-3">
                    <div class="footer-widget-4">
                        <div class="footer-logo mb-35">
                            <a href="{{ route('customer.home') }}">
                                <img src="{{ asset('assets-customer/imgs/logo/zynhope-logo-light.svg') }}"
                                    alt="ZynHope Apparel">
                            </a>
                        </div>
                        <p>ZynHope Apparel - Destinasi fashion terpercaya Anda. Pakaian berkualitas untuk setiap gaya
                            dan kesempatan.</p>
                        <div class="theme-social">
                            <a class="furniture-bg-hover" href="#"><i class="bi bi-facebook"></i></a>
                            <a class="furniture-bg-hover" href="#"><i class="bi bi-twitter"></i></a>
                            <a class="furniture-bg-hover" href="#"><i class="bi bi-instagram"></i></a>
                            <a class="furniture-bg-hover" href="#"><i class="bi bi-tiktok"></i></a>
                        </div>
                    </div>
                    <div class="footer-widget-4">
                        <div class="footer-widget-title">
                            <h4>Tautan Cepat</h4>
                        </div>
                        <div class="footer-link">
                            <ul>
                                <li><a href="{{ route('customer.about') }}">Tentang Kami</a></li>
                                <li><a href="{{ route('customer.products') }}">Belanja</a></li>
                                <li><a href="{{ route('customer.contact') }}">Kontak</a></li>
                                <li><a href="#">Panduan Ukuran</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-widget-4">
                        <div class="footer-widget-title">
                            <h4>Layanan Pelanggan</h4>
                        </div>
                        <div class="footer-link">
                            <ul>
                                <li><a href="{{ route('customer.login') }}">Akun Saya</a></li>
                                <li><a href="{{ route('customer.wishlist') }}">Wishlist</a></li>
                                <li><a href="#">Pengiriman & Pengembalian</a></li>
                                <li><a href="#">Kebijakan Privasi</a></li>
                                <li><a href="#">Syarat & Ketentuan</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="footer-widget footer-col-4">
                        <div class="footer-widget-title">
                            <h4>Hubungi Kami</h4>
                        </div>
                        <div class="footer-info mb-35">
                            <div class="footer-info-item d-flex align-items-start pb-15">
                                <div class="footer-info-icon mr-20">
                                    <span><i class="bi bi-geo-alt furniture-icon"></i></span>
                                </div>
                                <div class="footer-info-text">
                                    <p>Jl. Fashion Street No. 123<br>Jakarta, Indonesia</p>
                                </div>
                            </div>
                            <div class="footer-info-item d-flex align-items-start pb-15">
                                <div class="footer-info-icon mr-20">
                                    <span><i class="bi bi-telephone furniture-icon"></i></span>
                                </div>
                                <div class="footer-info-text">
                                    <a class="furniture-clr-hover" href="tel:+628123456789">+62 812 3456 789</a>
                                    <p>Sen - Sab: 09:00 - 18:00</p>
                                </div>
                            </div>
                            <div class="footer-info-item d-flex align-items-start">
                                <div class="footer-info-icon mr-20">
                                    <span><i class="bi bi-envelope furniture-icon"></i></span>
                                </div>
                                <div class="footer-info-text">
                                    <a class="furniture-clr-hover" href="mailto:info@zynhope.com">info@zynhope.com</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="footer-copyright-area b-t">
            <div class="footer-copyright-wrapper">
                <div class="footer-copyright-text">
                    <p class="mb-0">© {{ date('Y') }} <a class="furniture-clr-hover"
                            href="{{ route('customer.home') }}">ZynHope Apparel</a>. Hak Cipta Dilindungi.</p>
                </div>
                <div class="footer-payment d-flex align-items-center gap-2">
                    <div class="footer-payment-item mb-0">
                        <img src="{{ asset('assets-customer/imgs/icons/visa.png') }}" alt="Visa">
                    </div>
                    <div class="footer-payment-item mb-0">
                        <img src="{{ asset('assets-customer/imgs/icons/mastercard.png') }}" alt="Mastercard">
                    </div>
                    <div class="footer-payment-item">
                        <img src="{{ asset('assets-customer/imgs/icons/gopay.png') }}" alt="GoPay">
                    </div>
                </div>
                <div class="footer-conditions">
                    <ul>
                        <li><a class="furniture-clr-hover" href="#">Syarat & Ketentuan</a></li>
                        <li><a class="furniture-clr-hover" href="#">Kebijakan Privasi</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
