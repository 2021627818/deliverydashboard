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

//Route::get('/dashboard', function () {
    //return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/dashboardcourier', function () {
//    return view('dashboardcourier');
//})->middleware(['auth', 'verified'])->name('dashboardcourier');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/address', [ProfileController::class, 'addressupdate'])->name('profile.addressupdate');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profilecourier', [ProfileCourierController::class, 'edit'])->name('profilecourier.edit');
    Route::patch('/profilecourier', [ProfileCourierController::class, 'update'])->name('profilecourier.update');
    Route::delete('/profilecourier', [ProfileCourierController::class, 'destroy'])->name('profilecourier.destroy');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/details/{orderId}', [OrderController::class, 'details'])->name('orders.details');
    Route::get('/dashboard', [OrderController::class, 'recentOrders'])->middleware(['auth', 'verified'])->name('dashboard');
    Route::get('/orders/allcustomerorders', [OrderController::class, 'allCustomerOrders'])->name('orders.allcustomercorders');
    Route::get('/dashboardcourier', [CourierOrderController::class, 'ocactive'])->middleware(['auth', 'verified'])->name('dashboardcourier');
    Route::get('/ordercouriers/ocdetails/{orderId}', [CourierOrderController::class, 'ocdetails'])->name('ordercouriers.ocdetails');
    Route::POST('/delivery/updateStatus/{orderID}', [DeliveryController::class, 'updateStatus'])->name('ordercouriers.updateStatus');
});



require __DIR__.'/auth.php';
