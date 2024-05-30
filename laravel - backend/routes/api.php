<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// user authentication routes
Route::post('/login', [AuthController::class, 'login']);


// route for creating account
Route::post('/create', [UserController::class, 'store']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    // route logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // crud products
    Route::get('/products', [ProductsController::class, 'index']);
    Route::get('/show/{id}', [ProductsController::class, 'show']);
    Route::get('/all', [ProductsController::class, 'getProductsById']);
    Route::post('/products/store', [ProductsController::class, 'store']);
    Route::put('/products/update/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/delete/{id}', [ProductsController::class, 'destroy']);
});
