<?php

use Illuminate\Support\Str;
use App\Imperium\Application;

if (! function_exists('setting')) {
    function setting($name)
    {
        return config('imperium.' + trim($name), null);
    }
}

if (! function_exists('menus')) {
    function menus()
    {
        return (new Application)->menu()->toArray();
    }
}

if (! function_exists('appHeader')) {
    function appHeader()
    {
        return (new Application)->header();
    }
}

if (! function_exists('resources')) {
    function resources()
    {
        $namespace = 'App\\Imperium\\Resource';
        $path = base_path('app/Imperium/Resource');
        $resources = getFilesWithPaths($path);
        // $resources = getFilesWithPaths(base_path(str_replace('\\', '/', $namespace)));
        $data = [];
        foreach ($resources as $resource => $resource_file) {
            $resource_data = (new ($namespace . '\\' . $resource))->get();
            $data[$resource_data['name']] = $resource_data;
        }

        return $data;
    }
}

if (! function_exists('getResource')) {
    function getResource($name)
    {
        $namespace = 'App\\Imperium\\Resource';
        return (new ($namespace . '\\' . (trim(Str::ucfirst($name)) . 'Resource')))->get();
    }
}

if (! function_exists('getFilesWithPaths')) {
    function getFilesWithPaths(string $basePath, string $extension = 'php'): array
    {
        $filesWithPaths = [];

        // Normalize the base path
        $basePath = realpath($basePath);

        if ($basePath === false || !is_dir($basePath)) {
            return $filesWithPaths; // Return an empty array if the base path is invalid
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === $extension) {
                // Get the relative path from the base path
                $relativePath = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());

                // Ensure we are correctly mapping to "App\Http\Requests"
                $namespacePath = 'App\\Http\\Requests\\' . str_replace(
                    [DIRECTORY_SEPARATOR, '.' . $extension],
                    ['\\', ''],
                    $relativePath
                );

                $filesWithPaths[basename($file->getFilename(), '.' . $extension)] = $namespacePath;
            }
        }

        return $filesWithPaths;
    }
}

if (! function_exists('getAllModels')) {
    function getAllModels()
    {
        $models = [];
        $basePath = app_path('Models');
        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === 'php') {
                $relativePath = str_replace($basePath . DIRECTORY_SEPARATOR, '', $file->getPathname());
                $directory = dirname($relativePath);
                $namespace = 'App\\Models';

                // Add subdirectory to namespace if not in the root directory
                if ($directory !== '.') {
                    $namespace .= '\\' . str_replace('/', '\\', $directory);
                }

                $className = basename($file->getFilename(), '.php');
                $models[$className] = $namespace . '\\' . $className;
            }
        }

        return $models;
    }
}

if (! function_exists('getModelHavingName')) {
    function getModelHavingName($model)
    {
        $models = getAllModels();

        return $models[$model] ?? null;
    }
}

if (! function_exists('getDatabaseDriverName')) {
    function getDatabaseDriverName()
    {
        $connection = config('database.default');
        $driver = config("database.connections.{$connection}.driver");
        return $driver;
    }
}
