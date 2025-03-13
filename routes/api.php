<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

use function Pest\Laravel\post;

//  API authentication
Route::post('/login', [UserController::class, 'login']); // Đăng nhập
Route::post('/register', [UserController::class, 'register']); // Đăng ký
Route::post('/product/add', [ProductController::class, 'store']); //add product



//API user
Route::group(['prefix' => 'user'], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/update/{id}', [UserController::class, 'update']); //update profile

        // Route::post('/product/add', [ProductController::class, 'store']); //add product

    });
});
