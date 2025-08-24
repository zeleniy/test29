<?php

use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::resource('/brands', CarBrandController::class)->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
Route::resource('/models', CarModelController::class)->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
Route::resource('/cars', CarController::class)->except(['create', 'edit', 'update']);

