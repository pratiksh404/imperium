<?php

namespace App\Services\Generator\Scaffold;

use App\Contracts\Generator\GeneratorInterface;
use App\Services\Generator\Generator;
use Illuminate\Support\Str;

class ImperiumResourceGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameLowercase}}',
                '{{modelNamePluralLowercase}}',
                '{{modelNamePluralUppercase}}',
                '{{modelNamespace}}',
            ], [
                $this->name,
                strtolower($this->name),
                strtolower(Str::plural($this->name)),
                Str::ucfirst(Str::plural($this->name)),
                $this->model_namespace,
            ],
            $this->getStub('ImperiumResource'),
        );

        return $this->makeFile(app_path('Imperium/Resource/'.$this->name.'Resource.php'), $template);
    }
}
