<?php

use App\Services\Menu;

if (! function_exists('setting')) {
    function setting($name)
    {
        return config('imperium.' + trim($name), null);
    }
}

if (! function_exists('menus')) {
    function menus()
    {
        return (new Menu)->all();
    }
}

if (! function_exists('resources')) {
    function resources()
    {
        $namespace = 'App\\Imperium\\Resource';
        $resources = getFilesWithPaths(base_path(str_replace('\\', '/', $namespace)));
        $data = [];
        foreach ($resources as $resource => $resource_file) {
            $resource_data = (new ($namespace.'\\'.$resource))->get();
            $data[$resource_data['name']] = $resource_data;
        }

        return $data;
    }
}

if (! function_exists('getFilesWithPaths')) {
    function getFilesWithPaths(string $basePath, string $extension = 'php'): array
    {
        $filesWithPaths = [];

        // Normalize the base path
        $basePath = realpath($basePath);
        if ($basePath === false || ! is_dir($basePath)) {
            return $filesWithPaths; // Return an empty array if the base path is invalid
        }

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath));

        foreach ($iterator as $file) {
            if ($file->isFile() && $file->getExtension() === $extension) {
                // Get the relative path from the base path
                $relativePath = str_replace($basePath.DIRECTORY_SEPARATOR, '', $file->getPathname());
                $filesWithPaths[basename($file->getFilename(), '.'.$extension)] = $relativePath;
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
                $relativePath = str_replace($basePath.DIRECTORY_SEPARATOR, '', $file->getPathname());
                $directory = dirname($relativePath);
                $namespace = 'App\\Models';

                // Add subdirectory to namespace if not in the root directory
                if ($directory !== '.') {
                    $namespace .= '\\'.str_replace('/', '\\', $directory);
                }

                $className = basename($file->getFilename(), '.php');
                $models[$className] = $namespace.'\\'.$className;
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
