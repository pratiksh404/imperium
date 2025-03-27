<?php

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\FileUploadController;
use App\Http\Controllers\Imperium\DevToolController;
use App\Http\Controllers\Admin\Resourceful\RoleController;
use App\Http\Controllers\Imperium\ImperiumActionController;
use App\Http\Controllers\Imperium\ImperiumResourceController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome');

Route::middleware(['auth', 'verified', HandlePrecognitiveRequests::class])->group(function () {

    Route::inertia('/dashboard', 'Admin/Dashboard')->name('dashboard');

    $namespace = 'App\\Http\\Controllers\\Admin\\Resourceful';
    // $resourcefulControllers = getFilesWithPaths(base_path(str_replace('\\', '/', $namespace)));
    $path = base_path('app/Http/Controllers/Admin/Resourceful');
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

    // Imperium Routes
    Route::post('get-dependencies/{module_name}/{dependable_field_name}', [ImperiumResourceController::class, 'getDependencyValues'])->name('getDependencies');
    Route::post('resource-action/{module_name}/{action_name}', [ImperiumResourceController::class, 'resourceAction'])->name('resourceAction');
    Route::post('imperium/action', [ImperiumActionController::class, 'handleAction'])->name('imperium.action');
    // Dev Tools
    Route::group(['prefix' => 'dev-tools', 'as' => 'dev-tools.'], function () {
        Route::inertia('migration-generator', 'Admin/Modules/DevTools/MigrationGenerator')->name('migration-generator');
    });
});

require __DIR__ . '/auth.php';
