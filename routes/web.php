<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminManageProductController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminRegisterController;
use App\Http\Controllers\Admin\AdminServiceBookingController;
use App\Http\Controllers\Customer\CustomerDashboardController;
use App\Http\Controllers\Customer\CustomerCategoryController;
use App\Http\Controllers\Customer\CustomerCartController;
use App\Http\Controllers\Customer\CustomerProductController;
use App\Http\Controllers\Customer\CustomerCheckoutController;
use App\Http\Controllers\Customer\CustomerReviewController;
use App\Http\Controllers\Customer\CustomerOrderController;
use App\Http\Controllers\Customer\CustomerPcBuildConfigurationController;
use App\Http\Controllers\Customer\CustomerServiceBookingController;
use App\Http\Controllers\Technician\TechnicianRegisterController;
use App\Http\Controllers\Technician\TeachnicianDashboardController;
use App\Http\Controllers\Technician\TechnicianServiceBookingController;





Route::get('/', function () {
    return view('landingpage');
})->name('landingpage');

Route::view('/signup', 'auth.signup')->name('signup.form'); 
Route::post('/signup', [RegisterController::class, 'register'])->name('register'); 

Route::view('/login', 'auth.login')->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login'); 
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');







//Admin Route

Route::get('/admin/register', [AdminRegisterController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AdminRegisterController::class, 'register'])->name('admin.register.submit');
Route::get('/admin/dashboard', [AdminDashboardController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/products', [AdminManageProductController::class, 'index'])->name('admin.products.index');
Route::post('/admin/products', [AdminManageProductController::class, 'store'])->name('admin.products.store')->middleware(['auth', 'role:admin']);
Route::get('/admin/products/{product}/edit', [AdminManageProductController::class, 'edit'])->name('admin.products.edit')->middleware(['auth', 'role:admin']);
Route::put('/admin/products/{product}', [AdminManageProductController::class, 'update'])->name('admin.products.update')->middleware(['auth', 'role:admin']);
Route::delete('/admin/products/{product}', [AdminManageProductController::class, 'destroy'])->name('admin.products.destroy')->middleware(['auth', 'role:admin']);
Route::post('/admin/categories/store', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::post('/admin/orders/update-status/{order}', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.update-status');
});
Route::delete('/admin/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.destroy');
// Admin Booking Management Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Booking management
    Route::get('/bookings', [AdminServiceBookingController::class, 'index'])
        ->name('bookings.index');
    Route::get('/bookings/{id}', [AdminServiceBookingController::class, 'show'])
        ->name('bookings.show');
    Route::post('/bookings/{id}/assign-technician', [AdminServiceBookingController::class, 'assignTechnician'])
        ->name('bookings.assign');
    Route::post('/bookings/{id}/update-status', [AdminServiceBookingController::class, 'updateStatus'])
        ->name('bookings.status');
    Route::post('/bookings/{id}/cancel', [AdminServiceBookingController::class, 'handleCancellation'])
        ->name('bookings.cancel');
    Route::delete('/bookings/{id}', [AdminServiceBookingController::class, 'softDelete'])
        ->name('bookings.delete');
    Route::post('/bookings/bulk-delete', [AdminServiceBookingController::class, 'bulkSoftDelete'])
        ->name('bookings.bulk-delete');
});






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
    Route::put('/cart/update/{cartId}', [CustomerCartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/clear', [CustomerCartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CustomerCartController::class, 'getCartCount'])->name('cart.count');
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
    Route::get('/products/{id}', [CustomerProductController::class, 'show'])->name('products.show');
   

/// Store a new review
Route::post('/reviews', [CustomerReviewController::class, 'store'])->name('reviews.store');
// Get reviews for a product (for AJAX requests)
Route::get('/products/{product}/reviews', [CustomerReviewController::class, 'getProductReviews'])->name('products.reviews');
// Create a review form (if you need a separate page)
Route::get('/products/{product}/review', [CustomerReviewController::class, 'create'])->name('reviews.create');

Route::get('/orders', [CustomerOrderController::class, 'index'])->name('customer.orders');

Route::middleware(['auth'])->group(function () {
    Route::get('/checkout', [CustomerCheckoutController::class, 'checkout'])->name('customer.checkout');
    Route::post('/checkout/process', [CustomerCheckoutController::class, 'processCheckout'])->name('customer.checkout.process');
});
Route::get('/pc-builder', [CustomerPcBuildConfigurationController::class, 'index'])
->name('pc-builder.index')
->middleware('auth');
Route::post('/pc-builder', [CustomerPcBuildConfigurationController::class, 'store'])
->name('pc-builder.store')
->middleware('auth');
Route::get('/pc-builder/{id}', [CustomerPcBuildConfigurationController::class, 'show'])
->name('pc-builder.show')
->middleware('auth');
Route::delete('/pc-builder/{id}', [CustomerPcBuildConfigurationController::class, 'destroy'])
->name('pc-builder.destroy')
->middleware('auth');
Route::get('/my-builds', [CustomerPcBuildConfigurationController::class, 'list'])
    ->name('pc-builder.list')
    ->middleware('auth');
    Route::post('/pc-build/check-compatibility', [CustomerPcBuildConfigurationController::class, 'checkComponentCompatibility']);

  // Services listing page with booking modal
Route::get('/customer/services', [CustomerServiceBookingController::class, 'index'])
->name('customer.services')
->middleware('auth');

// Store service booking
Route::post('/customer/services/book', [CustomerServiceBookingController::class, 'store'])
->name('customer.services.book')
->middleware('auth');

// View customer's bookings
Route::get('/customer/bookings', [CustomerServiceBookingController::class, 'bookings'])
->name('customer.bookings')
->middleware('auth');

//Customer Cancel a booking 
Route::patch('/customer/bookings/{id}/cancel', [CustomerServiceBookingController::class, 'cancelBooking'])->name('customer.bookings.cancel');






    
//Technician Route
Route::get('/technician/dashboard', [TeachnicianDashboardController::class, 'dashboard'])
    ->name('technician.dashboard')
    ->middleware(['auth', 'role:technician']);

    Route::get('/technician/signup', [TechnicianRegisterController::class, 'showRegistrationForm'])->name('technician.signup');
Route::post('/technician/register', [TechnicianRegisterController::class, 'registerTechnician'])->name('technician.register');

Route::prefix('technician')->name('technician.')->middleware(['auth', 'role:technician'])->group(function () {
    // Bookings
    Route::get('/bookings', [TechnicianServiceBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [TechnicianServiceBookingController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/{booking}/accept', [TechnicianServiceBookingController::class, 'accept'])->name('bookings.accept');
    Route::post('/bookings/{booking}/cancel', [TechnicianServiceBookingController::class, 'cancel'])->name('bookings.cancel');
    Route::post('/bookings/{booking}/complete', [TechnicianServiceBookingController::class, 'complete'])->name('bookings.complete');
    Route::post('/bookings/{booking}/notes', [TechnicianServiceBookingController::class, 'addNotes'])->name('bookings.add-notes');
});