<?php

namespace App\Console\Commands\Authorization;

use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Console\Command;

use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\select;

class GenerateBreadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:bread';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Select Role
        $roles = Role::all();
        if ($roles->isEmpty()) {
            error('No roles found. Please create a role first.');

            return;
        }
        $role_name = select(
            label: 'Generate BREAD authorization for which role?',
            options: $roles->pluck('name')->toArray()
        );

        $role = Role::where('name', $role_name)->first();
        if (! $role) {
            error('Role not found.');

            return;
        }

        // Generate BREAD
        $module_with_no_bread = $role->modules_with_no_bread;
        if (count($module_with_no_bread ?? []) === 0) {
            info('Seems like role '.$role->name.' already has BREAD for all modules.');

            return;
        }

        $module_name = select(
            label: 'Select module to generate BREAD for',
            options: array_keys($module_with_no_bread)
        );

        $model = getModelHavingName($module_name);
        if (! $model) {
            error('Model not found.');

            return;
        }

        Permission::generateBREADForModel($model, $role);
        info('BREAD generated successfully for role '.$role->name.' and module '.$module_name);
    }
}
