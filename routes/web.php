<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Pasien\JanjiPeriksaController;
use App\Http\Controllers\Dokter\MemeriksaController;
use App\Http\Controllers\Pasien\RiwayatPeriksaController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () { 
    Route::get('/dashboard', function () { 
        return view('dokter.dashboard'); 
    })->name('dokter.dashboard'); 

    Route::prefix('jadwal-periksa')->group(function(){ 
        Route::get('/', [JadwalPeriksaController::class, 'index'])->name('dokter.jadwal-periksa.index'); 
        Route::post('/', [JadwalPeriksaController::class, 'store'])->name('dokter.jadwal-periksa.store'); 
        Route::patch('/{id}', [JadwalPeriksaController::class, 'update'])->name('dokter.jadwal-periksa.update');
        Route::get('/edit/{id}', [JadwalPeriksaController::class, 'edit'])->name('dokter.jadwal-periksa.edit');
        Route::delete('/{id}', [JadwalPeriksaController::class, 'destroy'])->name('dokter.jadwal-periksa.destroy');
    });

    Route::prefix('memeriksa')->group(function () { 
        Route::get('/', [MemeriksaController::class, 'index'])->name('dokter.memeriksa.index'); 
        Route::post('/{id}', [MemeriksaController::class, 'store'])->name('dokter.memeriksa.store'); 
        Route::get('/{id}/periksa', [MemeriksaController::class, 'periksa'])->name('dokter.memeriksa.periksa'); 
        Route::get('/{id}/edit', [MemeriksaController::class, 'edit'])->name('dokter.memeriksa.edit'); 
        Route::patch('/{id}', [MemeriksaController::class, 'update'])->name('dokter.memeriksa.update'); 
    });

    // Profile
    Route::get('/profile', [App\Http\Controllers\Dokter\ProfileController::class, 'show'])->name('dokter.profile.show');
    Route::get('/profile/edit', [App\Http\Controllers\Dokter\ProfileController::class, 'edit'])->name('dokter.profile.edit');
    Route::put('/profile', [App\Http\Controllers\Dokter\ProfileController::class, 'update'])->name('dokter.profile.update');

    // Obat
    Route::get('/obat', [App\Http\Controllers\Dokter\ObatController::class, 'index'])->name('dokter.obat.index');
    Route::get('/obat/create', [App\Http\Controllers\Dokter\ObatController::class, 'create'])->name('dokter.obat.create');
    Route::post('/obat', [App\Http\Controllers\Dokter\ObatController::class, 'store'])->name('dokter.obat.store');
    Route::get('/obat/{obat}/edit', [App\Http\Controllers\Dokter\ObatController::class, 'edit'])->name('dokter.obat.edit');
    Route::put('/obat/{obat}', [App\Http\Controllers\Dokter\ObatController::class, 'update'])->name('dokter.obat.update');
    Route::delete('/obat/{obat}', [App\Http\Controllers\Dokter\ObatController::class, 'destroy'])->name('dokter.obat.destroy');
}); 
 
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () { 
    Route::get('/dashboard', function () { 
        return view('pasien.dashboard'); 
    })->name('pasien.dashboard'); 

    Route::prefix('janji-periksa')->group(function(){ 
        Route::get('/', [JanjiPeriksaController::class, 'index'])->name('pasien.janji-periksa.index'); 
        Route::post('/', [JanjiPeriksaController::class, 'store'])->name('pasien.janji-periksa.store'); 
    });

    Route::prefix('riwayat-periksa')->group(function(){ 
        Route::get('/', [RiwayatPeriksaController::class, 'index'])->name('pasien.riwayat-periksa.index'); 
    });
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
