<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiscountController;

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

Route::view('/', 'welcome');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/discount', [DiscountController::class, 'index'])->name('discount');

    Route::post('/discount', [DiscountController::class, 'create']);
    Route::get('/discount', [DiscountController::class, 'check']);
});
