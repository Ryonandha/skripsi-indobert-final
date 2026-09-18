<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Education\EducationController;
use App\Http\Controllers\Mahasiswa\NotificationController;
use App\Http\Controllers\Mahasiswa\ScreeningController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Psikolog\PsikologController;
use Illuminate\Support\Facades\Route;

 // Publik
Route::get('/', fn () => view('welcome'))->name('home');

 // Public education detail
Route::get('/edukasi/{education:slug}', [EducationController::class, 'show'])->name('education.show');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    // Login Google (OAuth) khusus mahasiswa @student.stikomyos.ac.id
    Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('auth/google/callback', [GoogleAuthController::class, 'callback'])->name('google.callback');

    // Portal login admin terpisah (tanpa Google, tanpa registrasi)
    Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login');
    Route::post('admin/login', [AdminLoginController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (all roles)
    Route::prefix('profil')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password');
    });

    // ---- Mahasiswa ----
    Route::prefix('skrining')->name('mahasiswa.')->middleware('role:mahasiswa')->group(function () {
        Route::get('/baru', [ScreeningController::class, 'create'])->name('screening.create');
        Route::post('', [ScreeningController::class, 'store'])->name('screening.store');
        Route::get('/riwayat', [ScreeningController::class, 'history'])->name('history');
        Route::get('/{screening}', [ScreeningController::class, 'show'])->name('screening.show');
        Route::post('/{screening}/consent', [ScreeningController::class, 'consent'])->name('consent');
    });

    // ---- Notifikasi Mahasiswa (pesan dari psikolog) ----
    Route::prefix('notifikasi')->name('mahasiswa.notifikasi.')->middleware('role:mahasiswa')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::post('/{message}/baca', [NotificationController::class, 'markRead'])->name('read');
        Route::post('/baca-semua', [NotificationController::class, 'markAllRead'])->name('readAll');
    });

    // ---- Admin Teknis ----
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/edukasi', [AdminController::class, 'educations'])->name('educations');
        Route::get('/edukasi/tambah', [AdminController::class, 'createEducation'])->name('educations.create');
        Route::post('/edukasi', [AdminController::class, 'storeEducation'])->name('educations.store');
        Route::get('/edukasi/{education}/edit', [AdminController::class, 'editEducation'])->name('educations.edit');
        Route::put('/edukasi/{education}', [AdminController::class, 'updateEducation'])->name('educations.update');
        Route::delete('/edukasi/{education}', [AdminController::class, 'destroyEducation'])->name('educations.destroy');
        Route::get('/pengguna', [AdminController::class, 'users'])->name('users');
        Route::get('/pengguna/tambah', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/pengguna', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/pengguna/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/pengguna/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/pengguna/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    });

    // ---- Psikolog / Konselor ----
    Route::prefix('psikolog')->name('psikolog.')->middleware('role:psikolog')->group(function () {
        Route::get('/', [PsikologController::class, 'dashboard'])->name('dashboard');
        Route::get('/pasien', [PsikologController::class, 'patients'])->name('patients');
        Route::get('/pasien/{student}', [PsikologController::class, 'patientDetail'])->name('patient-detail');
        Route::get('/screening/{screening}', [PsikologController::class, 'screeningDetail'])->name('screening-detail');
        Route::get('/jadwal', [PsikologController::class, 'schedule'])->name('schedule');
        Route::post('/jadwal', [PsikologController::class, 'storeSchedule'])->name('schedule.store');
        Route::post('/jadwal/{schedule}/status', [PsikologController::class, 'updateScheduleStatus'])->name('schedule.status');
        Route::delete('/jadwal/{schedule}', [PsikologController::class, 'destroySchedule'])->name('schedule.destroy');
        Route::get('/catatan', [PsikologController::class, 'notes'])->name('notes');
        Route::post('/{screening}/penanganan', [PsikologController::class, 'updateHandling'])->name('handling');
        Route::post('/{screening}/hubungi', [PsikologController::class, 'contactStudent'])->name('contact');
    });
});