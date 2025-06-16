<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\AuthController;

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginPage'])->name('client.login');
    Route::post('/login', [AuthController::class, 'login'])->name('client.login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('client.register');
    Route::post('/register', [AuthController::class, 'register'])->name('client.register.submit');
    
    // Social Login Routes
    Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('auth/google/complete', [AuthController::class, 'completeGoogleAuth'])->name('google.auth.complete');
    
    Route::get('auth/facebook', [AuthController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('auth/facebook/callback', [AuthController::class, 'handleFacebookCallback']);
    
    Route::get('auth/linkedin', [AuthController::class, 'redirectToLinkedin'])->name('auth.linkedin');
    Route::get('auth/linkedin/callback', [AuthController::class, 'handleLinkedinCallback']);
});

// Client Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('client.logout');
    Route::get('/user/details', [AuthController::class, 'userDetails'])->name('client.user.details');
    Route::post('/user/details', [AuthController::class, 'updateUserDetails'])->name('client.user.details.update');
    Route::delete('/user/deactivate', [AuthController::class, 'deactivateAccount'])->name('client.user.deactivate');

    // Profile Routes
    Route::get('/profile', [App\Http\Controllers\Client\ProfileController::class, 'index'])->name('client.profile');
    Route::get('/profile/search', [App\Http\Controllers\Client\ProfileController::class, 'search'])->name('client.profile.search');
    Route::post('/profile/{id}/save', [App\Http\Controllers\Client\ProfileController::class, 'saveProfile'])->name('client.profile.save');
    Route::post('/profile/{id}/remove', [App\Http\Controllers\Client\ProfileController::class, 'removeProfile'])->name('client.profile.remove');
    Route::get('/profile/saved', [App\Http\Controllers\Client\ProfileController::class, 'savedProfiles'])->name('client.profile.saved');
    Route::get('/profile/searches', [App\Http\Controllers\Client\ProfileController::class, 'savedSearches'])->name('client.profile.searches');
    Route::post('/profile/avatar', [App\Http\Controllers\Client\ProfileController::class, 'updateAvatar'])->name('client.profile.update.avatar');
    Route::delete('/profile/avatar', [App\Http\Controllers\Client\ProfileController::class, 'removeAvatar'])->name('client.profile.remove.avatar');
});

// Route to serve avatar images
Route::get('avatar/{filename}', function ($filename) {
    $path = storage_path('app/public/avatars/' . $filename);
    
    if (!file_exists($path)) {
        abort(404);
    }
    
    return response()->file($path);
})->name('avatar.show');

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

// Community routes
Route::prefix('community')->middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\Client\CommunityController::class, 'index'])->name('client.community');
    Route::get('/profile-matching', [App\Http\Controllers\Client\Community\ProfileMatchingController::class, 'index'])->name('client.community.profile-matching');
    
    // Connection routes
    Route::prefix('profile-matching')->name('client.community.profile-matching.')->group(function () {
        Route::get('/connections', [App\Http\Controllers\Client\Community\ConnectionRequestController::class, 'index'])->name('connections');
    });

    // Connection Request API Routes
    Route::prefix('connections')->name('client.community.connections.')->group(function () {
        Route::post('/send', [App\Http\Controllers\Client\Community\ConnectionRequestController::class, 'send'])->name('send');
        Route::get('/status', [App\Http\Controllers\Client\Community\ConnectionRequestController::class, 'getStatus'])->name('status');
        Route::post('/accept', [App\Http\Controllers\Client\Community\ConnectionRequestController::class, 'accept'])->name('accept');
        Route::post('/reject', [App\Http\Controllers\Client\Community\ConnectionRequestController::class, 'reject'])->name('reject');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'loginPage'])->name('admin.login'); 
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
});

// Routes for authenticated users only
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    // Redirect GET requests to logout to the login page
    Route::get('/admin/logout', [AdminAuthController::class, 'handleGetLogout'])->name('admin.logout.get');

    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        // Route::get('/dashboard', [AdminAuthController::class, 'dashboard'])->name('dashboard');
        
        // Profile Routes
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        
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

        // Event management routes
        Route::resource('events', \App\Http\Controllers\Admin\EventController::class);

        // Schedule management routes
        Route::resource('schedules', \App\Http\Controllers\Admin\ScheduleController::class);
    });
});
