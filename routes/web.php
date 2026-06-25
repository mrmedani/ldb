<?php

use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\WilayaDeliveryController;
use App\Http\Controllers\Public\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/offices/download-pdf', [HomeController::class, 'downloadPdf'])->name('public.offices.download-pdf');

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

    Route::get('/wilayas/delivery', [WilayaDeliveryController::class, 'edit'])->name('wilayas.delivery');
    Route::post('/wilayas/delivery', [WilayaDeliveryController::class, 'update'])->name('wilayas.delivery.update');

    Route::get('/exports/excel', [ExportController::class, 'excel'])->name('exports.excel');
    Route::get('/exports/pdf', [ExportController::class, 'pdf'])->name('exports.pdf');
    Route::get('/exports/print', [ExportController::class, 'print'])->name('exports.print');

    Route::get('/logs', function () {
        return view('admin.logs');
    })->name('logs');

    Route::get('/backups', [BackupController::class, 'index'])->name('backups');
    Route::get('/backups/download/{filename}', [BackupController::class, 'download'])->name('backups.download');
    Route::get('/backups/run', [BackupController::class, 'run'])->name('backups.run');

    Route::get('/bug-reports', function () {
        return view('admin.bug-reports');
    })->name('bug-reports');
});

require __DIR__.'/auth.php';
