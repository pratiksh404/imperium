<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulControllerGenerator;
use App\Traits\Console\NeedsModel;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class ResourcefulControllerGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate resourceful controller';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new ResourcefulControllerGenerator($model, $namespace);

        $controller = $generator->generateResourcefulController();
        info('Controller created successfully at ['.$controller.']');
    }
}
