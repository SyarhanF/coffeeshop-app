<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\LaporanController;

Route::resource('users', UserController::class);
Route::resource('kategoris', KategoriController::class);
Route::resource('produks', ProdukController::class);
Route::resource('transaksis', TransaksiController::class);
Route::resource('laporans', LaporanController::class);


