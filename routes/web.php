<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MechanicController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ServiceController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// API routes for booking
Route::post('/api/bookings', [BookingController::class, 'store']);
Route::get('/api/bookings/stats', [BookingController::class, 'getStats']);
Route::post('/api/bookings/search', [BookingController::class, 'search']);

// Authentication routes
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// Admin routes (protected)
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pending-orders', [AdminController::class, 'pendingOrders'])->name('admin.pending');
    Route::get('/completed-orders', [AdminController::class, 'completedOrders'])->name('admin.completed');
    Route::get('/cancelled-orders', [AdminController::class, 'cancelledOrders'])->name('admin.cancelled');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
    
    // Booking management routes
    Route::post('/bookings/{id}/approve', [BookingController::class, 'approve'])
         ->name('admin.booking.approve');
    Route::post('/bookings/{id}/status', [BookingController::class, 'updateStatus'])->name('admin.booking.status');
    Route::get('/booking/{id}/details', [BookingController::class, 'getDetails'])->name('admin.booking.details');
    
    // Bulk operations
    Route::post('/bookings/bulk-approve', [BookingController::class, 'bulkApprove'])->name('admin.booking.bulk-approve');
    
    // Export functionality
    Route::get('/bookings/export', [BookingController::class, 'export'])->name('admin.booking.export');
    
    // Mechanics routes
    Route::resource('mechanics', MechanicController::class)->names([
        'index' => 'admin.mechanics.index',
        'create' => 'admin.mechanics.create',
        'store' => 'admin.mechanics.store',
        'edit' => 'admin.mechanics.edit',
        'update' => 'admin.mechanics.update',
        'destroy' => 'admin.mechanics.destroy'
    ]);
    
    // Separate Slider Management
    Route::prefix('sliders')->name('admin.sliders.')->group(function () {
        Route::get('/', [SliderController::class, 'index'])->name('index');
        Route::post('/', [SliderController::class, 'store'])->name('store');
        Route::put('/{id}', [SliderController::class, 'update'])->name('update');
        Route::delete('/{id}', [SliderController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [SliderController::class, 'reorder'])->name('reorder');
        Route::post('/{id}/toggle', [SliderController::class, 'toggleStatus'])->name('toggle');
    });
    
    // Separate Service Management
    Route::prefix('services')->name('admin.services.')->group(function () {
        Route::get('/', [ServiceController::class, 'index'])->name('index');
        Route::post('/', [ServiceController::class, 'store'])->name('store');
        Route::put('/{id}', [ServiceController::class, 'update'])->name('update');
        Route::delete('/{id}', [ServiceController::class, 'destroy'])->name('destroy');
        Route::post('/reorder', [ServiceController::class, 'reorder'])->name('reorder');
        Route::post('/{id}/toggle', [ServiceController::class, 'toggleStatus'])->name('toggle');
    });
    
    // Media Upload Route
    Route::post('/upload-media', [SliderController::class, 'uploadMedia'])->name('admin.upload.media');
});