<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulRepositoryGenerator;
use App\Traits\Console\NeedsModel;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class ResourcefulRepositoryGeneratorCommand extends Command
{
    use NeedsModel;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate resourceful module repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $selected_model = $this->getModelFromConsole();

        $model = $selected_model->model;
        $namespace = $selected_model->namespace;

        $generator = new ResourcefulRepositoryGenerator($model, $namespace);

        $repository = $generator->generateRepository();
        info('Repository created successfully at ['.$repository.']');

        $interface = $generator->generateInterface();
        info('Interface created successfully ['.$interface.']');
    }
}
