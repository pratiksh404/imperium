<?php

namespace App\Providers;

use App\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class ImperiumServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Repos
        $this->bindRepositoryToInterface();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton('menu', function () {
            return include app_path('Imperium/menu.php');
        });

    }

    protected function bindRepositoryToInterface(): void
    {
        // Define paths for contracts and repositories
        $contractsPath = app_path('Contracts');
        $repositoriesNamespace = 'App\Repositories';

        // Get all interface files from Contracts folder
        $files = File::files($contractsPath);

        foreach ($files as $file) {
            $interfaceName = $file->getFilenameWithoutExtension(); // e.g., "RoleRepositoryInterface"
            if ($interfaceName != 'ResourcefulInterface' && str_contains($interfaceName, 'RepositoryInterface')) {
                $moduleName = str_replace('RepositoryInterface', '', $interfaceName); // Extract "Role"

                // Construct class names
                $interfaceClass = "App\\Contracts\\{$interfaceName}";
                $repositoryClass = "{$repositoriesNamespace}\\{$moduleName}Repository";

                // Check if the repository class exists
                if (class_exists($repositoryClass)) {
                    $this->app->bind($interfaceClass, $repositoryClass);
                }
            }
        }
    }
}
