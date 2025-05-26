<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DailyPengajuanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataController;
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

Route::get('/', [DashboardController::class,'index'])->name('dashboard');


Route::get('/login', [AuthController::class,'showLoginForm'])->name('login');
Route::post('/loginn', [AuthController::class,'login'])->name('loginn');
Route::get('/logout', [AuthController::class,'logout'])->name('logout');

Route::get('/po', [DataController::class, 'index'])->name('po.index');
Route::get('/po/create', [DataController::class, 'create'])->name('po.create');
Route::post('/po', [DataController::class, 'store'])->name('po.store');
Route::get('/po/{id}/edit', [DataController::class, 'edit'])->name('po.edit');
Route::put('/po/{id}', [DataController::class, 'update'])->name('po.update');
Route::delete('/po/{id}', [DataController::class, 'destroy'])->name('po.destroy');


Route::get('/daily-pengajuan', [DailyPengajuanController::class, 'index'])->name('daily_pengajuan.index');
Route::get('/daily-pengajuan/{id}', [DailyPengajuanController::class, 'show'])->name('daily_pengajuan.show');
Route::get('/daily-pengajuan/{id}/edit', [DailyPengajuanController::class, 'edit'])->name('daily_pengajuan.edit');
Route::put('/daily-pengajuan/{id}', [DailyPengajuanController::class, 'update'])->name('daily_pengajuan.update');
Route::delete('/daily-pengajuan/{id}', [DailyPengajuanController::class, 'destroy'])->name('daily_pengajuan.destroy');
Route::post('/daily-pengajuan/{id}/kurang', [DailyPengajuanController::class, 'updateKurang'])->name('daily_pengajuan.kurang.update');

Route::get('/tambah-daily-pengajuan', [DailyPengajuanController::class, 'create'])->name('daily_pengajuan.create');
Route::post('/daily-pengajuan', [DailyPengajuanController::class, 'store'])->name('daily_pengajuan.store');

Route::get('/kurang', [DashboardController::class, 'kurangTable'])->name('kurang.table');
Route::get('/pengajuan', [DashboardController::class, 'table'])->name('pengajuan.table');
