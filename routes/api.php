<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PostController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;

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


Route::get('/products', [ProductController::class, 'index']);
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{post}', [PostController::class, 'show']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'],  function() {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders', [OrderController::class, 'store']);
    Route::put('/orders/{id}', [OrderController::class, 'update']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);
    Route::delete('/orders/{order}', [OrderController::class, 'destroy']);
    Route::post('/add-product/{product}', [CartController::class, 'addProduct']);
    Route::put('/update-quantity/{product}', [CartController::class, 'updateQuantity']);
    Route::delete('/remove-product/{product}', [CartController::class, 'removeProduct']);
    Route::post('/create-order', [CartController::class, 'createOrder']);
    Route::get('/cart-products', [CartController::class, 'getCartProducts']);
});

Route::group(['middleware' => ['auth:sanctum', 'admin']],  function() {
    Route::group(['prefix' => 'admin'], function() {
        Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);        
        Route::apiResource('posts', PostController::class)->except(['index', 'show']);
        Route::get('/getOrders', [OrderController::class, 'getOrders']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products{id}', [ProductController::class, 'update']);
        Route::delete('/products{id}', [ProductController::class, 'delete']);
    });
});
