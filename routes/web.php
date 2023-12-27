<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataTableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisBarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RestokController;
use App\Http\Controllers\StokOutController;
use App\Http\Controllers\SuplierController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function(){
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::get('/datatables', [DataTableController::class, 'datatable'])->name('datatables');

    // user
    Route::group(['prefix' => 'users', 'as' => 'users.', 'middleware' => 'admin'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::post('/update', [UserController::class, 'update'])->name('update');
        Route::post('/self-update', [UserController::class, 'selfUpdate'])->name('self-update');
        Route::delete('/delete', [UserController::class, 'delete'])->name('delete');
    });

    // jenis barang
    Route::group(['prefix' => 'jenis-barang', 'as' => 'jenis-barang.', 'middleware' => 'admin'], function () {
        Route::get('/', [JenisBarangController::class, 'index'])->name('index');
        Route::post('/store', [JenisBarangController::class, 'store'])->name('store');
        Route::post('/update', [JenisBarangController::class, 'update'])->name('update');
        Route::delete('/delete', [JenisBarangController::class, 'delete'])->name('delete');
    });

    // barang
    Route::group(['prefix' => 'barang', 'as' => 'barang.', 'middleware' => 'admin'], function () {
        Route::get('/', [BarangController::class, 'index'])->name('index');
        Route::post('/store', [BarangController::class, 'store'])->name('store');
        Route::post('/update', [BarangController::class, 'update'])->name('update');
        Route::delete('/delete', [BarangController::class, 'delete'])->name('delete');
    });

    // suplier
    Route::group(['prefix' => 'suplier', 'as' => 'suplier.', 'middleware' => 'admin'], function () {
        Route::get('/', [SuplierController::class, 'index'])->name('index');
        Route::post('/store', [SuplierController::class, 'store'])->name('store');
        Route::post('/update', [SuplierController::class, 'update'])->name('update');
        Route::delete('/delete', [SuplierController::class, 'delete'])->name('delete');
    });
    
    // stok
    Route::group(['prefix' => 'stok', 'as' => 'stok.', 'middleware' => 'admin'], function () {
        
        Route::group(['prefix' => 'masuk', 'as' => 'masuk.'], function () {
            Route::get('/', [RestokController::class, 'index'])->name('index');
            Route::post('/store', [RestokController::class, 'store'])->name('store');
            Route::post('/update', [RestokController::class, 'update'])->name('update');
            Route::delete('/delete', [RestokController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'keluar', 'as' => 'keluar.'], function () {
            Route::get('/', [StokOutController::class, 'index'])->name('index');
            Route::post('/store', [StokOutController::class, 'store'])->name('store');
            Route::post('/update', [StokOutController::class, 'update'])->name('update');
            Route::delete('/delete', [StokOutController::class, 'delete'])->name('delete');
        });
    });
        
    // transaksi
    Route::group(['prefix' => 'transaksi', 'as' => 'transaksi.'], function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::post('/store', [TransaksiController::class, 'store'])->name('store');

        Route::get('/view', [TransaksiController::class, 'view'])->name('view');
        Route::get('/print', [TransaksiController::class, 'print'])->name('print');
        // Route::post('/update', [TransaksiController::class, 'update'])->name('update');
        // Route::delete('/delete', [TransaksiController::class, 'delete'])->name('delete');

        Route::post('/cart/store', [TransaksiController::class, 'storeCart'])->name('store-cart');
        Route::delete('/cart/delete', [TransaksiController::class, 'deleteCart'])->name('delete-cart');
        Route::delete('/cart/remove', [TransaksiController::class, 'removeCart'])->name('remove-cart');

    });


});
