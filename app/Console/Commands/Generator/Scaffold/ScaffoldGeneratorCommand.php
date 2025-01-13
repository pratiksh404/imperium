<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulScaffoldGenerator;
use App\Traits\Console\NeedsModel;
use Illuminate\Console\Command;

class ScaffoldGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate a new resource scaffold';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new ResourcefulScaffoldGenerator($model, $namespace);

        $generator->generate();
    }
}
