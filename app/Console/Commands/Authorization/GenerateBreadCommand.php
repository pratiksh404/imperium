<?php

namespace App\Console\Commands\Authorization;

use App\Models\Admin\Permission;
use App\Models\Admin\Role;
use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\error;
use function Laravel\Prompts\info;
use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\note;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

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
            $this->handleNoRoleFound();
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

        $module_names = multiselect(
            label: 'Select module to generate BREAD for',
            options: array_keys($module_with_no_bread)
        );

        foreach ($module_names as $module_name) {
            $model = getModelHavingName($module_name);
            if (! $model) {
                error('Model not found.');

                // If last iteration, then return
                if ($module_name === end($module_names)) {
                    return;
                }

                continue;
            }

            info('Select BREAD for module '.$module_name.' and role '.$role->name);
            $active_breads = multiselect(
                label: 'Authorized BREAD',
                options: [
                    Permission::BROWSE => 'Browse',
                    Permission::READ => 'Read',
                    Permission::EDIT => 'Edit',
                    Permission::ADD => 'Add',
                    Permission::DELETE => 'Delete',
                ],
                default: Permission::BREAD
            );

            Permission::generateBREADForModel($model, $role, $active_breads);

            info('BREAD generated successfully for role '.$role->name.' and module '.$module_name);
        }
    }

    private function handleNoRoleFound()
    {
        error('No roles found. Please create a role first.');
        $createRole = confirm('Do you create role instead ?');

        if ($createRole) {
            $name_of_role_to_be_created = text('Enter the name of the role to be created');
            if (! $name_of_role_to_be_created) {
                error('Role name is required.');

                return;
            }
            $data = [
                'name' => $name_of_role_to_be_created,
            ];

            $createRole = Role::create($data);
            note('Role created successfully: '.$createRole->name);
            $this->handle();
        } else {
            return;
        }
    }
}
