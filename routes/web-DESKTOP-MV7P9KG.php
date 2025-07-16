<?php

// # ivy nambahin dari sini
use App\Http\Controllers\RegisterController; 
use App\Http\Controllers\LoginController;
// # sampe sini

// --- Import Controllers yang Diperlukan ---
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\TreeController;
use App\Http\Controllers\Admin\TreeOrderListController;
use App\Http\Controllers\Admin\OrderListController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\CarbonCalculatorController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AddressesController;
use App\Http\Controllers\TreeOrderController;

// --- Import Middleware yang Diperlukan ---
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckGuest;
use App\Http\Middleware\CheckUserRole;

// --- Import Facades ---
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Profiler\Profile;

// --- 1. Homepage & General Public Routes (Tidak memerlukan autentikasi) ---
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/about', function() {
    return view('about');
})->name('about');

Route::get('/trees', [TreeController::class, 'show'])->name('treecatalogue.tree');
// nambahin rute untuk melihat detail pohon
Route::get('/trees/{treeName}', [TreeController::class, 'see'])->name('treecatalogue.tree-detail');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// organisasi
Route::get('/organization/{organizationName}', [OrganizationController::class, 'show'])->name('treecatalogue.organization-detail');

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
    Route::get('/profile', [UserController::class, 'edit'])->name('profile');
    Route::put('/user/{username}', [UserController::class, 'update'])->name('profile.update');

    // Rute Alamat (Hanya Show)
    Route::get('/profile/addresses', [ProfileController::class, 'showAddresses'])->name('addresses'); // <-- Hanya rute ini yang tersisa

// TAMBAHKAN RUTE ALAMAT LAINNYA DI SINI
    // Rute untuk menampilkan form tambah alamat baru (opsional)
    Route::get('/addresses/create', [AddressesController::class, 'create'])->name('addresses.create');
    // Rute untuk menyimpan alamat baru (opsional)
    Route::post('/addresses', [AddressesController::class, 'store'])->name('addresses.store');

    // Rute Alamat (Bagian yang diubah/ditambahkan)
    Route::get('/profile/addresses', [AddressesController::class, 'index'])->name('addresses'); // Menampilkan daftar alamat
    Route::post('/addresses', [AddressesController::class, 'store'])->name('addresses.store'); // Untuk menyimpan alamat baru (jika ada form create)
    Route::get('/addresses/create', [AddressesController::class, 'create'])->name('addresses.create'); // Untuk form tambah alamat baru

    // Rute untuk fungsionalitas modal edit
    // Rute untuk mengedit alamat
    Route::get('/addresses/{address}/edit', [AddressesController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{address}', [AddressesController::class, 'update'])->name('addresses.update'); // Update alamat
    Route::delete('/addresses/{address}', [AddressesController::class, 'destroy'])->name('addresses.destroy'); // Hapus alamat
    Route::patch('/addresses/{address}/set-default', [AddressesController::class, 'setDefault'])->name('addresses.setDefault'); // Set default

    // Rute Pesanan & Ulasan
    Route::get('/profile/orders', [ProfileController::class, 'showOrders'])->name('orders');
    Route::get('/profile/reviews', [ProfileController::class, 'showReviews'])->name('profile.reviews');

    // Rute Tree Order
    Route::get('/profile/tree-order', [ProfileController::class, 'showTreeOrder'])->name('profile.tree-order');

    // Rute Batalin Order
    Route::post('/order/{order:id}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    
    // Rute Terima Product Order
    Route::post('/order/{order:id}/receive', [OrderController::class, 'receiveOrder'])->name('order.receive');

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
    Route::resource('/review', ReviewController::class)->except(["create"]);
    Route::get('/review/{order:id}/create', [ReviewController::class, 'create']);

    // Rute Detail Pesanan Spesifik
    Route::get('/order/{order_id}', [OrderController::class, 'show'])->name('order.show');

    // Rute untuk menyimpan TreeOrder baru (misalnya dari tombol 'Adopt Now' di halaman detail pohon)
    Route::post('/tree-orders', [TreeOrderController::class, 'store'])->name('tree-orders.store');
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
        Route::get('/trees', 'index')->name('admin.trees.listtree');
        Route::get('/trees/{treeid}/edit', 'edit')->name('admin.trees.edit');
        Route::put('/trees/{treeid}', 'update')->name('admin.trees.update');
        Route::delete('/trees/{treeid}', 'destroy')->name('admin.trees.destroy');
    });

    // Manajemen Batch (Admin)
    Route::controller(BatchController::class)->group(function(){
        Route::get('/batches/upload', 'create')->name('admin.batches.create');
        Route::post('/batches', 'store')->name('admin.batches.store');
        Route::get('/batches', 'index')->name('admin.batches.listbatch');
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

    // Rute order list (admin)
    Route::get('/order-list', [OrderListController::class, 'index'])->name('admin.orders.index');
    Route::post('/orders/{order}/status-history', [OrderListController::class, 'storeStatusHistory'])
    ->name('admin.orders.storeStatusHistory');

    // Rute tree order list (admin)
    Route::get('/tree-order-list', [TreeOrderListController::class, 'index'])->name('admin.treeorders.index');

    // Dashboard (admin)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});