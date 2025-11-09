@extends('customer.layouts.app')

@section('title', 'Syarat dan Ketentuan - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Syarat dan Ketentuan</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Syarat dan Ketentuan</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area end -->

    <!-- Terms Content -->
    <section class="terms-section section-space">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terms-content">
                        <!-- Header -->
                        <div class="terms-header text-center mb-5">
                            <h1 class="terms-title">Syarat dan Ketentuan ZynHope Apparel</h1>
                            <p class="terms-updated">Terakhir diperbarui: {{ date('d F Y') }}</p>
                        </div>

                        <!-- Introduction -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">Pendahuluan</h2>
                            <p class="terms-text">
                                Selamat datang di ZynHope Apparel. Dengan mengakses dan menggunakan situs web kami serta
                                layanan yang disediakan, Anda setuju untuk terikat oleh Syarat dan Ketentuan berikut. Mohon
                                baca dengan seksama sebelum melanjutkan penggunaan layanan kami.
                            </p>
                            <p class="terms-text">
                                Jika Anda tidak setuju dengan syarat dan ketentuan ini, harap tidak menggunakan layanan
                                kami.
                            </p>
                        </div>

                        <!-- 1. Pendaftaran Akun -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">1. Pendaftaran Akun</h2>
                            <ul class="terms-list">
                                <li>Anda harus berusia minimal 17 tahun atau memiliki izin dari orang tua/wali untuk membuat
                                    akun.</li>
                                <li>Informasi yang Anda berikan harus akurat, lengkap, dan terkini.</li>
                                <li>Anda bertanggung jawab untuk menjaga kerahasiaan kata sandi dan akun Anda.</li>
                                <li>Anda bertanggung jawab atas semua aktivitas yang terjadi di akun Anda.</li>
                                <li>Kami berhak menangguhkan atau menghapus akun yang melanggar ketentuan ini.</li>
                            </ul>
                        </div>

                        <!-- 2. Penggunaan Layanan -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">2. Penggunaan Layanan</h2>
                            <p class="terms-text">Anda setuju untuk:</p>
                            <ul class="terms-list">
                                <li>Menggunakan layanan kami hanya untuk tujuan yang sah dan sesuai hukum.</li>
                                <li>Tidak menggunakan layanan untuk aktivitas ilegal, penipuan, atau merugikan pihak lain.
                                </li>
                                <li>Tidak mencoba mengakses area yang tidak diizinkan atau merusak sistem kami.</li>
                                <li>Tidak menyalahgunakan, mengganggu, atau membebani server kami.</li>
                                <li>Tidak mengunggah konten yang melanggar hak kekayaan intelektual atau mengandung virus.
                                </li>
                            </ul>
                        </div>

                        <!-- 3. Pemesanan dan Pembayaran -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">3. Pemesanan dan Pembayaran</h2>
                            <ul class="terms-list">
                                <li>Semua pesanan tunduk pada ketersediaan stok produk.</li>
                                <li>Harga produk dapat berubah sewaktu-waktu tanpa pemberitahuan sebelumnya.</li>
                                <li>Pembayaran harus dilakukan sesuai metode yang tersedia di situs kami.</li>
                                <li>Kami berhak menolak atau membatalkan pesanan jika terdapat kesalahan harga atau
                                    informasi.</li>
                                <li>Konfirmasi pesanan akan dikirimkan melalui email setelah pembayaran berhasil.</li>
                            </ul>
                        </div>

                        <!-- 4. Pengiriman -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">4. Pengiriman</h2>
                            <ul class="terms-list">
                                <li>Estimasi waktu pengiriman bersifat perkiraan dan dapat berubah tergantung lokasi dan
                                    kondisi.</li>
                                <li>Risiko kehilangan atau kerusakan produk berpindah ke pelanggan setelah produk dikirim.
                                </li>
                                <li>Kami tidak bertanggung jawab atas keterlambatan pengiriman yang disebabkan oleh pihak
                                    ketiga (kurir).</li>
                                <li>Pastikan alamat pengiriman yang Anda berikan akurat dan lengkap.</li>
                            </ul>
                        </div>

                        <!-- 5. Pengembalian dan Penukaran -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">5. Pengembalian dan Penukaran</h2>
                            <ul class="terms-list">
                                <li>Pengembalian atau penukaran produk dapat dilakukan dalam waktu 7 hari setelah produk
                                    diterima.</li>
                                <li>Produk harus dalam kondisi baru, belum dipakai, dengan label dan kemasan asli.</li>
                                <li>Produk sale/diskon tidak dapat dikembalikan atau ditukar kecuali ada cacat produksi.
                                </li>
                                <li>Biaya pengiriman pengembalian ditanggung oleh pelanggan kecuali ada kesalahan dari pihak
                                    kami.</li>
                                <li>Pengembalian dana akan diproses dalam 7-14 hari kerja setelah produk kami terima.</li>
                            </ul>
                        </div>

                        <!-- 6. Hak Kekayaan Intelektual -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">6. Hak Kekayaan Intelektual</h2>
                            <ul class="terms-list">
                                <li>Semua konten di situs ini (logo, gambar, teks, desain) adalah milik ZynHope Apparel.
                                </li>
                                <li>Anda tidak diperkenankan menggunakan, menyalin, atau mendistribusikan konten tanpa izin
                                    tertulis.</li>
                                <li>Pelanggaran hak kekayaan intelektual dapat dikenakan tindakan hukum.</li>
                            </ul>
                        </div>

                        <!-- 7. Privasi dan Data Pribadi -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">7. Privasi dan Data Pribadi</h2>
                            <ul class="terms-list">
                                <li>Kami menghormati privasi Anda dan melindungi data pribadi sesuai Kebijakan Privasi kami.
                                </li>
                                <li>Data yang Anda berikan hanya digunakan untuk keperluan transaksi dan layanan pelanggan.
                                </li>
                                <li>Kami tidak akan membagikan data Anda kepada pihak ketiga tanpa persetujuan Anda.</li>
                            </ul>
                        </div>

                        <!-- 8. Pembatasan Tanggung Jawab -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">8. Pembatasan Tanggung Jawab</h2>
                            <ul class="terms-list">
                                <li>Kami tidak bertanggung jawab atas kerugian langsung atau tidak langsung akibat
                                    penggunaan layanan.</li>
                                <li>Kami tidak menjamin bahwa situs akan bebas dari error atau gangguan teknis.</li>
                                <li>Tanggung jawab kami terbatas pada nilai produk yang Anda beli.</li>
                            </ul>
                        </div>

                        <!-- 9. Perubahan Syarat dan Ketentuan -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">9. Perubahan Syarat dan Ketentuan</h2>
                            <p class="terms-text">
                                Kami berhak mengubah Syarat dan Ketentuan ini sewaktu-waktu. Perubahan akan berlaku segera
                                setelah dipublikasikan di situs web. Dengan terus menggunakan layanan kami setelah
                                perubahan, Anda dianggap menyetujui syarat yang baru.
                            </p>
                        </div>

                        <!-- 10. Hukum yang Berlaku -->
                        <div class="terms-section-block mb-5">
                            <h2 class="terms-section-title">10. Hukum yang Berlaku</h2>
                            <p class="terms-text">
                                Syarat dan Ketentuan ini diatur oleh dan ditafsirkan sesuai dengan hukum Republik Indonesia.
                                Setiap sengketa yang timbul akan diselesaikan di pengadilan yang berwenang di Indonesia.
                            </p>
                        </div>

                        <!-- Contact -->
                        <div class="terms-section-block">
                            <h2 class="terms-section-title">Hubungi Kami</h2>
                            <p class="terms-text">
                                Jika Anda memiliki pertanyaan tentang Syarat dan Ketentuan ini, silakan hubungi kami:
                            </p>
                            <ul class="terms-contact-list">
                                <li><i class="bi bi-envelope me-2"></i> Email: <a
                                        href="mailto:zynhopeapparel@gmail.com">zynhopeapparel@gmail.com</a></li>
                                <li><i class="bi bi-telephone me-2"></i> Telepon: <a href="tel:+6283865941815">+62 838 6594
                                        1815</a></li>
                                <li><i class="bi bi-geo-alt me-2"></i> Alamat: Jl. Fashion Street No. 123, Jakarta Selatan,
                                    Indonesia</li>
                            </ul>
                        </div>

                        <!-- Footer Note -->
                        <div class="terms-footer text-center mt-5 pt-4">
                            <p class="terms-footer-text">
                                Dengan mendaftar dan menggunakan layanan ZynHope Apparel, Anda menyatakan telah membaca,
                                memahami, dan menyetujui Syarat dan Ketentuan ini.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .terms-section {
            background: linear-gradient(to bottom, #fff, #f5f1ed);
            padding: 80px 0;
        }

        .terms-content {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(139, 111, 71, 0.1);
            border: 2px solid #D4A574;
        }

        .terms-header {
            border-bottom: 3px solid #A0826D;
            padding-bottom: 25px;
        }

        .terms-title {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .terms-updated {
            color: #8B6F47;
            font-size: 14px;
            font-style: italic;
        }

        .terms-section-block {
            border-left: 4px solid #D4A574;
            padding-left: 25px;
        }

        .terms-section-title {
            color: #A0826D;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .terms-text {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
            margin-bottom: 15px;
        }

        .terms-list {
            color: #666;
            font-size: 15px;
            line-height: 1.8;
            padding-left: 20px;
        }

        .terms-list li {
            margin-bottom: 10px;
        }

        .terms-contact-list {
            list-style: none;
            padding-left: 0;
        }

        .terms-contact-list li {
            color: #666;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .terms-contact-list a {
            color: #A0826D;
            text-decoration: none;
            font-weight: 600;
        }

        .terms-contact-list a:hover {
            color: #8B6F47;
        }

        .terms-footer {
            border-top: 2px solid #D4A574;
            padding-top: 25px;
        }

        .terms-footer-text {
            color: #8B6F47;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            padding: 20px;
            background: #f5f1ed;
            border-radius: 10px;
        }

        @media (max-width: 768px) {
            .terms-content {
                padding: 30px 20px;
            }

            .terms-title {
                font-size: 24px;
            }

            .terms-section-title {
                font-size: 18px;
            }
        }
    </style>
@endpush
