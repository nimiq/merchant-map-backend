<?php

use App\Http\Controllers\PickupController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/shops', 301);

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

Route::resource('shops', ShopController::class)->middleware(['auth']);
Route::resource('shops.pickups', PickupController::class)->middleware(['auth']);
Route::resource('shops.shippings', ShippingController::class)->middleware(['auth']);

require __DIR__.'/auth.php';
