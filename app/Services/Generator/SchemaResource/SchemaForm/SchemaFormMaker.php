<?php

namespace App\Services\Generator\SchemaResource\SchemaForm;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class SchemaFormMaker
{
    public FormRequest $request;
    public string $module_name;
    public function __construct(string $module_name)
    {
        $this->module_name = $module_name;

        $requestFileName = Str::studly($module_name) . 'Request';

        if (!isset(getFilesWithPaths(app_path('Http/Requests'))[$requestFileName])) {
            throw new \Exception('Request file not found');
        } else {
            $this->request = (new (getFilesWithPaths(app_path('Http/Requests'))[$requestFileName]));
        }
    }

    public static function make(string $module_name): self
    {
        return new self($module_name);
    }

    public function form()
    {
        return $this->request;
    }
}
