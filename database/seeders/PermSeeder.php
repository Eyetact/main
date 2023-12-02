<?php

namespace Database\Seeders;

use App\Models\Module;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $date = Carbon::now()->format('Y-m-d H:i:s');
        $module = [
            ['name' => 'User', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Role', 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'Permission', 'created_at' => $date, 'updated_at' => $date],
        ];

        $permission = [
            ['name' => 'create.user', 'guard_name' => 'web', 'module' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'edit.user', 'guard_name' => 'web', 'module' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'delete.user', 'guard_name' => 'web', 'module' => 1, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'view.user', 'guard_name' => 'web', 'module' => 1, 'created_at' => $date, 'updated_at' => $date],

            ['name' => 'create.role', 'guard_name' => 'web', 'module' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'edit.role', 'guard_name' => 'web', 'module' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'delete.role', 'guard_name' => 'web', 'module' => 2, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'view.role', 'guard_name' => 'web', 'module' => 2, 'created_at' => $date, 'updated_at' => $date],
            
            ['name' => 'create.permission', 'guard_name' => 'web', 'module' => 3, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'edit.permission', 'guard_name' => 'web', 'module' => 3, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'delete.permission', 'guard_name' => 'web', 'module' => 3, 'created_at' => $date, 'updated_at' => $date],
            ['name' => 'view.permission', 'guard_name' => 'web', 'module' => 3, 'created_at' => $date, 'updated_at' => $date],
        ];
        Module::insert($module);    
        Permission::insert($permission);
        $role = Role::find(1);
        $role->givePermissionTo(Permission::all());
    }
}
