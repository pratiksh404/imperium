<?php

namespace App\Services\Generator\Scaffold;

use App\Contracts\Imperium\Generator\GeneratorInterface;
use App\Services\Generator\Generator;
use Illuminate\Support\Str;

class ResourcefulVueComponentGenerator extends Generator implements GeneratorInterface
{
    public function __construct(string $name)
    {
        parent::__construct($name);
    }

    public function generate()
    {
        // Form Component
        $this->generateModuleForm();
        // Index Component
        $this->generateModuleIndex();
    }

    public function generateModuleIndex()
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowercase}}',
            ],
            [
                $this->name,
                Str::plural(strtolower($this->name)),
            ],
            $this->getStub('Index'),
        );

        return $this->makeFile(resource_path('js/Pages/Admin/Modules/'.$this->name.'/Index.vue'), $template);
    }

    public function generateModuleForm()
    {
        $template = str_replace(
            [
                '{{modelName}}',
            ],
            [
                $this->name,
            ],
            $this->getStub('Form'),
        );

        return $this->makeFile(resource_path('js/Components/Form/'.$this->name.'/Form.vue'), $template);
    }
}
