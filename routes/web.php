<?php

// # ivy nambahin dari sini
use App\Http\Controllers\RegisterController; // Corrected to Auth\RegisterController based on common Laravel structure
use App\Http\Controllers\LoginController;
// # sampe sini

#nambahhin ini
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TreeCatalogueController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\CarbonCalculatorController;
use App\Models\Cart; // Unused, consider removing if not directly used in routes
use App\Models\Product; // Unused, consider removing if not directly used in routes
use App\Models\ProductCategory; // Unused, consider removing if not directly used in routes
use App\Models\Review; // Unused, consider removing if not directly used in routes
use App\Models\Organization; // Unused, consider removing if not directly used in routes
use Illuminate\Http\Request; // Unused, consider removing if not directly used in routes
use Illuminate\Support\Facades\Route;


// Option B: Redirect to signin (comment out Option A if using this)
Route::get('/', function () {
    return redirect()->route('signin');
});

// nambahin buat ke katalog pohon
Route::get('/tree', [TreeCatalogueController::class, 'index'])->name('tree_catalogue');

// Define the actual homepage if '/' is a redirect
Route::get('/homepage', function () {
    return view('homepage');
})->name('homepage');


// --- Authentication Routes ---
// Route untuk menampilkan form Sign Up
Route::get('/signup', [RegisterController::class, 'showRegistrationForm'])->name('signup');
// Route untuk data form Sign Up
Route::post('/signup', [RegisterController::class, 'register'])->name('register.submit');

// Route untuk menampilkan form Sign In
Route::get('/signin', [LoginController::class, 'showLoginForm'])->name('signin');
// Route untuk data form Sign In
Route::post('/signin', [LoginController::class, 'login'])->name('login.submit');
// Tambahkan route logout jika belum ada (penting untuk fungsionalitas Auth::logout())
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- Profile Routes (Temporarily without 'auth' middleware for development) ---
// Ketika Anda siap untuk mengaktifkan autentikasi, Anda bisa mengelompokkan ini dalam Route::middleware(['auth'])->group(function () { ... });
Route::get('/profile', [ProfileController::class, 'showProfile'])->name('profile');
// Route untuk mengupdate profil pengguna
Route::put('/user/{username}', [ProfileController::class, 'updateProfile'])->name('profile.update'); // Ini perlu diaktifkan di sini

// Tambahkan rute untuk sub-halaman profil
Route::get('/profile/addresses', [ProfileController::class, 'showAddresses'])->name('addresses');
Route::get('/profile/orders', [ProfileController::class, 'showOrders'])->name('orders');
Route::get('/profile/reviews', [ProfileController::class, 'showReviews'])->name('reviews');


// --- Other Application Routes ---
Route::get('/about', function() {
    return view('about');
});

Route::get('/product-detail', function(){
    return view('User.product.product-detail');
})->name('product-detail');

Route::resource('/user', UserController::class); // This resource handles `/user`, `/user/{id}`, etc.
                                                  // Make sure it doesn't conflict with your specific `/user/{username}` PUT route if not intended.
                                                  // If UserController is only for admin managing users, then it's fine.

Route::resource('/review', ReviewController::class);

Route::resource('cart', CartController::class);

Route::resource('/products', ProductController::class);

Route::controller(PaymentController::class)->group(function () {
    Route::get('/checkout', 'index')->name('checkout');
    Route::post('/checkout', 'checkout')->name('checkout.payment');
    Route::get('/success', 'success')->name('checkout.success');
    Route::get('/cancel', 'cancel')->name('checkout.cancel');
    Route::post('/calculate-cost', 'calculateShippingCost');
});

Route::controller(CarbonCalculatorController::class)->group(function () {
    Route::get('/carbon-calculator', 'index')->name('carbon-calculator');
    Route::get('/carbon-calculator/question', 'question')->name('carbon-calculator.question');
    Route::get('/carbon-calculator/result', 'result')->name('carbon-calculator.result');
});

// Organization
Route::controller(OrganizationController::class)->group(function(){
    Route::get('/addorg', 'create')->name('organization.create');
    Route::post('/organizations', 'store')->name('organization.store');
    Route::get('/listorg', 'index')->name('organization.listorg');
    Route::get('/organizations/{organization_id}/edit', 'edit')->name('organization.edit');
    Route::put('/organizations/{organization_id}', 'update')->name('organization.update');
    Route::delete('/organizations/{organization_id}', 'destroy')->name('organization.destroy');
});