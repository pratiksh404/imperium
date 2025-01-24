<?php

namespace App\Services\Generator\Scaffold;

use App\Contracts\Imperium\Generator\GeneratorInterface;
use App\Services\Generator\Generator;

class ResourcefulModelGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function generate()
    {
        $this->generateResourcefulModel();
    }

    public function generateResourcefulModel()
    {
        $template = str_replace(
            [
                '{{modelName}}',
            ], [
                $this->name,
            ],
            $this->getStub('ResourcefulModel'),
        );

        return $this->makeFile(app_path('Models/Admin/'.$this->name.'.php'), $template);
    }
}
