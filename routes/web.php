<?php

use App\Http\Controllers\AlatBeratJenisContoller;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\AlatKondisiController;
use App\Http\Controllers\AsetBarangController;
use App\Http\Controllers\AsetJenisController;
use App\Http\Controllers\AsetPembelianController;
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
    return redirect()->route('dashboard');
});


Route::get('/login', function () {
    return view('Login/login');
});


Route::get('/alat', [AlatController::class, 'index'])->name('alat.index');    
Route::get('/alat/create', [AlatController::class, 'create'])->name('alat.create');    
Route::get('/alat/{id}', [AlatController::class, 'show'])->name('alat.show');    
Route::get('/alat/edit/{id}', [AlatController::class, 'edit'])->name('alat.edit');    
Route::get('/alat/delete/{id}', [AlatController::class, 'destroy'])->name('alat.destroy');    
Route::get('/alat/detail/{id}', [AlatController::class, 'getDetail'])->name('alat.getDetail');
Route::put('/alat/update/{id}', [AlatController::class, 'update'])->name('alat.update');    
Route::post('/alat/store', [AlatController::class, 'store'])->name('alat.store');
Route::post('/alat/create/uploadImage', [AlatController::class, 'uploadImage'])->name('alat.create.uploadImage');

Route::get('/jenisalat', [AlatBeratJenisContoller::class, 'index'])->name('jenisalat.index');
Route::post('/jenisalat/store', [AlatBeratJenisContoller::class, 'store'])->name('jenisalat.store');
Route::put('/jenisalat/update', [AlatBeratJenisContoller::class, 'update'])->name('jenisalat.update');
Route::get('/jenisalat/destroy/{id}', [AlatBeratJenisContoller::class, 'destroy'])->name('jenisalat.destroy');

Route::get('/kondisialat', [AlatKondisiController::class, 'index'])->name('kondisialat.index');
Route::post('/kondisialat/store', [AlatKondisiController::class, 'store'])->name('kondisialat.store');
Route::put('/kondisialat/update', [AlatKondisiController::class, 'update'])->name('kondisialat.update');
Route::get('/kondisialat/destroy/{id}', [AlatKondisiController::class, 'destroy'])->name('kondisialat.destroy');

Route::get('/aset/jenis', [AsetJenisController::class, 'index'])->name('aset.jenis.index');
Route::post('/aset/jenis/store', [AsetJenisController::class, 'store'])->name('aset.jenis.store');
Route::get('/aset/jenis/destroy/{id}', [AsetJenisController::class, 'destroy'])->name('aset.jenis.destroy');
Route::put('/aset/jenis/update/', [AsetJenisController::class, 'update'])->name('aset.jenis.update');

Route::get('/aset/barang', [AsetBarangController::class, 'index'])->name('aset.barang.index');
Route::post('/aset/barang/store', [AsetBarangController::class, 'store'])->name('aset.barang.store');
Route::get('/aset/barang/destroy/{id}', [AsetBarangController::class, 'destroy'])->name('aset.barang.destroy');
Route::put('/aset/barang/update/', [AsetBarangController::class, 'update'])->name('aset.barang.update');

Route::get('/aset/pembelian', [AsetPembelianController::class, 'index'])->name('aset.pembelian.index');

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
    Route::get('/dashboard/graph/{undefined}', [DashboardController::class, 'grafik'])->name('dashboard.graph');    
    Route::get('/dashboard/pie/{undefined}', [DashboardController::class, 'pie'])->name('dashboard.pie');    
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
    Route::get('/tiket/print-excel/{optionkota}/{optionHari}', [c_tiket::class, 'exportExcel'])->name('tiket.excel');
});


Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('changePassword', [AuthController::class, 'changePassword'])->name('changePassword.index');
Route::put('updatePassword/{id}', [AuthController::class, 'updatePassword'])->name('updatePassword');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('post-logout', [AuthController::class, 'logout'])->name('logout');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
