<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\PowerballController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;

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

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name(
        'dashboard'
    );

    Route::get('/txlotto', [LotteryController::class, 'txlotto']);
    Route::get('/powerball', [PowerballController::class, 'index']);

    Route::get('admin/index', [AdminController::class, 'index'])->name(
        'admin/index'
    );

    Route::get('updatePowerball', [
        PowerballController::class,
        'updateWithoutKey',
    ])->name('updatePowerball');
});

require __DIR__ . '/auth.php';

Auth::routes();

// Route::get('/home', [
//     App\Http\Controllers\HomeController::class,
//     'index',
// ])->name('home');
