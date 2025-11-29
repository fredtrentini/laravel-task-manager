<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('auth/Login', [
        'canResetPassword' => Features::enabled(Features::resetPasswords()),
        'canRegister' => Features::enabled(Features::registration()),
        'status' => null,
    ]);
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('projects', function () {
        return Inertia::render('Projects');
    })->name('projects');
});

require __DIR__.'/settings.php';
