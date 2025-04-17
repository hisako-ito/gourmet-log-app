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
});

Route::middleware(['auth:web', 'verified'])->group(function () {
    Route::get('/thanks', function () {
        return view('thanks');
    });
    Route::get('/mypage', [UserController::class, 'showMyPage'])->name('mypage');
    Route::delete('/reservation/delete/{reservation_id}', [UserController::class, 'destroy']);
    Route::patch('/reservation/update/{reservation_id}', [UserController::class, 'update']);
    Route::get('/checkout/{reservation_id}', [UserController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/success/{reservation_id}', [UserController::class, 'success'])->name('checkout.success');
    Route::post('/shop/like/{item_id}', [LikeController::class, 'create']);
    Route::post('/shop/unlike/{item_id}', [LikeController::class, 'destroy']);
    Route::get('/detail/{shop_id}', [UserController::class, 'detail'])->name('user.detail');
    Route::post('/detail/{shop_id}', [UserController::class, 'store'])->name('reservations.store');
    Route::get('/done', [UserController::class, 'done'])->name('done');
    Route::get('/reservation/qr/{token}', [UserController::class, 'verify'])->name('reservation.qr');
    Route::post('/reviews', [UserController::class, 'reviewStore'])->name('reviews.store');
});

require __DIR__ . '/auth.php';
