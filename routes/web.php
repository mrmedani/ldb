<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/offices', function () {
        return view('admin.offices.index');
    })->name('offices.index');

    Route::get('/offices/create', function () {
        return view('admin.offices.create');
    })->name('offices.create');

    Route::get('/offices/{office}/edit', function (App\Models\Office $office) {
        return view('admin.offices.edit', ['office' => $office]);
    })->name('offices.edit');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('/exports/excel', [ExportController::class, 'excel'])->name('exports.excel');
    Route::get('/exports/pdf', [ExportController::class, 'pdf'])->name('exports.pdf');
    Route::get('/exports/print', [ExportController::class, 'print'])->name('exports.print');
});

require __DIR__.'/auth.php';
