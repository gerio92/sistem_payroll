<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\SlipGajiController;

// Route Login
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'authenticate']);
Route::post('/logout', [AuthController::class, 'logout']);

// Route Register
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);

Route::middleware(['check.access'])->group(function () {
    // Menampilkan daftar karyawan untuk dihitung gaji
    Route::get('/payroll/karyawan', [PayrollController::class, 'showKaryawanList'])->name('payroll.karyawan_list');
    
    // Rute setelah memilih karyawan untuk perhitungan gaji
    Route::get('/payroll/select_karyawan/{id}', [PayrollController::class, 'showSelectKaryawan'])->name('select_karyawan.show');
    
    // Menghitung gaji karyawan sesuai yang diselect
    Route::post('/payroll/calculate/{id}', [PayrollController::class, 'calculatePayroll'])->name('payroll.calculate');
    
    
    // Menampilkan hasil perhitungan gaji
    Route::get('/payroll/result/{id}', [PayrollController::class, 'showResult'])->name('payroll.result');

    // Menyimpan data slip gaji
    Route::post('/sahkan', [PayrollController::class, 'sahkanSlipGaji'])->name('sahkan_slip_gaji');

    Route::get('/export_slip_gaji', [SlipGajiController::class, 'export'])->name('slipgaji.export');
    //route ketika mau cetak
    Route::get('/export_slip_gaji/{id}', [SlipGajiController::class, 'acc'])->name('slipgaji.acc');
    //route hapus
    Route::delete('/export_slip_gaji/{id}', [SlipGajiController::class, 'destroy'])->name('slipgaji.destroy');
    Route::delete('/export_slip_gaji/delete_all', [SlipGajiController::class, 'destroyAll'])->name('slipgaji.destroyAll');
    Route::get('/report', [AbsensiController::class, 'report'])->name('absensi.report');


    //export pdf
    Route::get('/exportPDF/{id}', [SlipGajiController::class, 'exportPDF'])->name('slipgaji.exportPDF');



    // Route menampilkan daftar karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    
    // Route menambahkan karyawan
    Route::get('/karyawan/create', [KaryawanController::class, 'create'])->name('karyawan.create');
    Route::post('/karyawan', [KaryawanController::class, 'store'])->name('karyawan.store');
    
    // Route Edit Karyawan
    Route::get('/karyawan/{id}/edit', [KaryawanController::class, 'edit'])->name('karyawan.edit');
    Route::put('/karyawan/{id}', [KaryawanController::class, 'update'])->name('karyawan.update');
    //Route Hapus Karyawan
    Route::delete('/karyawan/{id}', [KaryawanController::class, 'destroy'])->name('karyawan.destroy');

    
    // Route membuat absensi untuk karyawan
    Route::get('absensi/create', [AbsensiController::class, 'create'])->name('absensi.create');
    Route::post('absensi', [AbsensiController::class, 'store'])->name('absensi.store');
    
    // Route menampilkan absensi
    Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
    // Route menampilkan laporan absensi untuk cek jumlah ketidakhadiran

    // Rute yang hanya bisa diakses oleh supervisor
    Route::middleware(['App\Http\Middleware\CheckAccessLevel:supervisor'])->group(function () {
        //melihat daftar gaji karyawan perbulannya
        Route::get('/slipgaji', [SlipGajiController::class, 'index'])->name('slipgaji.index');
        Route::get('/slipgaji/{id}', [SlipGajiController::class, 'show'])->name('slipgaji.show');
        Route::post('/slipgaji/approve/{id}', [SlipGajiController::class, 'approveSlip'])->name('slipgaji.approve');
        Route::get('/user', [AuthController::class, 'admin'])->name('user.admin');
        Route::get('/user/{id}/edit', [AuthController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [AuthController::class, 'update'])->name('user.update');




    });
    
});
