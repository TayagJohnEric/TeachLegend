<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManageProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerCategoryController;
use App\Http\Controllers\Customer\CustomerCartController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\CustomerCheckoutController;
use App\Http\Controllers\Technician\TeachnicianDashboardController;




Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::view('/signup', 'auth.signup')->name('signup.form'); 
Route::post('/signup', [RegisterController::class, 'register'])->name('register'); 

Route::view('/login', 'auth.login')->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login'); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');







//Admin Route
Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/products', [AdminManageProductController::class, 'index'])->name('admin.products.index');
Route::post('/admin/products', [AdminManageProductController::class, 'store'])->name('admin.products.store')->middleware(['auth', 'role:admin']);
Route::get('/admin/products/{product}/edit', [AdminManageProductController::class, 'edit'])->name('admin.products.edit')->middleware(['auth', 'role:admin']);
Route::put('/admin/products/{product}', [AdminManageProductController::class, 'update'])->name('admin.products.update')->middleware(['auth', 'role:admin']);
Route::delete('/admin/products/{product}', [AdminManageProductController::class, 'destroy'])->name('admin.products.destroy')->middleware(['auth', 'role:admin']);
Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');







//Customer Route
Route::get('/customer/dashboard', [CustomerDashboardController::class, 'dashboard'])
    ->name('customer.dashboard')
    ->middleware(['auth', 'role:customer']);
    Route::get('/categories/{category}', [CustomerCategoryController::class, 'show'])->name('customer.categories.show');

    Route::middleware(['auth'])->group(function () {
        Route::post('/cart/add/{productId}', [CustomerCartController::class, 'addToCart'])->name('cart.add');
        Route::get('/cart', [CustomerCartController::class, 'viewCart'])->name('cart.view');
        Route::delete('/cart/remove/{id}', [CustomerCartController::class, 'removeFromCart'])->name('cart.remove');
    });
    Route::patch('/cart/update/{id}', [CustomerCartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/clear', [CustomerCartController::class, 'clear'])->name('cart.clear');
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');
    Route::get('/checkout', [CustomerCheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CustomerCheckoutController::class, 'process'])->name('checkout.process');




    

    
//Technician Route
Route::get('/technician/dashboard', [TeachnicianDashboardController::class, 'dashboard'])
    ->name('technician.dashboard')
    ->middleware(['auth', 'role:technician']);
