<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileCourierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\CourierOrderController;
use Illuminate\Support\Facades\Route;
use App\Models\orders;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/address', [ProfileController::class, 'addressupdate'])->name('profile.addressUpdate');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile-courier', [ProfileCourierController::class, 'edit'])->name('profileCourier.edit');
    Route::patch('/profile-courier', [ProfileCourierController::class, 'update'])->name('profileCourier.update');
    Route::delete('/profile-courier', [ProfileCourierController::class, 'destroy'])->name('profileCourier.destroy');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/details/{orderId}', [OrderController::class, 'details'])->name('orders.details');
    Route::get('/dashboard', [OrderController::class, 'recentOrders'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/orders/all-orders', [OrderController::class, 'allOrders'])->name('orders.allOrders');
    Route::get('/dashboard-courier', [CourierOrderController::class, 'dashboardView'])->middleware(['auth', 'verified'])->name('dashboardCourier');
    Route::get('/order-couriers/details/{orderId}', [CourierOrderController::class, 'details'])->name('orderCouriers.details');
    Route::POST('/delivery/update-status/{orderID}', [DeliveryController::class, 'updateStatus'])->name('delivery.updateStatus');
    Route::get('/order-couriers/logs', [CourierOrderController::class, 'courierLogs'])->name('orderCouriers.courierLogs');
    //Route::get('/orders/guest-tracking',[OrderController::class, 'guestTracking'])->name('orders.guest-tracking');
}); 



require __DIR__.'/auth.php';
