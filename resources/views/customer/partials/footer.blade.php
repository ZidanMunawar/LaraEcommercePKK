<!-- footer area start-->
<div class="footer-area ptb-50">
    <div class="container">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-4">
                <div class="single-footer contact-us">
                    <div class="footer-title uppercase">
                        <h5>Contact US</h5>
                    </div>
                    <ul>
                        <li>
                            <div class="contact-icon"><i class="zmdi zmdi-pin-drop"></i></div>
                            <div class="contact-text">
                                <p>Address: Your address goes here</p>
                            </div>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="zmdi zmdi-email-open"></i></div>
                            <div class="contact-text">
                                <p>
                                    <a href="mailto:demo@example.com">demo@example.com</a><br>
                                    <a href="mailto:info@example.com">info@example.com</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="zmdi zmdi-phone-paused"></i></div>
                            <div class="contact-text">
                                <p>
                                    <a href="tel:01234567890">01234567890</a>
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-2 col-lg-2 col-md-4">
                <div class="single-footer informaton-area">
                    <div class="footer-title uppercase">
                        <h5>Information</h5>
                    </div>
                    <ul>
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Order History</a></li>
                        <li><a href="#">Wishlist</a></li>
                        <li><a href="#">Returns</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Site Map</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 d-md-none d-block d-lg-block">
                <div class="single-footer instagrm-area">
                    <div class="footer-title uppercase">
                        <h5>Instagram</h5>
                    </div>
                    <div class="instagrm">
                        <ul>
                            @for ($i = 1; $i <= 6; $i++)
                                <li><a href="#"><img
                                            src="{{ asset('assets-customers/images/gallery/0' . $i . '.jpg') }}"
                                            alt=""></a></li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 offset-xl-1">
                <div class="single-footer newslatter-area">
                    <div class="footer-title uppercase">
                        <h5>Get Newsletters</h5>
                    </div>
                    <form action="#" method="post">
                        <div class="input-box pos-rltv">
                            <input placeholder="Type Your Email here" type="email" name="email">
                            <button type="submit"><i class="zmdi zmdi-arrow-right"></i></button>
                        </div>
                    </form>
                    <div class="social-icon socile-icon-style-3 mt-40">
                        <div class="footer-title uppercase">
                            <h5>Social Network</h5>
                        </div>
                        <ul>
                            <li><a href="#"><i class="zmdi zmdi-facebook"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-linkedin"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-pinterest"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-google"></i></a></li>
                            <li><a href="#"><i class="zmdi zmdi-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer area end-->

<!--footer bottom area start-->
<div class="footer-bottom global-table">
    <div class="global-row">
        <div class="global-cell">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <p class="copyrigth text-center">
                            © {{ date('Y') }} <span class="text-capitalize">clothing</span>. Made with <i
                                style="color: #f53400;" class="fa fa-heart"></i> by
                            <a href="https://themeforest.net/user/codecarnival/portfolio">CodeCarnival</a>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <ul class="payment-support text-end">
                            @for ($i = 1; $i <= 5; $i++)
                                <li><a href="#"><img
                                            src="{{ asset('assets-customers/images/icons/pay' . $i . '.png') }}"
                                            alt="" /></a></li>
                            @endfor
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--footer bottom area end-->
