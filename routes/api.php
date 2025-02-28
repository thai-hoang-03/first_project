<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get("/list", [ProductController::class, "getAll"]);
Route::post("/add", [ProductController::class, "addItem"]);
Route::put('/update/{id}', [ProductController::class, "updateItem"]);
