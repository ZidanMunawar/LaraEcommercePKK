<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Master\TagController;
use App\Http\Controllers\Admin\Master\SizeController;
use App\Http\Controllers\Admin\Users\AdminController;
use App\Http\Controllers\Admin\Master\ColorController;
use App\Http\Controllers\Admin\Master\SlideController;
use App\Http\Controllers\Admin\Master\BannerController;
use App\Http\Controllers\Admin\Master\AudienceController;
use App\Http\Controllers\Admin\Master\CategoryController;
use App\Http\Controllers\Admin\Master\PromoCodeController;
use App\Http\Controllers\Admin\Master\PromotionController;

Route::get('/', function () {
    return view('customer.pages.home');
})->name('home');

Route::get('/login-admin', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::post('/clear-last-login', [LoginController::class, 'clearLastLogin'])->name('clear.last.login');
    });

    // Protected routes
    Route::middleware('auth:admin')->group(function () {
        // Dashboard - SEMUA ROLE
        Route::get('/dashboard', function () {
            return view('admin.pages.dashboard');
        })->name('dashboard');

        // Master Data - HANYA ADMIN
        Route::prefix('master')->name('master.')->middleware('role:admin')->group(function () {
            // Audience Routes
            Route::get('/audiences', [AudienceController::class, 'index'])->name('audiences');
            Route::post('/audiences', [AudienceController::class, 'store'])->name('audiences.store');
            Route::put('/audiences/{id}', [AudienceController::class, 'update'])->name('audiences.update');
            Route::delete('/audiences/{id}', [AudienceController::class, 'destroy'])->name('audiences.destroy');

            // Categories Routes
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
            Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
            Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
            Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');

            // Color Routes
            Route::get('/colors', [ColorController::class, 'index'])->name('colors');
            Route::post('/colors', [ColorController::class, 'store'])->name('colors.store');
            Route::put('/colors/{id}', [ColorController::class, 'update'])->name('colors.update');
            Route::delete('/colors/{id}', [ColorController::class, 'destroy'])->name('colors.destroy');

            // Size Routes
            Route::get('/sizes', [SizeController::class, 'index'])->name('sizes');
            Route::post('/sizes', [SizeController::class, 'store'])->name('sizes.store');
            Route::put('/sizes/{id}', [SizeController::class, 'update'])->name('sizes.update');
            Route::delete('/sizes/{id}', [SizeController::class, 'destroy'])->name('sizes.destroy');

            // Tags Routes
            Route::get('/tags', [TagController::class, 'index'])->name('tags');
            Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
            Route::put('/tags/{id}', [TagController::class, 'update'])->name('tags.update');
            Route::delete('/tags/{id}', [TagController::class, 'destroy'])->name('tags.destroy');

            // Banners routes
            Route::get('/banners', [BannerController::class, 'index'])->name('banners');
            Route::post('/banners', [BannerController::class, 'store'])->name('banners.store');
            Route::put('/banners/{id}', [BannerController::class, 'update'])->name('banners.update');
            Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('banners.destroy');

            // Slides routes
            Route::get('/slides', [SlideController::class, 'index'])->name('slides');
            Route::post('/slides', [SlideController::class, 'store'])->name('slides.store');
            Route::put('/slides/{id}', [SlideController::class, 'update'])->name('slides.update');
            Route::delete('/slides/{id}', [SlideController::class, 'destroy'])->name('slides.destroy');

            // Promotions Route
            Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions');
            Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
            Route::put('/promotions/{id}', [PromotionController::class, 'update'])->name('promotions.update');
            Route::delete('/promotions/{id}', [PromotionController::class, 'destroy'])->name('promotions.destroy');

            // Promo Codes Routes
            Route::get('/promocodes', [PromoCodeController::class, 'index'])->name('promocodes');
            Route::post('/promocodes', [PromoCodeController::class, 'store'])->name('promocodes.store');
            Route::put('/promocodes/{id}', [PromoCodeController::class, 'update'])->name('promocodes.update');
            Route::delete('/promocodes/{id}', [PromoCodeController::class, 'destroy'])->name('promocodes.destroy');
        });

        // Manajemen Pengguna - HANYA ADMIN
        Route::prefix('users')->name('users.')->middleware('role:admin')->group(function () {
            Route::get('/admins', [AdminController::class, 'index'])->name('admins');
            Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
            Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
            Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

            Route::get('/customers', function () {
                return view('admin.pages.users.customers');
            })->name('customers');
        });

        // Produk - HANYA ADMIN
        Route::middleware('role:admin')->group(function () {
            Route::resource('products', ProductController::class);
            Route::delete('products/image/{id}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
        });

        // Transaksi - ADMIN & PETUGAS
        Route::middleware('role:admin,petugas')->group(function () {
            Route::get('/transactions', function () {
                return view('admin.pages.transactions');
            })->name('transactions');
        });

        // Chat & Feedback - ADMIN & PETUGAS
        Route::middleware('role:admin,petugas')->group(function () {
            Route::get('/chat', function () {
                return view('admin.pages.chat');
            })->name('chat');

            Route::get('/feedback', function () {
                return view('admin.pages.feedback');
            })->name('feedback');
        });

        // Laporan - OWNER & ADMIN
        Route::prefix('reports')->name('reports.')->middleware('role:owner,admin')->group(function () {
            Route::get('/sales', function () {
                return view('admin.pages.reports.sales');
            })->name('sales');

            Route::get('/feedback', function () {
                return view('admin.pages.reports.feedback_summary');
            })->name('feedback');
        });

        // Profil & Logout - SEMUA ROLE
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});
