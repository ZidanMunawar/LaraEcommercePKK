<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Customer\BuyNowController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Master\TagController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Admin\Master\SizeController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\Users\AdminController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Admin\Master\ColorController;
use App\Http\Controllers\Admin\Master\SlideController;
use App\Http\Controllers\Admin\Master\BannerController;
use App\Http\Controllers\Customer\CustProfileController;
use App\Http\Controllers\Customer\ProductCustController;
use App\Http\Controllers\Admin\Master\AudienceController;
use App\Http\Controllers\Admin\Master\CategoryController;
use App\Http\Controllers\Customer\CustomerChatController;
use App\Http\Controllers\Admin\Master\PromoCodeController;
use App\Http\Controllers\Admin\Master\PromotionController;
use App\Http\Controllers\Customer\Auth\RegisterController;
use App\Http\Controllers\Customer\CustomerProfileController;
use App\Http\Controllers\Customer\Auth\LoginCustController; // SUDAH BENAR

// Home redirect ke customer home
Route::get('/', function () {
    return view('customer.pages.home');
})->name('home');

// Redirect khusus ke admin login
Route::get('/login-admin', function () {
    return redirect()->route('admin.login');
});

// ===== ADMIN ROUTES =====
Route::prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login-admin', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login-admin', [LoginController::class, 'login']);
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
            Route::get('products/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');

        });

        // Transaksi - ADMIN & PETUGAS
        Route::middleware('role:admin,petugas')->group(function () {
            // Di dalam group transactions admin
            Route::prefix('transactions')->name('transactions.')->group(function () {
                Route::get('/', [TransactionController::class, 'index'])->name('index');
                Route::get('transactions/export', [TransactionController::class, 'export'])->name('export');
                Route::get('transactions/statistics', [TransactionController::class, 'statistics'])->name('statistics');

                // Route dengan {id}
                Route::get('transactions/{id}', [TransactionController::class, 'show'])->name('show')->where('id', '[0-9]+');
                Route::get('transactions/{id}/invoice', [TransactionController::class, 'generateInvoice'])->name('invoice')->where('id', '[0-9]+');
                Route::put('transactions/{id}/status', [TransactionController::class, 'updateStatus'])->name('updateStatus')->where('id', '[0-9]+');
                Route::put('transactions/{id}/payment-status', [TransactionController::class, 'updatePaymentStatus'])->name('updatePaymentStatus')->where('id', '[0-9]+');
                Route::put('transactions/{id}/resi', [TransactionController::class, 'updateResi'])->name('updateResi')->where('id', '[0-9]+');
                Route::post('transactions/{id}/verify-payment', [TransactionController::class, 'verifyPayment'])->name('verifyPayment')->where('id', '[0-9]+');
                Route::delete('transactions/{id}', [TransactionController::class, 'destroy'])->name('destroy')->where('id', '[0-9]+');
            });
        });

        // Chat & Feedback - ADMIN & PETUGAS
        Route::middleware('role:admin,petugas')->group(function () {
            // ===== CHAT ROUTES =====
            Route::prefix('chat')->name('chat.')->middleware('role:admin,petugas')->group(function () {
                Route::get('/', [ChatController::class, 'index'])->name('index');
                Route::get('/{id}', [ChatController::class, 'show'])->name('show');
                Route::post('/{id}/send', [ChatController::class, 'sendMessage'])->name('send');
                Route::put('/{id}/status', [ChatController::class, 'updateStatus'])->name('updateStatus');
                Route::post('/{id}/assign', [ChatController::class, 'assignToAdmin'])->name('assign');
                Route::get('/unread/count', [ChatController::class, 'getUnreadCount'])->name('unread.count');
                Route::get('/latest/chats', [ChatController::class, 'getLatestChats'])->name('latest.chats');
            });
            Route::prefix('feedback')->name('feedback.')->group(function () {
                Route::get('/', [FeedbackController::class, 'index'])->name('index');
                Route::get('/{id}', [FeedbackController::class, 'show'])->name('show');
                Route::put('/{id}/approve', [FeedbackController::class, 'approve'])->name('approve');
                Route::put('/{id}/reject', [FeedbackController::class, 'reject'])->name('reject');
                Route::delete('/{id}', [FeedbackController::class, 'destroy'])->name('destroy');
                Route::get('/statistics/data', [FeedbackController::class, 'statistics'])->name('statistics');
            });
        });

        // Laporan - OWNER & ADMIN
        Route::prefix('reports')->name('reports.')->middleware('role:owner,admin')->group(function () {
            // Laporan Penjualan
            Route::get('/sales', [ReportController::class, 'sales'])->name('sales');

            // Export Laporan
            Route::get('/export', [ReportController::class, 'export'])->name('export');

            // Detail Transaksi (AJAX)
            Route::get('/transaction/{id}', [ReportController::class, 'transactionDetail'])->name('transaction.detail');

            // Laporan Feedback (opsional, kalau ada)
            Route::get('/feedback', function () {
                return view('admin.pages.reports.feedback_summary');
            })->name('feedback');
        });

        // Profil & Logout - SEMUA ROLE

        Route::get('profile', [ProfileController::class, 'index'])->name('profile');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
        Route::put('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
        Route::delete('profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');


        Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    });
});

// ===== CUSTOMER ROUTES =====
Route::name('customer.')->group(function () {

    // Auth Routes (Guest Only)
    Route::middleware('guest:customer')->group(function () {
        Route::get('/login', [LoginCustController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginCustController::class, 'login']);

        Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    // Logout (Authenticated Only)
    Route::post('/logout', [LoginCustController::class, 'logout'])->name('logout')->middleware('auth:customer');

    // Public Pages
    Route::get('/', function () {
        return view('customer.pages.home');
    })->name('home');

    Route::get('/about', function () {
        return view('customer.pages.about');
    })->name('about');

    // Customer Product Routes (Public)
    Route::get('/products', [ProductCustController::class, 'index'])->name('products');
    Route::get('/product/{id}', [ProductCustController::class, 'show'])->name('product.detail');


    // Contact Page
    Route::get('/contact', function () {
        return view('customer.pages.contact');
    })->name('contact');




    // Protected Routes (Require Login)
    Route::middleware('auth:customer')->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');

        // POST /wishlist/store - Tambah produk ke wishlist (AJAX)
        Route::post('/wishlist/store', [WishlistController::class, 'store'])->name('wishlist.store');

        // POST /wishlist/toggle/{productId} - Toggle tambah/hapus (AJAX)
        Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

        // DELETE /wishlist/{id} - Hapus item dari wishlist (AJAX)
        Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.remove');

        // Cart Routes
        Route::get('/cart', [CartController::class, 'index'])->name('cart');
        Route::post('/cart', [CartController::class, 'store'])->name('cart.add');
        Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::put('/cart/variant/{id}', [CartController::class, 'updateVariant'])->name('cart.update.variant');
        Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.remove');
        Route::get('/cart/validate', [CartController::class, 'validateCart'])->name('cart.validate');
        Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.quick-add');

        // Route untuk AJAX Cart & Wishlist
        Route::post('/customer/cart/add/{productId}', [CartController::class, 'addToCart']);
        Route::post('/customer/wishlist/toggle/{productId}', [WishlistController::class, 'toggle']);
        // ========== CHECKOUT ==========
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
        Route::post('/checkout/validate-promo', [CheckoutController::class, 'validatePromoCode'])->name('checkout.validate-promo');
        Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

        // ========== BUY NOW ✅ PENTING! ==========
        Route::post('/buy-now', [BuyNowController::class, 'store'])->name('buy.now');
        Route::get('/buy-now-checkout', [BuyNowController::class, 'checkout'])->name('buy.now.checkout');
        Route::post('/buy-now-process', [BuyNowController::class, 'process'])->name('buy.now.process');



        // Upload payment page (sebelum success)
        Route::get('/payment/upload/{id}', [PaymentController::class, 'showUploadPage'])->name('payment.upload.page');
        Route::post('/payment/upload/{id}', [PaymentController::class, 'uploadProof'])->name('payment.upload');

        // Success page (cuma bisa akses kalau udah upload)
        Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

        // Profile & Orders
        Route::get('/profile', [CustProfileController::class, 'index'])->name('profile');
        Route::post('/profile/update', [CustProfileController::class, 'update'])->name('profile.update');
        Route::post('/profile/update-password', [CustProfileController::class, 'updatePassword'])->name('profile.updatePassword');

        Route::get('/orders', function () {
            return view('customer.pages.orders');
        })->name('orders');
        Route::prefix('chat')->name('chat.')->group(function () {
            Route::get('/', [CustomerChatController::class, 'index'])->name('index');
            Route::post('/start', [CustomerChatController::class, 'startChat'])->name('start');
            Route::get('/room/{id}', [CustomerChatController::class, 'showRoom'])->name('room');
            Route::post('/room/{id}/send', [CustomerChatController::class, 'sendMessage'])->name('send');
            Route::get('/unread/count', [CustomerChatController::class, 'getUnreadCount'])->name('unread.count');
        });

    });
});
