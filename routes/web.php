<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MahasiswaController;

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

Route::resource('mahasiswas', MahasiswaController::class);
Route::get('mahasiswas',  [MahasiswaController::class, 'search'])->name('search');
Route::get('nilai/{id}', [MahasiswaController::class,'nilai'])->name('mahasiswa.nilai');
Route::get('/mahasiswas/cetak_pdf/{id}', [MahasiswaController::class,'cetak_pdf'])->name('mahasiswa.cetak_pdf');

Route::resource('articles', ArticleController::class);
Route::get('/article/cetak_pdf', [ArticleController::class, 'cetak_pdf']);
