<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulScaffoldGenerator;
use Illuminate\Console\Command;

class ScaffoldGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:scaffold {name : Model Class (Singular), e.g User, Place, Car, Post}';

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
        $generator = new ResourcefulScaffoldGenerator($this->argument('name'));

        $generator->generate();
    }
}
