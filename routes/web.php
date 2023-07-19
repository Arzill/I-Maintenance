<?php

use App\Http\Controllers\Calculator\LccController;
use App\Http\Controllers\Calculator\OeeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Calculator\RmbController;
use App\Http\Controllers\PenggunaController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();


Route::get('/', function () {
    return auth()->check()
        ? app()->make(HomeController::class)->index()
        : app()->make(GuestController::class)->index();
})->name('home');

Route::get('/about-us', function () {
    return auth()->check()
        ? app()->make(HomeController::class)->aboutUs()
        : app()->make(GuestController::class)->aboutUs();
})->name('aboutUs');

// Dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/riwayat-rmb', [HomeController::class, 'rmb'])->name('rmb');
Route::get('/riwayat-oee', [HomeController::class, 'oee'])->name('oee');
Route::get('/riwayat-lcc', [HomeController::class, 'lcc'])->name('lcc');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
Route::post('/settings/update', [HomeController::class, 'updateSettings'])->name('update-settings');
Route::post('/settings/updatePassword', [HomeController::class, 'updatePassword'])->name('update-password');


// Oee
Route::get('oee', [OeeController::class, 'index'])->name('calculator-oee');
Route::post('oee/store', [OeeController::class, 'store'])->name('calculator-oee.store');
Route::delete('oee/delete/{id}', [OeeController::class, 'destroy'])->name('calculator-oee.delete');
Route::get('oee/export', [OeeController::class, 'exportOee'])->name('calculator-oee.export');

// Lcc
Route::get('lcc', [LccController::class, 'index'])->name('calculator-lcc');
Route::post('lcc/store', [LccController::class, 'store'])->name('calculator-lcc.store');
Route::delete('lcc/delete/{id}', [LccController::class, 'destroy'])->name('calculator-lcc.delete');
Route::get('lcc/export', [LccController::class, 'exportLcc'])->name('calculator-lcc.export');

// Rmb
Route::get('rmb', [RmbController::class, 'index'])->name('calculator-rmb');

Route::middleware(['admin'])->group(function () {
    Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::patch('pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('pengguna/delete/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.delete');
});
