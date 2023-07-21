<?php

use App\Http\Controllers\c_kabkota;
use App\Http\Controllers\c_tiket;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\KantorController;
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


Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'role:1|2'], function(){
    Route::group(['middleware' => 'role:1'], function(){            
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');    
        Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');    
        Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('/pegawai/edit/{id}', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::get('/pegawai/destroy/{id}', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        Route::get('/pegawai/print', [PegawaiController::class, 'document'])->name('pegawai.document');

        Route::get('/kantor', [KantorController::class, 'index'])->name('kantor');
        Route::get('/kantor/create', [KantorController::class, 'create'])->name('kantor.create');
        Route::post('/kantor/store', [KantorController::class, 'store'])->name('kantor.store');
        Route::get('/kantor/edit/{id}', [KantorController::class, 'edit'])->name('kantor.edit');
        Route::put('/kantor/update/{id}', [KantorController::class, 'update'])->name('kantor.update');
        Route::get('/kantor/destroy/{id}', [KantorController::class, 'destroy'])->name('kantor.destroy');
        Route::get('/kantor/print', [KantorController::class, 'document'])->name('kantor.document');

        Route::get('kota', [c_kabkota::class, 'index'])->name('kabkota.index');
        Route::get('/kota/edit/{id}', [c_kabkota::class, 'edit'])->name('kabkota.edit');
        Route::put('/kota/update/{id}', [c_kabkota::class, 'update'])->name('kabkota.update');
        Route::get('/kota/create', [c_kabkota::class, 'create'])->name('kota.create');
        Route::post('/kota/post', [c_kabkota::class, 'store'])->name('kota.post');
        Route::get('/kota/destroy/{id}', [c_kabkota::class, 'destroy'])->name('kabkota.destroy');
        Route::get('/kota/print', [c_kabkota::class, 'document'])->name('kabkota.document');

    });

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');    
    Route::get('/dashboard/data/{option}', [DashboardController::class, 'getData'])->name('dashboard.data');
    Route::get('tiket/create', [c_tiket::class, 'create'])->name('tiket.create');
    Route::get('tiket', [c_tiket::class, 'index'])->name('tiket.index');
    Route::get('tiket/rekap/', [c_tiket::class, 'rekap'])->name('tiket.rekap'); 
    Route::get('tiket/rekap/data/{optionkota}/{optionHari}', [c_tiket::class, 'rekapData'])->name('tiket.rekap.data');
    Route::get('tiket/rekap/print/{optionkota}/{optionHari}', [c_tiket::class, 'rekapPrint'])->name('tiket.rekap.print');
    Route::post('tiket/post', [c_tiket::class, 'store'])->name('tiket.post');
    Route::get('/tiket/edit/{id}', [c_tiket::class, 'edit'])->name('tiket.edit');
    Route::put('tiket/update/{id}', [c_tiket::class, 'update'])->name('tiket.update');
    Route::get('tiket/print/{id}', [c_tiket::class, 'tiketPrint'])->name('tiket.print');
    // Route::get('tiket/detail/{id}', [c_tiket::class, 'show'])->name('tiket.detail');
});

Route::get('/login', function () {
    return view('Login/login');
});


// Route::get('/tiket/edit/{id}', [c_kabkota::class, 'edit'])->name('kabkota.edit');


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('changePassword', [AuthController::class, 'changePassword'])->name('changePassword.index');
Route::put('updatePassword/{id}', [AuthController::class, 'updatePassword'])->name('updatePassword');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('post-logout', [AuthController::class, 'logout'])->name('logout');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
