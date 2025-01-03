<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulRepositoryGenerator;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class ResourcefulRepositoryGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:repository {name : Model Class (Singular), e.g User, Place, Car, Post}';

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
        $generator = new ResourcefulRepositoryGenerator($this->argument('name'));

        $repository = $generator->generateRepository();
        info('Repository created successfully at ['.$repository.']');

        $interface = $generator->generateInterface();
        info('Interface created successfully ['.$interface.']');
    }
}
