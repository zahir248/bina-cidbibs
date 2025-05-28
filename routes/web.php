<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ReportsController;

// client 
Route::get('/', [PageController::class, 'home'])->name('client.home');

Route::get('/store', [PageController::class, 'store'])->name('client.store');

// Modular Asia page
Route::get('/modular-asia', [PageController::class, 'modularAsia'])->name('client.modular-asia');

// Facility Management page
Route::get('/facility-management', [PageController::class, 'facilityManagement'])->name('client.facility-management');

// NextGen BINA page
Route::get('/nextgen', [PageController::class, 'nextgen'])->name('client.nextgen');

// IBS Home page
Route::get('/ibs-home', [PageController::class, 'ibsHome'])->name('client.ibs-home');

// Career Spotlight page
Route::get('/career-spotlight', [PageController::class, 'careerSpotlight'])->name('client.career-spotlight');

// Podcast page
Route::get('/podcast', [PageController::class, 'podcast'])->name('client.podcast');

// Calendar page
Route::get('/calendar', [PageController::class, 'calendar'])->name('client.calendar');

// Terms of Service page
Route::get('/terms', [PageController::class, 'terms'])->name('client.terms');

// About page
Route::get('/about', [PageController::class, 'about'])->name('client.about');

// Gallery page
Route::get('/gallery', [PageController::class, 'gallery'])->name('client.gallery');

// Ticket detail page for store page
Route::get('/store/ticket/{id}', [PageController::class, 'ticketDetail'])->name('client.ticket.detail');

// Cart routes for guests
Route::get('/cart', [CartController::class, 'index'])->name('client.cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('client.cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('client.cart.remove');

// Checkout routes for guests
Route::get('/checkout', [CheckoutController::class, 'show'])->name('client.checkout');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('client.checkout.process');

// Payment callback route
Route::get('/payment/callback', [\App\Http\Controllers\Client\CheckoutController::class, 'paymentCallback'])->name('payment.callback');

// admin
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'loginPage'])->name('login'); 
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// Routes for authenticated users only
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/logout', function () { 
        return redirect()->route('admin.dashboard'); 
    });

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        
        // Users Management Routes
        Route::resource('users', UserController::class);
        
        // Orders Management Routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/billing-details/{id}', [OrderController::class, 'getBillingDetails'])->name('billing.details');
        Route::get('/orders/{order}/items', [OrderController::class, 'getOrderItems'])->name('orders.items');

        // Tickets Management Routes
        Route::resource('tickets', TicketController::class);

        // Order routes
        Route::get('/orders/{order}/download-pdf', [OrderController::class, 'downloadPdf'])->name('orders.download-pdf');

        // Reports Routes
        Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
        Route::post('/reports/download', [ReportsController::class, 'downloadPDF'])->name('reports.download');
    });
});

