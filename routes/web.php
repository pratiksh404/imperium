<?php

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProfileController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::prefix('admin')->middleware(['auth', 'verified', HandlePrecognitiveRequests::class])->group(function () {

    Route::inertia('/dashboard', 'Admin/Dashboard')->name('dashboard');

    $namespace = 'App\\Http\\Controllers\\Admin';
    // $resourcefulControllers = getFilesWithPaths(base_path(str_replace('\\', '/', $namespace)));
    $path = base_path('app/Http/Controllers/Admin');
    $resourcefulControllers = getFilesWithNameSpace($path);
    foreach ($resourcefulControllers as $name => $controller) {
        $route = Str::plural(strtolower(str_replace('Controller', '', $name)));
        Route::resource($route, $controller)->except(['show', 'create', 'edit']);
    }

    // Profile Routes
    Route::get('/my-profile', [ProfileController::class, 'edit'])->name('users.my-profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role Routes
    Route::post('/roles/{role}/permission-toggle/{permission}', [RoleController::class, 'permissionToggle'])->name('roles.permission-toggle');
    Route::post('/roles/{role}/generate-bread-for-module', [RoleController::class, 'generateBREADForModule'])->name('roles.generate-bread-for-module');

    // Dev Tools
    Route::group(['prefix' => 'dev-tools', 'as' => 'dev-tools.'], function () {
        Route::inertia('migration-generator', 'Admin/Modules/DevTools/MigrationGenerator')->name('migration-generator');
    });
});

require __DIR__ . '/auth.php';
