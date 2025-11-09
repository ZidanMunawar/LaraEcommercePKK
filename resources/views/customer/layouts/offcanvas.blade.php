<div class="fix">
    <div class="offcanvas__info">
        <div class="offcanvas__wrapper">
            <div class="offcanvas__content">
                <div class="offcanvas__top mb-40 d-flex justify-content-between align-items-center">
                    <div class="offcanvas__logo">
                        <a href="{{ route('customer.home') }}">
                            <img src="{{ asset('assets/images/logo-iconw.png') }}" class="logo-icon" alt="ZynHope Apparel"
                                style="width: 100px; height: auto;">
                        </a>
                    </div>
                    <div class="offcanvas__close">
                        <button><i class="bi bi-x-lg"></i></button>
                    </div>
                </div>
                <div class="offcanvas__search mb-25">
                    <form action="{{ route('customer.products') }}" method="GET">
                        <input type="text" name="search" placeholder="Cari produk...">
                        <button type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
                <div class="mobile-menu fix mb-40"></div>
                <div class="offcanvas__contact mt-30 mb-20">
                    <h4>Info Kontak</h4>
                    <ul>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <p>Jl. Fashion Street No. 123, Jakarta, Indonesia</p>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="bi bi-telephone"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="tel:+628123456789">+62 812 3456 789</a>
                            </div>
                        </li>
                        <li class="d-flex align-items-center">
                            <div class="offcanvas__contact-icon mr-15">
                                <i class="bi bi-envelope"></i>
                            </div>
                            <div class="offcanvas__contact-text">
                                <a href="mailto:info@zynhope.com">info@zynhope.com</a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="offcanvas__social">
                    <ul>
                        <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                        <li><a href="#"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="#"><i class="bi bi-tiktok"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas__overlay"></div>
<div class="offcanvas__overlay-white"></div>
