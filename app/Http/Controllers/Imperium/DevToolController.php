<?php

namespace App\Http\Controllers\Imperium;

use App\Http\Controllers\Controller;

class DevToolController extends Controller
{
    public function migration_generator()
    {
        return inertia('Admin/Modules/DevTools/MigrationGenerator');
    }
}
