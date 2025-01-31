<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Group;
use App\Models\Permission;
use Illuminate\Support\Facades\Route;

class GenerateGroupsPermissions extends Command
{
    protected $signature = 'permissions:generate';
    protected $description = 'Generate groups and permissions based on route names';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Generating groups and permissions...');
        $routes = Route::getRoutes();

        foreach ($routes as $route) {
            $key = $route->getName();

            if ($key && !str_starts_with($key, 'generated::') && $key !== 'storage.local') {
                $name = ucfirst(str_replace('.', '-', $key));
                $prefix = explode('.', $key)[0];

                // Check if the group exists, if not create it
                $group = Group::firstOrCreate(['name' => $prefix]);

                // Check if the permission already exists to avoid duplicates
                Permission::firstOrCreate([
                    'key' => $key,
                    'name' => $name,
                    'group_id' => $group->id,
                ]);
            }
        }

        $this->info('Groups and permissions have been successfully generated.');
        return Command::SUCCESS;
    }
}
