<?php

use App\Http\Controllers\CarBrandController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::resource('/brands', CarBrandController::class)->except(['create', 'store', 'show', 'edit', 'update', 'destroy']);
