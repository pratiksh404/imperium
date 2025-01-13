<?php

namespace App\Traits\Console;

use Illuminate\Support\Str;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;

trait NeedsModel
{
    public function getModelFromConsole()
    {

        $models = getAllModels();
        // $model = select('Select model', $models);
        $namespace = search(
            label: 'Search for the user that should receive the mail',
            options: fn (string $value) => collect($models)
                ->filter(fn ($namespace, $modelName) => Str::contains($namespace, $value, ignoreCase: true))
                ->values()
                ->all(),
        );

        $model = class_basename($namespace);

        return json_decode(json_encode([
            'namespace' => $namespace,
            'model' => $model,
        ]));
    }
}
