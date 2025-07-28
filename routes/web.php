<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\DepartmentController;

Route::get('/', function () {
    return view('home');
});

Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::get('/karyawan/list', [KaryawanController::class, 'list'])->name('karyawan.list');
Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
Route::put('/karyawan/{karyawan}', [KaryawanController::class, 'update'])->name('karyawan.update');
Route::delete('/karyawan/{karyawan}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');
Route::get('/departemen', [DepartmentController::class, 'index'])->name('departemen.index');
Route::get('/departemen/list', [DepartmentController::class, 'list'])->name('departemen.list');
Route::post('/departemen', [DepartmentController::class, 'store'])->name('departemen.store');
Route::put('/departemen/{department}', [DepartmentController::class, 'update'])->name('departemen.update');
Route::delete('/departemen/{department}', [DepartmentController::class, 'destroy'])->name('departemen.destroy');