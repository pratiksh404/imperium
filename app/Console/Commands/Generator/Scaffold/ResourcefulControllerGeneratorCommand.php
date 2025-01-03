<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulControllerGenerator;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class ResourcefulControllerGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:controller {name : Model Class (Singular), e.g User, Place, Car, Post}';

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
        $generator = new ResourcefulControllerGenerator($this->argument('name'));

        $controller = $generator->generateResourcefulController();
        info('Controller created successfully at ['.$controller.']');
    }
}
