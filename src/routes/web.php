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
    Route::get('/detail/{shop_id}', [ShopController::class, 'index'])->name('detail');
    Route::get('/mypage', [ShopController::class, 'index'])->name('mypage');
});

require __DIR__ . '/auth.php';
