<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\ProductController;

Route::post('/register', [PassportAuthController::class, 'register']);

Route::post('/login', [PassportAuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', [PassportAuthController::class, 'userInfo']);

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::post('/products', [ProductController::class, 'store'])->middleware('auth:api');

Route::put('/products/{id}', [ProductController::class, 'update'])->middleware('auth:api');

Route::delete('/products/{id}', [ProductController::class, 'destroy'])->middleware('auth:api');
