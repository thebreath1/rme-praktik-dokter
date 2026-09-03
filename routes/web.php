<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi Rekam Medis Elektronik (RME)
|--------------------------------------------------------------------------
*/

// Rute Publik / Guest
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute Terproteksi Autentikasi (Admin/Perawat & Dokter)
Route::middleware(['auth'])->group(function () {
    // Logout universal
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Beranda & Dashboard
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Modul Pasien (Registrasi, Daftar, Cari, Detail Rekam Medis, Edit)
    Route::resource('patients', PatientController::class)->except(['destroy']);

    // Modul Kunjungan Medis & Resep Obat
    Route::get('/patients/{patient}/visits/create', [VisitController::class, 'create'])->name('patients.visits.create');
    Route::post('/patients/{patient}/visits', [VisitController::class, 'store'])->name('patients.visits.store');

    // Modul Cetak Resep Digital (Kop Praktik, Rx, Signa, Paraf Dokter)
    Route::get('/visits/{visit}/print-prescription', [VisitController::class, 'printPrescription'])->name('visits.print');
});