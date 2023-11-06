<?php

use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Models\Perusahaan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(PerusahaanController::class)->group(function () {
    Route::get('/perusahaan', 'index')->middleware(['auth', 'verified'])->name('perusahaan');
    Route::post('/perusahaan', 'store')->middleware(['auth', 'verified'])->name('perusahaan.store');
    Route::get('/perusahaan/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('perusahaan.edit');
    Route::put('/perusahaan/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('perusahaan.update'); // Menggunakan metode PUT
    Route::get('/perusahaan/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('perusahaan.destroy');
});
Route::controller(KaryawanController::class)->group(function () {
    Route::get('/karyawan', 'index')->middleware(['auth', 'verified'])->name('karyawan');
    Route::post('/karyawan', 'store')->middleware(['auth', 'verified'])->name('karyawan.store');
    Route::get('/karyawan/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('karyawan.edit');
    Route::put('/karyawan/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('karyawan.update'); // Menggunakan metode PUT
    Route::get('/karyawan/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('karyawan.destroy');
});
Route::controller(PelangganController::class)->group(function () {
    Route::get('/pelanggan', 'index')->middleware(['auth', 'verified'])->name('pelanggan');
    Route::post('/pelanggan', 'store')->middleware(['auth', 'verified'])->name('pelanggan.store');
    Route::get('/pelanggan/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('pelanggan.edit');
    Route::put('/pelanggan/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('pelanggan.update'); // Menggunakan metode PUT
    Route::get('/pelanggan/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('pelanggan.destroy');
});
Route::controller(ProdukController::class)->group(function () {
    Route::get('/produk', 'index')->middleware(['auth', 'verified'])->name('produk');
    Route::post('/produk', 'store')->middleware(['auth', 'verified'])->name('produk.store');
    Route::get('/produk/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('produk.edit');
    Route::put('/produk/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('produk.update'); // Menggunakan metode PUT
    Route::get('/produk/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('produk.destroy');
});
Route::controller(PemasokController::class)->group(function () {
    Route::get('/pemasok', 'index')->middleware(['auth', 'verified'])->name('pemasok');
    Route::post('/pemasok', 'store')->middleware(['auth', 'verified'])->name('pemasok.store');
    Route::get('/pemasok/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('pemasok.edit');
    Route::put('/pemasok/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('pemasok.update'); // Menggunakan metode PUT
    Route::get('/pemasok/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('pemasok.destroy');
});
Route::controller(PembelianController::class)->group(function () {
    Route::get('/pembelian', 'index')->middleware(['auth', 'verified'])->name('pembelian');
    Route::post('/pembelian', 'store')->middleware(['auth', 'verified'])->name('pembelian.store');
    Route::get('/pembelian/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('pembelian.edit');
    Route::put('/pembelian/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('pembelian.update'); // Menggunakan metode PUT
    Route::get('/pembelian/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('pembelian.destroy');
});
Route::controller(PenjualanController::class)->group(function () {
    Route::get('/penjualan', 'index')->middleware(['auth', 'verified'])->name('penjualan');
    Route::post('/penjualan', 'store')->middleware(['auth', 'verified'])->name('penjualan.store');
    Route::get('/penjualan/edit/{id}', 'edit')->middleware(['auth', 'verified'])->name('penjualan.edit');
    Route::put('/penjualan/edit/{id}', 'update')->middleware(['auth', 'verified'])->name('penjualan.update'); // Menggunakan metode PUT
    Route::get('/penjualan/destroy/{id}', 'destroy')->middleware(['auth', 'verified'])->name('penjualan.destroy');
});


require __DIR__.'/auth.php';
