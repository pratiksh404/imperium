<?php

namespace App\Console\Commands\Generator\Scaffold;

use App\Services\Generator\Scaffold\ResourcefulPolicyGenerator;
use Illuminate\Console\Command;

use function Laravel\Prompts\info;

class ResourcefulPolicyGeneratorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:policy {name : Model Class (Singular), e.g User, Place, Car, Post}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate policy compatible with imperium authorization system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $generator = new ResourcefulPolicyGenerator($this->argument('name'));

        $policy = $generator->generateResourcefulPolicy();
        info('Policy created successfully at ['.$policy.']');
    }
}
