<?php

namespace Database\Seeders;

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
      

        $permission = [
            ['name' => 'create.user', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'edit.user', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'delete.user', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'view.user', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],

            ['name' => 'create.role', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'edit.role', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'delete.role', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'view.role', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            
            ['name' => 'create.permission', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'edit.permission', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'delete.permission', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
            ['name' => 'view.permission', 'guard_name' => 'web',  'created_at' => $date, 'updated_at' => $date],
        ];
           
        Permission::insert($permission);
        $role = Role::find(1);
        $role->givePermissionTo(Permission::all());
    }
}
