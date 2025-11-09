@extends('customer.layouts.app')

@section('title', 'Tentang Kami - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Tentang Kami</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Tentang Kami</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Breadcrumb area end -->

    <!-- About area start -->
    <section class="about-area pt-120 pb-120" style="background: linear-gradient(to bottom, #fff, #f5f1ed);">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="wow fadeInLeft" data-wow-delay="0.3s">
                        <div class="mb-30">
                            <span class="badge mb-3"
                                style="background: linear-gradient(135deg, #D4A574, #A0826D); font-size: 13px; padding: 8px 16px; letter-spacing: 1px;">
                                <i class="bi bi-star-fill me-2"></i>ZYNHOPE APPAREL
                            </span>
                            <h2 style="color: #5a4a3a; font-weight: 700; font-size: 2.2rem; line-height: 1.3;">Cerita Kami
                            </h2>
                        </div>
                        <p style="color: #666; font-size: 15px; line-height: 1.8; margin-bottom: 20px;">
                            ZynHope Apparel adalah brand fashion lokal yang berdedikasi untuk menghadirkan pakaian
                            berkualitas tinggi dengan desain modern dan elegan. Kami percaya bahwa setiap orang berhak
                            tampil percaya diri dengan gaya yang autentik.
                        </p>
                        <p style="color: #666; font-size: 15px; line-height: 1.8; margin-bottom: 30px;">
                            Dengan fokus pada kenyamanan, kualitas material, dan desain yang timeless, kami berkomitmen
                            untuk memberikan pengalaman berbelanja yang memuaskan bagi setiap pelanggan.
                        </p>

                        <!-- Progress Bars -->
                        <div class="bd-skill__progress mb-50">
                            <div class="bd-progress__skill-item mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 style="color: #5a4a3a; font-weight: 600; font-size: 14px;">
                                        <i class="bi bi-check-circle me-2" style="color: #A0826D;"></i>Kualitas Premium
                                    </h6>
                                    <span class="progress-count" style="color: #A0826D; font-weight: 700;">95%</span>
                                </div>
                                <div class="progress" style="height: 10px; border-radius: 10px; background: #e9ecef;">
                                    <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay="0.3s"
                                        role="progressbar"
                                        style="width: 95%; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <div class="bd-progress__skill-item mb-4">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 style="color: #5a4a3a; font-weight: 600; font-size: 14px;">
                                        <i class="bi bi-brush me-2" style="color: #A0826D;"></i>Desain Eksklusif
                                    </h6>
                                    <span class="progress-count" style="color: #A0826D; font-weight: 700;">88%</span>
                                </div>
                                <div class="progress" style="height: 10px; border-radius: 10px; background: #e9ecef;">
                                    <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay="0.4s"
                                        role="progressbar"
                                        style="width: 88%; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 10px;">
                                    </div>
                                </div>
                            </div>

                            <div class="bd-progress__skill-item">
                                <div class="d-flex justify-content-between mb-2">
                                    <h6 style="color: #5a4a3a; font-weight: 600; font-size: 14px;">
                                        <i class="bi bi-heart me-2" style="color: #A0826D;"></i>Kepuasan Pelanggan
                                    </h6>
                                    <span class="progress-count" style="color: #A0826D; font-weight: 700;">92%</span>
                                </div>
                                <div class="progress" style="height: 10px; border-radius: 10px; background: #e9ecef;">
                                    <div class="progress-bar wow slideInLeft" data-wow-duration="1s" data-wow-delay="0.5s"
                                        role="progressbar"
                                        style="width: 92%; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <img class="w-100" src="{{ asset('assets-customer/imgs/about/about-2.jpg') }}" alt="ZynHope About"
                            style="border-radius: 15px; box-shadow: 0 8px 25px rgba(139, 111, 71, 0.2);">
                    </div>
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6">
                    <div class="wow fadeInRight" data-wow-delay="0.3s">
                        <img class="w-100" src="{{ asset('assets-customer/imgs/about/about-1.jpg') }}"
                            alt="ZynHope Apparel"
                            style="border-radius: 15px; box-shadow: 0 8px 25px rgba(139, 111, 71, 0.2);">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About area end -->

    <!-- Vision & Mission area start -->
    <section class="py-5" style="background: linear-gradient(135deg, #f5f1ed, #fff);">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-body p-4" style="background: linear-gradient(to bottom, #fff, #f5f1ed);">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    style="width: 50px; height: 50px; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                                    <i class="bi bi-eye" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h4 style="color: #5a4a3a; font-weight: 700; margin: 0;">Visi Kami</h4>
                            </div>
                            <p style="color: #666; font-size: 15px; line-height: 1.8; margin: 0;">
                                Menjadi brand fashion lokal terdepan yang dikenal dengan kualitas premium, desain inovatif,
                                dan memberikan dampak positif bagi komunitas fashion Indonesia.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px; overflow: hidden;">
                        <div class="card-body p-4" style="background: linear-gradient(to bottom, #fff, #f5f1ed);">
                            <div class="d-flex align-items-center mb-3">
                                <div
                                    style="width: 50px; height: 50px; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                                    <i class="bi bi-bullseye" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h4 style="color: #5a4a3a; font-weight: 700; margin: 0;">Misi Kami</h4>
                            </div>
                            <p style="color: #666; font-size: 15px; line-height: 1.8; margin: 0;">
                                Menghadirkan produk fashion berkualitas tinggi dengan harga terjangkau, memberikan pelayanan
                                terbaik, dan terus berinovasi untuk memenuhi kebutuhan fashion modern.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Vision & Mission area end -->

    <!-- Values area start -->
    <section class="py-5" style="background: #fff;">
        <div class="container">
            <div class="text-center mb-5">
                <span class="badge mb-3"
                    style="background: linear-gradient(135deg, #D4A574, #A0826D); font-size: 13px; padding: 8px 16px;">
                    <i class="bi bi-star-fill me-2"></i>NILAI KAMI
                </span>
                <h2 style="color: #5a4a3a; font-weight: 700; font-size: 2rem;">Apa yang Kami Percaya</h2>
            </div>

            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-4"
                        style="background: linear-gradient(to bottom, #f5f1ed, #fff); border-radius: 15px; border: 2px solid #D4A574; transition: all 0.3s;">
                        <div
                            style="width: 70px; height: 70px; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                            <i class="bi bi-shield-check" style="color: white; font-size: 32px;"></i>
                        </div>
                        <h5 style="color: #5a4a3a; font-weight: 700; margin-bottom: 12px;">Kualitas Terjamin</h5>
                        <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0;">
                            Setiap produk melalui quality control ketat untuk memastikan kepuasan Anda.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-4"
                        style="background: linear-gradient(to bottom, #f5f1ed, #fff); border-radius: 15px; border: 2px solid #D4A574; transition: all 0.3s;">
                        <div
                            style="width: 70px; height: 70px; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                            <i class="bi bi-lightning-charge" style="color: white; font-size: 32px;"></i>
                        </div>
                        <h5 style="color: #5a4a3a; font-weight: 700; margin-bottom: 12px;">Inovasi Berkelanjutan</h5>
                        <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0;">
                            Kami terus berinovasi dengan desain terkini yang sesuai dengan trend fashion.
                        </p>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <div class="text-center p-4"
                        style="background: linear-gradient(to bottom, #f5f1ed, #fff); border-radius: 15px; border: 2px solid #D4A574; transition: all 0.3s;">
                        <div
                            style="width: 70px; height: 70px; background: linear-gradient(135deg, #A0826D, #8B6F47); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);">
                            <i class="bi bi-people" style="color: white; font-size: 32px;"></i>
                        </div>
                        <h5 style="color: #5a4a3a; font-weight: 700; margin-bottom: 12px;">Customer First</h5>
                        <p style="color: #666; font-size: 14px; line-height: 1.6; margin: 0;">
                            Kepuasan pelanggan adalah prioritas utama dalam setiap layanan kami.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Values area end -->

    <!-- CTA area start -->
    <section class="py-5" style="background: linear-gradient(135deg, #8B6F47, #A0826D);">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h3 style="color: white; font-weight: 700; margin-bottom: 10px;">Siap Berbelanja dengan Kami?</h3>
                    <p style="color: #f5f1ed; font-size: 15px; margin: 0;">Jelajahi koleksi terbaru kami dan temukan gaya
                        fashion yang sempurna untuk Anda!</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="{{ route('customer.products') }}" class="btn btn-lg"
                        style="background: white; color: #A0826D; border: none; border-radius: 30px; padding: 15px 40px; font-weight: 700; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s;"
                        onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 6px 20px rgba(0, 0, 0, 0.3)'"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0, 0, 0, 0.2)'">
                        <i class="bi bi-shop me-2"></i>Belanja Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>
    <!-- CTA area end -->

@endsection

@push('styles')
    <style>
        /* WOW JS Animation Support */
        .wow {
            visibility: hidden;
        }

        /* Progress bar animation */
        @keyframes slideInLeft {
            from {
                transform: translateX(-100%);
            }

            to {
                transform: translateX(0);
            }
        }

        /* Hover effects */
        .about-area img:hover {
            transform: scale(1.02);
            transition: transform 0.4s ease;
        }
    </style>
@endpush
