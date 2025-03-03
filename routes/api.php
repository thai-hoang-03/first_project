<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

//  API authentication
Route::post('/login', [UserController::class, 'login']); // Đăng nhập
Route::post('/register', [UserController::class, 'register']); // Đăng ký

//API user
Route::group(['prefix' => 'user'], function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/update/{id}', [UserController::class, 'update']); //update profile

        Route::get("/list", [ProductController::class, "getAll"]);
        Route::post("/add", [ProductController::class, "addItem"]);
        Route::put('/update/{id}', [ProductController::class, "updateItem"]);
    });
});
