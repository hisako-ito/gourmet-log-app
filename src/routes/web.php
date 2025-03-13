<?php

use App\Http\Controllers\ShopController;
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

Route::get('/thanks', function () {
    return view('thanks');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/thanks', function () {
        return view('thanks');
    });
    Route::get('/', [ShopController::class, 'index'])->name('home');
    Route::get('/search', [ShopController::class, 'search']);
    Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');
    Route::post('/detail/{shop_id}', [ShopController::class, 'store'])->name('reservations.store');
    Route::get('/test', [ShopController::class, 'test'])->name('test');
    Route::get('/mypage', [ShopController::class, 'index'])->name('mypage');
});

require __DIR__ . '/auth.php';
