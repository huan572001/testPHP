<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\http\Controllers\ProductController;
use App\http\Controllers\CartController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/v1/products', [ProductController::class, 'index']);
Route::get('/v1/products-cart', [ProductController::class, 'productWithCart']);
Route::post('/v1/import-json', [ProductController::class, 'importFromJson']);


Route::post('/v1/carts/{id}', [CartController::class, 'update']);
Route::delete('/v1/carts/{id}', [CartController::class, 'delete']);
Route::get('/v1/carts', [CartController::class, 'index']);
Route::post('/v1/add-to-cart', [CartController::class, 'create']);