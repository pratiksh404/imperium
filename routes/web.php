<?php

use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\Resourceful\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::inertia('/dashboard', 'Admin/Dashboard')->name('dashboard');

    $namespace = 'App\\Http\\Controllers\\Admin\\Resourceful';
    // $resourcefulControllers = getFilesWithPaths(base_path(str_replace('\\', '/', $namespace)));
    $path = base_path('app/Http/Controllers/Admin/Resourceful');
    $resourcefulControllers = getFilesWithPaths($path);
    foreach ($resourcefulControllers as $name => $file_name) {
        $route = Str::plural(strtolower(str_replace('Controller', '', $name)));
        $controller = $namespace.'\\'.$name;
        Route::resource($route, $controller)->except(['show', 'create', 'edit']);
    }

    // Profile Routes
    Route::get('/my-profile', [RoleController::class, 'profile'])->name('users.my-profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role Routes
    Route::post('/roles/{role}/permission-toggle/{permission}', [RoleController::class, 'permissionToggle'])->name('roles.permission-toggle');
    Route::post('/roles/{role}/generate-bread-for-module', [RoleController::class, 'generateBREADForModule'])->name('roles.generate-bread-for-module');

    // Module Routes
    Route::delete('/bulk-delete/{model}', [ModuleController::class, 'bulkDelete'])
        ->name('bulk-delete');

    Route::patch('/reorder/{model}', [ModuleController::class, 'reorder'])
        ->name('reorder');

    Route::patch('/restore/{model}/{id}', [ModuleController::class, 'restore'])
        ->name('restore');

    Route::post('/upload/process', [FileUploadController::class, 'process'])
        ->name('upload.process');

    Route::delete('/upload/revert', [FileUploadController::class, 'revert'])
        ->name('upload.revert');
});

require __DIR__.'/auth.php';
