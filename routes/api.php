<?php

use App\Http\Controllers\admin\ProductImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductsController;
use App\Http\Controllers\api\CategoriesController;
use App\Http\Controllers\api\OrdersController;
use App\Http\Controllers\api\BrandsController;
use App\Http\Controllers\api\ProductImagesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/products', [ProductsController::class, 'getAll']);
Route::get('/products/{id}', [ProductsController::class, 'getOne']);


Route::get('/categories', [CategoriesController::class, 'getAll']);
Route::get('/category/{id}', [CategoriesController::class, 'getOne']);

Route::get('/orders', [OrdersController::class, 'getAll']);
Route::get('/orders/{id}', [OrdersController::class, 'getOrdersId']);

Route::get('/brands', [BrandsController::class, 'getAll']);
Route::get('/brands/{id}', [BrandsController::class, 'getOne']);

Route::get('/product-images/{id}', [ProductImagesController::class, 'getProductImages']);

