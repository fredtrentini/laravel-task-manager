<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return Inertia::render('auth/Login', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})
->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::prefix('projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects.index');
        Route::post('/', [ProjectController::class, 'store'])->name('projects.store');
        Route::put('{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

        Route::prefix('/{project}/tasks')->group(function () {
            Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
            Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
            Route::put('{task}', [TaskController::class, 'update'])->name('tasks.update');
            Route::delete('{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        });
    });
});

require __DIR__.'/settings.php';
