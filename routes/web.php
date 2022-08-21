<?php

use App\Http\Controllers\PickupController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShopController;
use App\Imports\SalamantexCSVImport;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

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

Route::get('/import/salamantex', function () {
    try {
        Log::debug("Start Salamantex importer");
        $importer = new SalamantexCSVImport(storage_path('active_partners.csv'));
        $importer->import();
        Log::debug("Done importing");
        return response('Import successful.');
    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return response('Error importing Excel file: ' . $th->getMessage());
    }
})->middleware(['auth']);

require __DIR__ . '/auth.php';
