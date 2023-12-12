<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/products', [ProductController::class, "list"]);
});

Route::post('/register', [UserController::class, "register"]);
