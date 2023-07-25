<?php

use App\Http\Controllers\Calculator\LccController;
use App\Http\Controllers\Calculator\OeeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Calculator\RbmController;
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

// User Dashboard
Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
Route::get('/riwayat-rbm', [HomeController::class, 'rbm'])->name('rbm');
Route::get('/riwayat-oee', [HomeController::class, 'oee'])->name('oee');
Route::get('/riwayat-lcc', [HomeController::class, 'lcc'])->name('lcc');
Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
Route::patch('/settings/update/{id}', [PenggunaController::class, 'updateSettings'])->name('update-settings');
Route::patch('/settings/updatePassword/{id}', [PenggunaController::class, 'updatePassword'])->name('update-password');

// Oee
Route::prefix('oee')->group(function () {
    Route::get('/', [OeeController::class, 'index'])->name('calculator-oee');
    Route::post('store', [OeeController::class, 'store'])->name('calculator-oee.store');
    Route::delete('delete/{id}', [OeeController::class, 'destroy'])->name('calculator-oee.delete');
    Route::get('export', [OeeController::class, 'exportOee'])->name('calculator-oee.export');
});


// Lcc
Route::prefix('lcc')->group(function () {
    Route::get('/', [LccController::class, 'index'])->name('calculator-lcc');
    Route::post('store', [LccController::class, 'store'])->name('calculator-lcc.store');
    Route::delete('delete/{id}', [LccController::class, 'destroy'])->name('calculator-lcc.delete');
    Route::get('export', [LccController::class, 'exportLcc'])->name('calculator-lcc.export');
});


// RBM
Route::prefix('rbm')->group(function () {
    Route::get('/', [RbmController::class, 'index'])->name('calculator-rbm');
    Route::post('/store', [RbmController::class, 'store'])->name('calculator-rbm.store');
    Route::delete('/delete/{id}', [RbmController::class, 'destroy'])->name('calculator-rbm.delete');
    Route::get('/export', [RbmController::class, 'exportRbm'])->name('calculator-rbm.export');
    Route::get('/preventive-maintenance', function () {
        return view('pages.calculator.preventiveMaintenance');
    })->name('preventiveMaintenance');
    Route::get('/correctiveMaintenance', function () {
        return view('pages.calculator.correctiveMaintenance');
    })->name('correctiveMaintenance');
});



Route::middleware(['admin'])->group(function () {
    // Admin Dashboard
    Route::get('pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('pengguna/edit/{id}', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::patch('pengguna/update/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('pengguna/delete/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.delete');
});
