<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/order', [OrderController::class, 'index'])->name('order_index');
Route::post('/order', [OrderController::class, 'create'])->name('order_create');
Route::post('/order/update', [OrderController::class, 'update'])->name('order_update');
Route::post('/order/delete', [OrderController::class, 'delete'])->name('order_delete');