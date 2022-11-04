<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\LocationCandidateController;
use App\Http\Controllers\PickupController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/search', [ShopController::class, 'search']);
Route::post('/issue', [IssueController::class, 'store']);
Route::get('/currencies', [CurrencyController::class, 'index']);
Route::get('/location/{placeId}', [PickupController::class, 'searchByPlaceId']);

Route::get('/issue_categories', function () {
    // We only want to provide categories' id and label, the rest is just noise
    return \App\Models\IssueCategory::all()->transform(function ($category) {
        return array('id' => $category->id, 'label' => $category->label);
    });
});


Route::post('/location', [LocationCandidateController::class, 'store']);

