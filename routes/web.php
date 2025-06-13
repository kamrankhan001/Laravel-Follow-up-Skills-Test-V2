<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class,'index'])->name('home');
Route::post('/store', [HomeController::class, 'store'])->name('product.store');
Route::put('/product/update', [HomeController::class, 'update'])->name('product.update');
