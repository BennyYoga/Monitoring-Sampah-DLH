<?php

use App\Http\Controllers\c_kabkota;
use App\Http\Controllers\c_tiket;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PegawaiController;
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
    Route::get('/pegawai', [PegawaiController::class, 'index'])->name('pegawai');    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');    
});

Route::get('/login', function () {
    return view('Login/login');
});

// Route::get('/kabkota', function ('') {
//     return view('kabkota/index');
// });
Route::get('kota', [c_kabkota::class, 'index']);
Route::get('create', [c_kabkota::class, 'create']);
Route::get('tiket', [c_tiket::class, 'index'])->name('tiket.index');
Route::get('tiket/create', [c_tiket::class, 'create']);
Route::post('tiket/post', [c_tiket::class, 'store'])->name('tiket.post');
Route::get('/tiket/edit/{id}', [c_tiket::class, 'edit'])->name('tiket.edit');
Route::put('tiket/update/{id}', [c_tiket::class, 'update'])->name('tiket.update');
Route::get('login', [AuthController::class, 'index'])->name('login');
Route::get('logout', [AuthController::class, 'logout']);
Route::post('post-logout', [AuthController::class, 'logout'])->name('logout');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
