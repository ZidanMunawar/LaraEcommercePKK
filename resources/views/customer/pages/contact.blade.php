@extends('customer.layouts.app')

@section('title', 'Hubungi Kami - ZynHope Apparel')

@section('content')
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Hubungi Kami</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><a href="{{ route('customer.home') }}">Beranda</a></li>
                                    <li><span>Hubungi Kami</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area end -->

    <!-- Contact Info area start -->
    <div class="contact-area section-space contact-brown-theme">
        <div class="container">
            <div class="row g-4 mb-5">
                <!-- Location -->
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                    <div class="contact-info-item text-center h-100">
                        <div class="contact-info-icon mb-4">
                            <div class="contact-icon-circle">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                        </div>
                        <div class="contact-info-content">
                            <h4 class="contact-info-title">Lokasi Kami</h4>
                            <p class="contact-info-text">
                                Jl. Fashion Street No. 123<br>
                                Jakarta Selatan, 12190<br>
                                Indonesia
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                    <div class="contact-info-item text-center h-100">
                        <div class="contact-info-icon mb-4">
                            <div class="contact-icon-circle">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <div class="contact-info-content">
                            <h4 class="contact-info-title">Email Kami</h4>
                            <p class="contact-info-text">
                                <a href="mailto:zynhopeapparel@gmail.com" class="contact-link">zynhopeapparel@gmail.com</a>
                                <a href="mailto:support@zynhope.com" class="contact-link">support@zynhope.com</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6">
                    <div class="contact-info-item text-center h-100">
                        <div class="contact-info-icon mb-4">
                            <div class="contact-icon-circle">
                                <i class="bi bi-telephone"></i>
                            </div>
                        </div>
                        <div class="contact-info-content">
                            <h4 class="contact-info-title">Nomor Telepon</h4>
                            <p class="contact-info-text">
                                <a href="tel:+6283865941815" class="contact-link">+62 838 6594 1815</a>
                                <a href="tel:+6281234567890" class="contact-link">+62 812 3456 7890</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form & Map -->
            <div class="contact-wrapper pt-5">
                <div class="row gy-5">
                    <!-- Map -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="contact-map">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.2087378190745!2d106.82493231476892!3d-6.229387995490033!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e945e34b9d%3A0x5371bf0fdad786a2!2sJakarta!5e0!3m2!1sen!2sid!4v1699000000000!5m2!1sen!2sid"
                                loading="lazy"></iframe>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-xxl-6 col-xl-6">
                        <div class="contact-form-wrapper">
                            <h3 class="contact-form-title">Kirim Pesan</h3>
                            <p class="contact-form-subtitle">Isi form di bawah, lalu pilih cara mengirim pesan.</p>

                            <form id="contactForm">
                                <div class="row">
                                    <div class="col-lg-6 mb-3">
                                        <label class="contact-label">Nama Lengkap *</label>
                                        <input type="text" id="senderName" class="contact-input" placeholder="Nama Anda"
                                            required>
                                    </div>

                                    <div class="col-lg-6 mb-3">
                                        <label class="contact-label">Email Anda *</label>
                                        <input type="email" id="senderEmail" class="contact-input"
                                            placeholder="email@example.com" required>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="contact-label">Nomor Telepon</label>
                                        <input type="tel" id="senderPhone" class="contact-input"
                                            placeholder="+62 812 3456 7890">
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="contact-label">Subjek *</label>
                                        <select id="subjectSelect" class="contact-input" onchange="toggleCustomSubject()">
                                            <option value="">-- Pilih Subjek --</option>
                                            <option value="Pertanyaan Produk">Pertanyaan Produk</option>
                                            <option value="Informasi Pemesanan">Informasi Pemesanan</option>
                                            <option value="Komplain">Komplain</option>
                                            <option value="Kerjasama">Kerjasama</option>
                                            <option value="custom">Lainnya (Isi Sendiri)</option>
                                        </select>
                                        <input type="text" id="customSubject" class="contact-input mt-2"
                                            placeholder="Tulis subjek Anda" style="display: none;">
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <label class="contact-label">Pesan Anda *</label>
                                        <textarea id="emailMessage" class="contact-textarea" rows="5" placeholder="Tulis pesan Anda di sini..." required></textarea>
                                    </div>

                                    <div class="col-12">
                                        <div class="row g-2">
                                            <div class="col-md-6">
                                                <button type="submit" id="emailBtn"
                                                    class="btn-contact btn-contact-email w-100">
                                                    <i class="bi bi-envelope-open me-2"></i>Kirim via Email
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" id="waBtn"
                                                    class="btn-contact btn-contact-wa w-100">
                                                    <i class="bi bi-whatsapp me-2"></i>Kirim via WhatsApp
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact area end -->

    <!-- Social Media CTA -->
    <section class="social-cta-section">
        <div class="container">
            <div class="text-center">
                <h3 class="social-cta-title">Ikuti Kami di Social Media</h3>
                <p class="social-cta-subtitle">Dapatkan update terbaru tentang produk dan promo eksklusif!</p>
                <div class="social-icons-wrapper">
                    <a href="#" class="social-icon">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="social-icon">
                        <i class="bi bi-tiktok"></i>
                    </a>
                    <a href="https://wa.me/6283865941815" target="_blank" class="social-icon social-icon-wa">
                        <i class="bi bi-whatsapp"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Contact Brown Theme */
        .contact-brown-theme {
            background: linear-gradient(to bottom, #fff, #f5f1ed);
        }

        .contact-info-item {
            background: linear-gradient(to bottom, #f5f1ed, #fff);
            border-radius: 15px;
            padding: 40px 30px;
            border: 2px solid #D4A574;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(139, 111, 71, 0.1);
        }

        .contact-info-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(139, 111, 71, 0.2);
        }

        .contact-icon-circle {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 6px 20px rgba(160, 130, 109, 0.3);
        }

        .contact-icon-circle i {
            color: white;
            font-size: 36px;
        }

        .contact-info-title {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 20px;
            margin-bottom: 15px;
        }

        .contact-info-text {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin: 0;
        }

        .contact-link {
            color: #A0826D;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            display: block;
            margin-bottom: 8px;
            transition: color 0.3s;
        }

        .contact-link:hover {
            color: #8B6F47;
        }

        /* Contact Map */
        .contact-map {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(139, 111, 71, 0.2);
            border: 3px solid #D4A574;
        }

        .contact-map iframe {
            width: 100%;
            height: 100%;
            min-height: 550px;
            border: 0;
        }

        /* Contact Form */
        .contact-form-wrapper {
            background: linear-gradient(to bottom, #f5f1ed, #fff);
            border-radius: 15px;
            padding: 40px;
            border: 2px solid #D4A574;
            box-shadow: 0 8px 25px rgba(139, 111, 71, 0.2);
        }

        .contact-form-title {
            color: #5a4a3a;
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .contact-form-subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .contact-label {
            color: #8B6F47;
            font-weight: 600;
            font-size: 13px;
            margin-bottom: 8px;
            display: block;
        }

        .contact-input,
        .contact-textarea {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #D4A574;
            border-radius: 10px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .contact-input:focus,
        .contact-textarea:focus {
            outline: none;
            border-color: #A0826D;
            box-shadow: 0 0 0 0.2rem rgba(160, 130, 109, 0.15);
        }

        .contact-textarea {
            resize: vertical;
        }

        /* Contact Buttons */
        .btn-contact {
            border: none;
            border-radius: 10px;
            padding: 14px;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-contact-email {
            background: linear-gradient(135deg, #A0826D, #8B6F47);
            color: white;
            box-shadow: 0 4px 15px rgba(160, 130, 109, 0.3);
        }

        .btn-contact-email:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(160, 130, 109, 0.5);
        }

        .btn-contact-wa {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-contact-wa:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(37, 211, 102, 0.5);
        }

        /* Social CTA */
        .social-cta-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #8B6F47, #A0826D);
        }

        .social-cta-title {
            color: white;
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 28px;
        }

        .social-cta-subtitle {
            color: #f5f1ed;
            font-size: 15px;
            margin-bottom: 30px;
        }

        .social-icons-wrapper {
            display: flex;
            justify-content: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-icon {
            width: 50px;
            height: 50px;
            background: white;
            color: #A0826D;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s;
            text-decoration: none;
        }

        .social-icon:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .social-icon-wa {
            color: #25D366;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .contact-form-wrapper {
                padding: 25px;
            }

            .contact-map iframe {
                min-height: 350px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const form = document.getElementById('contactForm');
        const emailBtn = document.getElementById('emailBtn');
        const waBtn = document.getElementById('waBtn');

        // Toggle Custom Subject
        function toggleCustomSubject() {
            const select = document.getElementById('subjectSelect');
            const customInput = document.getElementById('customSubject');

            if (select.value === 'custom') {
                customInput.style.display = 'block';
                customInput.required = true;
            } else {
                customInput.style.display = 'none';
                customInput.required = false;
                customInput.value = '';
            }
        }

        // Get Subject Value
        function getSubject() {
            const select = document.getElementById('subjectSelect');
            const customInput = document.getElementById('customSubject');

            if (select.value === 'custom') {
                return customInput.value.trim();
            }
            return select.value;
        }

        // Validasi Form
        function validateForm() {
            const name = document.getElementById('senderName').value.trim();
            const email = document.getElementById('senderEmail').value.trim();
            const subject = getSubject();
            const message = document.getElementById('emailMessage').value.trim();

            if (!name || !email || !subject || !message) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap',
                    text: 'Mohon isi semua field yang wajib (*)',
                    confirmButtonColor: '#A0826D'
                });
                return false;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Email Tidak Valid',
                    text: 'Mohon masukkan format email yang benar',
                    confirmButtonColor: '#A0826D'
                });
                return false;
            }

            return true;
        }

        // KIRIM VIA EMAIL
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateForm()) return;

            const name = document.getElementById('senderName').value;
            const email = document.getElementById('senderEmail').value;
            const phone = document.getElementById('senderPhone').value || 'Tidak ada';
            const subject = getSubject();
            const message = document.getElementById('emailMessage').value;

            const emailBody = `
Nama: ${name}
Email: ${email}
Telepon: ${phone}

Pesan:
${message}

---
Dikirim dari Contact Form ZynHope Apparel
        `.trim();

            const mailtoLink =
                `mailto:zynhopeapparel@gmail.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(emailBody)}`;
            window.location.href = mailtoLink;

            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Email Client Terbuka!',
                    text: 'Silakan klik tombol "Send" di aplikasi email Anda.',
                    confirmButtonColor: '#A0826D'
                });
            }, 500);
        });

        // KIRIM VIA WHATSAPP
        waBtn.addEventListener('click', function() {
            if (!validateForm()) return;

            const name = document.getElementById('senderName').value;
            const email = document.getElementById('senderEmail').value;
            const phone = document.getElementById('senderPhone').value || 'Tidak ada';
            const subject = getSubject();
            const message = document.getElementById('emailMessage').value;

            const waMessage = `
*📩 Pesan dari Contact Form ZynHope*

*Nama:* ${name}
*Email:* ${email}
*Telepon:* ${phone}
*Subjek:* ${subject}

*Pesan:*
${message}

---
_Dikirim dari website ZynHope Apparel_
        `.trim();

            const waNumber = '6283865941815';
            const waLink = `https://wa.me/${waNumber}?text=${encodeURIComponent(waMessage)}`;
            window.open(waLink, '_blank');

            Swal.fire({
                icon: 'success',
                title: 'WhatsApp Terbuka!',
                text: 'Silakan klik Send di WhatsApp Anda.',
                confirmButtonColor: '#A0826D',
                timer: 2000
            });
        });
    </script>
@endpush
