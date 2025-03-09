<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResearchDocumentController;
use Illuminate\Support\Facades\Route;

// Welcome page route
Route::get('/', function () {
    return view('welcome');
});

// User dashboard route (protected by auth and verified middleware)
Route::get('/dashboard', [ResearchDocumentController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes (only accessible to authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Upload page route (public)
Route::get('/upload', function () {
    return view('upload');
})->name('upload');

// Research document routes (protected by auth middleware)
Route::middleware('auth')->group(function () {
    // Research document routes
    Route::prefix('research')->group(function () {
        Route::post('/', [ResearchDocumentController::class, 'store'])->name('research-document.store');
        Route::get('/{id}/download', [ResearchDocumentController::class, 'download'])->name('research-document.download');
        Route::put('/research/{id}/approve', [ResearchDocumentController::class, 'approve'])->name('research.approve');

        Route::delete('/{id}/reject', [ResearchDocumentController::class, 'reject'])->name('research.reject');
    });

    // Admin routes for research documents
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [ResearchDocumentController::class, 'adminDashboard'])->name('admin.dashboard');
    });
});

require __DIR__.'/auth.php';