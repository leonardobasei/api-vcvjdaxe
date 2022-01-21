<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;

Route::get('stock', [StockController::class, 'getHistoric']);

Route::post('product', [StockController::class, 'createProduct'])
    ->middleware('verifyRequestProduct');

Route::put('movement', [StockController::class, 'updateStock'])
    ->middleware('verifyRequestMovement');
