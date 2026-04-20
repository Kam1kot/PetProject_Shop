<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, "index"]);

Route::prefix('/product')->group(function() {
    Route::get('/{id}', [ProductController::class, 'show']);
});

Route::prefix('/api')->group(function() {
    Route::get('/products', [ProductController::class, 'products']);
    Route::get('/products/hits', [ProductController::class, 'hitProducts']);
    // Route::get('/productsPerPage', [ProductController::class, 'productsPerPage']);
});
