<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TansaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LaporanController;
use App\Models\TableTransaksi;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login',[LoginController::class,'login'])->name('login');
Route::post('login',[LoginController::class,'login_user']);

// ADMIN
Route::middleware(['auth:usep', \App\Http\Middleware\CekTipeUser::class.':admin'])->group(function(){
    Route::get('admin/log',[LoginController::class,'log']);
    Route::get('admin/kelola-user',[UserController::class,'index']);
    Route::post('admin/kelola-user',[UserController::class,'store']);
    Route::post('admin/kelola-user/update',[UserController::class,'update']);
    Route::post('admin/kelola-user/delete',[UserController::class,'destroy']);
    Route::get('admin/kelola-laporan', [TansaksiController::class, 'index']);
});

// GUDANG
Route::middleware(['auth:usep', \App\Http\Middleware\CekTipeUser::class.':gudang'])->group(function(){
    Route::get('gudang/kelola-barang', [LoginController::class, 'kelolaBarang']);
    Route::get('gudang/kelola-barang', [BarangController::class, 'index']);
    Route::post('gudang/kelola-barang', [BarangController::class, 'store']);
    Route::post('gudang/kelola-barang/update', [BarangController::class, 'update']);
    Route::post('gudang/kelola-barang/delete', [BarangController::class, 'destroy']);
});

// KASIR
Route::middleware(['auth:usep', \App\Http\Middleware\CekTipeUser::class . ':kasir'])->group(function(){
    Route::get('kasir/kelola-transaksi', [TansaksiController::class, 'formTransaksi']);
    Route::post('kasir/kelola-transaksi/tambah', [TansaksiController::class, 'tambahKeranjang']);
    Route::post('kasir/kelola-transaksi/reset', [TansaksiController::class, 'resetKeranjang']);
    Route::post('kasir/kelola-transaksi/simpan', [TansaksiController::class, 'simpanTransaksi']);
});

Route::middleware('auth:usep')->group(function(){
    Route::post('logout',[LoginController::class,'logout']);
});



