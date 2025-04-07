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

Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    Route::get('/adminpage', [AdminController::class, 'showAdminPage'])->name('admin.page');
});
