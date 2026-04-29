<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, "index"]);

Route::prefix('/product')->group(function() {
    Route::get('/{id}', [ProductController::class, 'show']);
});

Route::middleware('auth')->prefix('/profile')->group(function() {
    Route::get('/', [UserController::class, 'index'])->name('profile.index');
    Route::get('/orders', [UserController::class, 'orders'])->name('profile.orders');
    Route::get('/reviews', [UserController::class, 'reviews'])->name('profile.reviews');
    Route::get('/addresses', [UserController::class, 'addresses'])->name('profile.addresses');
    Route::patch('/data/update', [UserController::class, 'updateData'])->name('profile.updateData');
    Route::patch('/avatar/update', [UserController::class, 'updateAvatar'])->name('profile.updateAvatar');
    Route::delete('/avatar/delete', [UserController::class, 'deleteAvatar'])->name('profile.deleteAvatar');
    Route::patch('/password/reset', [UserController::class, 'passwordReset']);
});

Route::prefix('/api')->group(function() {
    Route::get('/products', [ProductController::class, 'products']);
    Route::get('/products/hits', [ProductController::class, 'hitProducts']);
});
