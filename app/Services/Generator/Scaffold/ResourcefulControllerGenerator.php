<?php

namespace App\Services\Generator\Scaffold;

use App\Contracts\Generator\GeneratorInterface;
use App\Services\Generator\Generator;
use Illuminate\Support\Str;

class ResourcefulControllerGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name, ?string $model_namespace = null)
    {
        parent::__construct($name, $model_namespace);
    }

    public function generate()
    {
        $this->generateResourcefulController();
    }

    public function generateResourcefulController()
    {
        $template = str_replace(
            [
                '{{modelNamespace}}',
                '{{modelName}}',
                '{{modelNameSingularLowercase}}',
                '{{modelNamePluralLowercase}}',
            ], [
                $this->model_namespace,
                $this->name,
                strtolower($this->name),
                Str::plural(strtolower($this->name)),
            ],
            $this->getStub('ResourcefulController'),
        );

        return $this->makeFile(app_path('Http/Controllers/Admin/Resourceful/'.$this->name.'Controller.php'), $template);
    }
}
