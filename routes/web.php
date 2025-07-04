<?php

// # ivy nambahin dari sini
use App\Http\Controllers\RegisterController; // Corrected to Auth\RegisterController based on common Laravel structure
use App\Http\Controllers\LoginController;
// # sampe sini

#nambahhin ini
use App\Http\Controllers\TreeCatalogueController;

// --- Import Controllers yang Diperlukan ---
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\TreeController;
use App\Http\Controllers\CarbonCalculatorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;

// --- Import Middleware yang Diperlukan ---
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckGuest;
use App\Http\Middleware\CheckUserRole;

// --- Import Facades ---
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- 1. Homepage & General Public Routes (Tidak memerlukan autentikasi) ---
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('/product-detail', function(){
    return view('User.product.product-detail');
})->name('product-detail');

Route::get('/trees', [TreeController::class, 'show'])->name('treecatalogue.tree');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');


// --- 2. Guest-only Routes (Hanya dapat diakses jika pengguna BELUM login) ---
Route::middleware(CheckGuest::class)->group(function(){
    Route::controller(UserController::class)->group(function (){
        Route::get("/login","loginForm")->name("login");
        Route::get("/register","registerForm")->name("register");
        Route::post("/login","login")->name("login.submit");
        Route::post("/register","register")->name("register.submit");
    });
});


// --- 3. Authenticated User Routes (Hanya dapat diakses jika pengguna SUDAH login, biasanya peran 'user') ---
Route::middleware(CheckUserRole::class)->group(function(){
    // Rute Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // Rute Profil Pengguna & Sub-halaman (Semua ditangani oleh ProfileController)
    Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
    Route::put('/user/{username}', [ProfileController::class, 'updateProfile'])->name('profile.update');

    // Rute Alamat (Hanya Show)
    Route::get('/profile/addresses', [ProfileController::class, 'showAddresses'])->name('addresses'); // <-- Hanya rute ini yang tersisa

    // Rute Pesanan & Ulasan
    Route::get('/profile/orders', [ProfileController::class, 'showOrders'])->name('orders');
    Route::get('/profile/reviews', [ProfileController::class, 'showReviews'])->name('reviews');

    // Rute Keranjang Belanja
    Route::resource('cart', CartController::class)->except(['create', 'edit']);

    // Rute Proses Pembayaran
    Route::controller(PaymentController::class)->group(function () {
        Route::get('/checkout', 'index')->name('checkout');
        Route::post('/checkout', 'checkout')->name('checkout.payment');
        Route::get('/success', 'success')->name('checkout.success');
        Route::get('/cancel', 'cancel')->name('checkout.cancel');
        Route::post('/calculate-cost', 'calculateShippingCost')->name('calculate.shipping');
    });

    // Rute Kalkulator Karbon
    Route::controller(CarbonCalculatorController::class)->group(function () {
        Route::get('/carbon-calculator', 'index')->name('carbon-calculator');
        Route::get('/carbon-calculator/question', 'question')->name('carbon-calculator.question');
        Route::get('/carbon-calculator/result', 'result')->name('carbon-calculator.result');
    });

    // Rute Ulasan Produk
    Route::resource('/review', ReviewController::class)->except(['index', 'show']);

    // Rute Detail Pesanan Spesifik
    Route::get('/order/{order_id}', [OrderController::class, 'show'])->name('order.show');
});

// --- 4. Admin Routes (Hanya dapat diakses oleh pengguna dengan peran 'admin') ---
Route::middleware(CheckAdminRole::class)->prefix('admin')->group(function(){

    // Manajemen Organisasi (Admin)
    Route::controller(OrganizationController::class)->group(function(){
        Route::get('/organizations/create', 'create')->name('admin.organizations.create');
        Route::post('/organizations', 'store')->name('admin.organizations.store');
        Route::get('/organizations', 'index')->name('admin.organizations.index');
        Route::get('/organizations/{organization_id}/edit', 'edit')->name('admin.organizations.edit');
        Route::put('/organizations/{organization_id}', 'update')->name('admin.organizations.update');
        Route::delete('/organizations/{organization_id}', 'destroy')->name('admin.organizations.destroy');
    });

    // Manajemen Pohon (Admin)
    Route::controller(TreeController::class)->group(function(){
        Route::get('/trees/create', 'create')->name('admin.trees.create');
        Route::post('/trees', 'store')->name('admin.trees.store');
        Route::get('/trees', 'index')->name('admin.trees.index');
        Route::get('/trees/{treeid}/edit', 'edit')->name('admin.trees.edit');
        Route::put('/trees/{treeid}', 'update')->name('admin.trees.update');
        Route::delete('/trees/{treeid}', 'destroy')->name('admin.trees.destroy');
    });

    // Manajemen Batch (Admin)
    Route::controller(BatchController::class)->group(function(){
        Route::get('/batches/upload', 'create')->name('admin.batches.create');
        Route::post('/batches', 'store')->name('admin.batches.store');
        Route::get('/batches', 'index')->name('admin.batches.index');
        Route::delete('/batches/{batchid}', 'destroy')->name('admin.batches.destroy');
    });

    // Manajemen Produk (Admin)
    Route::controller(ProductController::class)->group(function(){
        Route::get('/products/create', 'create')->name('admin.products.create');
        Route::post('/products', 'store')->name('admin.products.store');
        Route::get('/products/list', 'showlist')->name('admin.products.list');
        Route::get('/products/{product}/edit', 'edit')->name('admin.products.edit');
        Route::put('/products/{product}', 'update')->name('admin.products.update');
        Route::delete('/products/{product}', 'destroy')->name('admin.products.destroy');
    });

    // Manajemen Pengguna (Admin)
    Route::resource('users', UserController::class)->except(['create', 'store']);
});