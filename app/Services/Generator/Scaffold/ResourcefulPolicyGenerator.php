<?php

namespace App\Services\Generator\Scaffold;

use App\Contracts\Generator\GeneratorInterface;
use App\Services\Generator\Generator;

class ResourcefulPolicyGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function generate()
    {
        $this->generateResourcefulPolicy();
    }

    public function generateResourcefulPolicy()
    {
        $template = str_replace(
            [
                '{{modelNamespace}}',
                '{{modelName}}',
                '{{modelNameLowercase}}',
            ], [
                $this->model_namespace,
                $this->name,
                strtolower($this->name),
            ],
            $this->getStub('ResourcefulPolicy'),
        );

        return $this->makeFile(app_path('Policies/'.$this->name.'Policy.php'), $template);
    }
}
