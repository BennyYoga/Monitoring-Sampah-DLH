<?php

use App\Http\Controllers\c_kabkota;
use App\Http\Controllers\c_tiket;
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

Route::get('/pegawai', function () {
    return view('Pegawai/index');
});

Route::get('/login', function () {
    return view('Login/login');
});

// Route::get('/kabkota', function ('') {
//     return view('kabkota/index');
// });
Route::get('kota', [c_kabkota::class, 'index']);
Route::get('create', [c_kabkota::class, 'create']);
Route::get('tiket', [c_tiket::class, 'index']);
