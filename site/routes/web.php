<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/user/{id}', [App\Http\Controllers\MainController::class, 'getUserBalance'])->where('id', '[0-9]+');
Route::get('/history/{limit}', [App\Http\Controllers\MainController::class, 'getBalanceHistory'])->where('limit', '[0-9]+');
