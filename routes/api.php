<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\BorrowingApiController;

Route::get('/products', [ProductApiController::class, 'index']);

Route::get('/borrowings', [BorrowingApiController::class, 'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
