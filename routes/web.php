<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\mv\ApiControllerS;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('layuots.main');
});

Route::get('/auth', function () {
    return view('auth.auth');
});
Route::get('/signUp', function () {
    return view('auth.register');
});
Route::get('/about', function () {
    return view('about');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
});
Route::get('/favorites', [ProfileController::class, 'favorites'])->name('profile.favorites');
// Route::get('/fetch-and-save', [ApiControllerT::class, 'fetchAndSaveData']);
Route::get('/fetch-and-save', [ApiControllerS::class, 'fetchAndSaveData']);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/products/{product}/addToFavorites', [ProductController::class, 'addToFavorites'])->name('products.addToFavorites');
    Route::post('/products/{product}/removeFromFavorites', [ProductController::class, 'removeFromFavorites'])->name('products.removeFromFavorites');
});

Route::delete('/favorites/{favoriteId}', [ProfileController::class, 'removeFromFavoritesView'])->name('products.removeFromFavoritesView');

Route::get('/admin/favorites', [AdminController::class, 'viewFavorites'])
    ->name('admin.viewFavorites');

Route::post('/admin/comments/{productId}', [AdminController::class, 'addComment'])
    ->name('admin.addComment');