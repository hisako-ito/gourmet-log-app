<?php

use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
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

Route::middleware(['auth:admin', 'verified'])->group(function () {
    Route::get('/admin/mypage', [AdminController::class, 'showAdminMyPage'])->name('admin.page');
    Route::post('/admin/mypage/send-notice', [AdminController::class, 'sendNotice'])->name('admin.sendNotice');
    Route::get('/admin/detail/{shop_id}', [AdminController::class, 'showAdminDetailPage'])->name('admin.detail');
});
