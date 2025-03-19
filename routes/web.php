<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManageProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Customer\CustomerDashboardController;
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








//Technician Route
Route::get('/technician/dashboard', [TeachnicianDashboardController::class, 'dashboard'])
    ->name('technician.dashboard')
    ->middleware(['auth', 'role:technician']);
