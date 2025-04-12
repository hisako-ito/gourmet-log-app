<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
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

Route::middleware(['auth:admin,owner,web', 'verified'])->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('home');
    Route::get('/search', [ShopController::class, 'search'])->name('search');
    Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');
});

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/thanks', function () {
        return view('thanks');
    });
    Route::post('/shop/like/{item_id}', [LikeController::class, 'create']);
    Route::post('/shop/unlike/{item_id}', [LikeController::class, 'destroy']);
    Route::post('/detail/{shop_id}', [ShopController::class, 'store'])->name('reservations.store');
    Route::get('/done', [ShopController::class, 'done'])->name('done');
    Route::get('/mypage', [UserController::class, 'showMyPage'])->name('mypage');
    Route::post('/reservation/delete/{reservation_id}', [UserController::class, 'destroy']);
    Route::post('/reservation/update/{reservation_id}', [UserController::class, 'update']);
});

require __DIR__ . '/auth.php';
