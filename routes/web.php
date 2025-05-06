<?php

use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\ProfileController;
use Pratiksh\Imperium\Http\Controllers\ModuleController;
use Pratiksh\Imperium\Http\Controllers\FileUploadController;
use Pratiksh\Imperium\Http\Controllers\ImperiumActionController;
use Pratiksh\Imperium\Http\Controllers\ImperiumResourceController;
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

    // Imperium Routes
    Route::post('get-dependencies/{module_name}/{dependable_field_name}', [ImperiumResourceController::class, 'getDependencyValues'])->name('getDependencies');
    Route::post('resource-action/{module_name}/{action_name}', [ImperiumResourceController::class, 'resourceAction'])->name('resourceAction');
    Route::post('imperium/action', [ImperiumActionController::class, 'handleAction'])->name('imperium.action');

    // Module Routes
    Route::delete('/bulk-delete/{model}', [ModuleController::class, 'bulkDelete'])
        ->name('bulk-delete');

    Route::post('/reorder/{model}', [ModuleController::class, 'reorder'])
        ->name('reorder');

    Route::put('/restore/{model}/{id}', [ModuleController::class, 'restore'])
        ->name('restore');

    Route::post('/upload/process', [FileUploadController::class, 'process'])
        ->name('upload.process');

    Route::delete('/upload/revert', [FileUploadController::class, 'revert'])
        ->name('upload.revert');
});

require __DIR__ . '/auth.php';
