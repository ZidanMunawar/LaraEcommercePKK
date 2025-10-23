<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header" style="display: flex; align-items: center; padding: 20px; border-bottom: 1px solid #ddd;">
        <div style="margin-right: 15px;">
            <img src="{{ asset('assets/images/logo-icon-2.png') }}" class="logo-icon" alt="logo icon"
                style="width: 40px; height: auto;">
        </div>
        <div style="display: flex; flex-direction: column;">
            <h4 class="logo-text" style="font-size: 20px; font-weight: bold; margin: 0;">ZynHope</h4>
            <small class="logo-text" style="font-size: 6px; margin-top: 5px;">Powered by Lasthope</small>
        </div>
    </div>



    <ul class="metismenu" id="menu">
        <!-- DASHBOARD -->
        <li>
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><ion-icon name="home-sharp"></ion-icon></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <!-- MASTER DATA (Hanya Admin) -->
        @if (auth('admin')->user()->role === 'admin')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><ion-icon name="settings-sharp"></ion-icon></div>
                    <div class="menu-title">Pengaturan Toko</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.master.audiences') }}"><ion-icon
                                name="people-outline"></ion-icon>Audiences</a></li>
                    <li><a href="{{ route('admin.master.categories') }}"><ion-icon
                                name="list-outline"></ion-icon>Categories</a></li>
                    <li><a href="{{ route('admin.master.colors') }}"><ion-icon
                                name="color-palette-outline"></ion-icon>Colors</a></li>
                    <li><a href="{{ route('admin.master.sizes') }}"><ion-icon name="resize-outline"></ion-icon>Sizes</a>
                    </li>
                    <li><a href="{{ route('admin.master.tags') }}"><ion-icon name="pricetag-outline"></ion-icon>Tags</a>
                    </li>
                    <li><a href="{{ route('admin.master.banners') }}"><ion-icon
                                name="image-outline"></ion-icon>Banners</a></li>
                    <li><a href="{{ route('admin.master.slides') }}"><ion-icon
                                name="images-outline"></ion-icon>Slides</a></li>
                    <li><a href="{{ route('admin.master.promotions') }}"><ion-icon
                                name="star-outline"></ion-icon>Promotions</a></li>
                    <li><a href="{{ route('admin.master.promocodes') }}"><ion-icon name="card-outline"></ion-icon>Promo
                            Codes</a></li>
                </ul>
            </li>
        @endif

        <!-- PRODUK (Hanya Admin) -->
        @if (auth('admin')->user()->role === 'admin')
            <li>
                <a href="{{ route('admin.products.index') }}">
                    <div class="parent-icon"><ion-icon name="bag-handle-sharp"></ion-icon></div>
                    <div class="menu-title">Produk</div>
                </a>
            </li>
        @endif

        <!-- MANAJEMEN PENGGUNA (Hanya Admin) -->
        @if (auth('admin')->user()->role === 'admin')
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><ion-icon name="people-sharp"></ion-icon></div>
                    <div class="menu-title">Manajemen Pengguna</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.users.admins') }}"><ion-icon name="person-outline"></ion-icon>Admin &
                            Staff</a></li>
                    <li><a href="{{ route('admin.users.customers') }}"><ion-icon
                                name="person-circle-outline"></ion-icon>Pelanggan</a></li>
                </ul>
            </li>
        @endif

        <!-- TRANSAKSI (Admin & Petugas) -->
        @if (in_array(auth('admin')->user()->role, ['admin', 'petugas']))
            <li>
                <a href="{{ route('admin.transactions') }}">
                    <div class="parent-icon"><ion-icon name="cart-sharp"></ion-icon></div>
                    <div class="menu-title">Transaksi</div>
                </a>
            </li>
        @endif

        <!-- LAYANAN PELANGGAN (Admin & Petugas) -->
        @if (in_array(auth('admin')->user()->role, ['admin', 'petugas']))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><ion-icon name="chatbubble-ellipses-sharp"></ion-icon></div>
                    <div class="menu-title">Dukungan Pelanggan</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.chat') }}"><ion-icon name="chatbubble-outline"></ion-icon>Chat
                            Pelanggan</a></li>
                    <li><a href="{{ route('admin.feedback') }}"><ion-icon
                                name="thumbs-up-outline"></ion-icon>Feedback</a></li>
                </ul>
            </li>
        @endif

        <!-- LAPORAN (Owner & Admin) -->
        @if (in_array(auth('admin')->user()->role, ['owner', 'admin']))
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><ion-icon name="bar-chart-sharp"></ion-icon></div>
                    <div class="menu-title">Laporan</div>
                </a>
                <ul>
                    <li><a href="{{ route('admin.reports.sales') }}"><ion-icon
                                name="cash-outline"></ion-icon>Penjualan</a></li>
                    <li><a href="{{ route('admin.reports.feedback') }}"><ion-icon
                                name="file-tray-full-outline"></ion-icon>Ringkasan Feedback</a></li>
                </ul>
            </li>
        @endif

        <!-- PROFIL -->
        <li class="menu-label">Akun</li>
        <li>
            <a href="{{ route('admin.profile') }}">
                <div class="parent-icon"><ion-icon name="person-circle-sharp"></ion-icon></div>
                <div class="menu-title">Profil Saya</div>
            </a>
        </li>
        <li>
            <a href="javascript:;" data-bs-toggle="modal" data-bs-target="#logoutModal">
                <div class="parent-icon"><ion-icon name="log-out-sharp"></ion-icon></div>
                <div class="menu-title">Logout</div>
            </a>
        </li>

    </ul>
</aside>
