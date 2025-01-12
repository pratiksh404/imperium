<?php

namespace App\Traits\Console;

use function Laravel\Prompts\select;

trait NeedsModel
{
    public function getModelFromConsole()
    {
        $models = getAllModels();
        $model = select('Select model', $models);

        $namespace = $models[$model];

        return json_decode(json_encode([
            'namespace' => $namespace,
            'model' => $model,
        ]));
    }
}
