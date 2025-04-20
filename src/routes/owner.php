<?php

use App\Http\Controllers\Auth\Owner\AuthenticatedSessionController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OwnerController;
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

Route::middleware(['auth:owner', 'verified'])->group(function () {
    Route::get('/owner/mypage/{shop_id?}', [OwnerController::class, 'showOwnerMyPage'])->name('owner.page');
    Route::post('/owner/mypage', [OwnerController::class, 'storeShop'])->name('owner.page');
    Route::get('/owner/detail/{shop_id}', [OwnerController::class, 'showOwnerDetailPage'])->name('owner.detail');
    Route::patch('/owner/detail/{shop_id}', [OwnerController::class, 'updateShop'])->name('shop.update');
});
