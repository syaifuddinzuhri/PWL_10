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

Route::get('articles/print-pdf', [ArticleController::class, 'print_pdf'])->name('articles.print');
Route::get('mahasiswa/cetak-khs/{nim}', [MahasiswaController::class, 'cetak_khs'])->name('nilai.cetak');
Route::get('mahasiswa/nilai/{nim}', [MahasiswaController::class, 'nilai'])->name('mahasiswa.nilai');
Route::get('mahasiswa/search', [MahasiswaController::class, 'search'])->name('mahasiswa.search');

Route::resource('articles', ArticleController::class);
Route::resource('mahasiswa', MahasiswaController::class);