<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

#todo implement middleware in need
Route::group(['namespace'=>'Api\V1', 'prefix' => 'v1'], function () {
    Route::get("catalog/categories", [\App\Http\Controllers\Api\V1\CategoryController::class, 'index']);
    Route::get("catalog/categories/{categoryId}", [\App\Http\Controllers\Api\V1\CategoryController::class, 'show']);
    Route::get("catalog/subcategories", [\App\Http\Controllers\Api\V1\SubcategoryController::class, 'index']);
    Route::get("catalog/subcategories/{subcategories}", [\App\Http\Controllers\Api\V1\SubcategoryController::class, 'show']);
    Route::get("catalog/tags", [\App\Http\Controllers\Api\V1\TagController::class, 'index']);
    Route::get("catalog/target-markets", [\App\Http\Controllers\Api\V1\TargetMarketController::class, 'index']);
    Route::get("catalog/companies", [\App\Http\Controllers\Api\V1\CompanyController::class, 'index']);
});
