<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminReviewController;








Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,1')->name('login.post');
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('throttle:5,1')->name('register.post');

// Email verification routes (Laravel default signatures)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('login')->with('success', 'Email verified successfully. You can now sign in.');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function () {
    request()->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::middleware(['auth','verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index'); // 👈 عرض المنتجات
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

    // Orders
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');
    Route::post('/orders/complete', [OrderController::class, 'completeWithDetails'])
     ->name('orders.complete.details');


       // Track Order
    Route::get('/orders/{order}/track', [OrderController::class, 'track'])
        ->name('orders.track');

    // Reviews
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// reviews
Route::post('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');


});



Route::post('/logout', [LogOutController::class, 'logout'])->name('logout');

// Profile routes
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
// Change Password routes
Route::get('/password/edit', [PasswordController::class, 'edit'])->name('password.edit');
Route::put('/password/update', [PasswordController::class, 'update'])->name('password.update');


// Admin routes
Route::prefix('admin')->name('admin.')->group(function(){

    Route::get('login',[AdminAuthController::class,'showLoginForm'])->name('login');
    Route::post('login',[AdminAuthController::class,'login'])->name('login.post');
    Route::post('logout',[AdminAuthController::class,'logout'])->name('logout');
    Route::get('register',[AdminAuthController::class,'showRegisterForm'])->name('register');
    Route::post('register',[AdminAuthController::class,'register'])->name('register.post');

    Route::middleware('auth:admin')->group(function(){
        Route::get('dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
        Route::resource('products', AdminProductController::class)->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
        Route::get('orders',[AdminOrderController::class,'index'])->name('orders.index');
        Route::post('orders/{order}/update-status',[AdminOrderController::class,'updateStatus'])->name('orders.update_status');
        Route::resource('users', AdminUserController::class)->only(['index','destroy']);
        Route::resource('reviews', AdminReviewController::class)->only(['index','destroy']);
        Route::get('products/{product}/reviews', [AdminProductController::class, 'showReviews'])->name('products.reviews');
        Route::get('products/top-rated', [AdminProductController::class, 'topRated'])->name('products.top_rated');
        

    });
});
