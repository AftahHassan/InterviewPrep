<?php

use App\Http\Controllers\ConceptController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    Route::resource('domains', DomainController::class)->except('show');

    Route::resource('domains.concepts', ConceptController::class)->scoped(['concept' => 'domain_id']);
    Route::patch('domains/{domain}/concepts/{concept}/status', [ConceptController::class, 'updateStatus'])
        ->name('domains.concepts.updateStatus');
});

require __DIR__.'/auth.php';
