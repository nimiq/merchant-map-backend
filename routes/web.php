<?php

use App\Http\Controllers\IssueController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\LocationCandidateController;
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

Route::resource('issues', IssueController::class)->middleware(['auth']);
Route::post('/issues/resolve/{id}', [IssueController::class, 'resolve'])
    ->name('issues.resolve')
    ->middleware(['auth']);

Route::resource('shops', ShopController::class)->middleware(['auth']);
Route::resource('shops.pickups', PickupController::class)->middleware(['auth']);
Route::resource('shops.shippings', ShippingController::class)->middleware(['auth']);

Route::post('/shop/{shopId}/status/{status}', [ShopController::class, 'changeStatus'])
    ->name('shop.status')
    ->middleware(['auth']);

Route::resource('candidates', LocationCandidateController::class)->middleware(['auth']);
Route::post('/candidates/process/{id}', [LocationCandidateController::class, 'process'])
    ->name('candidates.process')
    ->middleware(['auth']);


Route::get('/import/salamantex', function () {
    try {
        Log::debug("Start Salamantex importer");
        $importer = new SalamantexCSVImport(storage_path('active_partners.csv'));
        $importer->import();
        Log::debug("Done importing");
        return response('Import successful.');
    } catch (\Throwable $th) {
        Log::error($th->getMessage());
        return response('Error importing file: ' . $th->getMessage());
    }
})->middleware(['auth']);

Route::get('/shops/import/csv', function () {
    return view('shops.import');
})->middleware(['auth']);

Route::post('/shops/import/csv', [ShopController::class, 'importCsv'])
    ->name('shops.importCsv')
    ->middleware(['auth']);

require __DIR__ . '/auth.php';
