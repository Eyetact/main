<?php

namespace App\Generators;

use Spatie\Permission\Models\{Role, Permission};
use App\Models\Crud;

class PermissionGenerator
{
    /**
     * Generate new permissions to confg.permissions.permissions(used for peermissios seeder).
     *
     * @param array $request
     * @param int $id
     * @return void
     */
    public function generate(array $request,$id)
    {
        $model = GeneratorUtils::setModelName($request['code'], 'default');
        $modelNameSingular = GeneratorUtils::cleanSingularLowerCase($model);

        $this->insertRoleAndPermissions($modelNameSingular,$id);
    }

    /**
     * remove permissions from confg.permissions.permissions.
     *
     * @param $id $id
     *
     * @return void
     */
    public function remove($id)
    {

        $crud = Crud::find($id);
        $model = GeneratorUtils::setModelName($crud->name, 'default');
        $modelNameSingular = GeneratorUtils::cleanSingularLowerCase($model);
        $this->removeRoleAndPermissions($modelNameSingular);

        $path = config_path('permission.php');

        $newPermissionFile = str_replace($crud->permissions, '', file_get_contents($path));

        file_put_contents($path, $newPermissionFile);
    }

    /**
     * Insert new role & permissions then give an admin that permissions.
     *
     * @param array $request
     * @return void
     */
    protected function insertRoleAndPermissions(string $model,$id)
    {
        $role = Role::find(1);

        Permission::create(['name' => "view.$model" , 'module' => $id , 'guard_name' => 'web']);
        Permission::create(['name' => "create.$model", 'module' => $id , 'guard_name' => 'web']);
        Permission::create(['name' => "edit.$model", 'module' => $id , 'guard_name' => 'web']);
        Permission::create(['name' => "delete.$model", 'module' => $id , 'guard_name' => 'web']);

        $role->givePermissionTo([
            "view.$model",
            "create.$model",
            "edit.$model",
            "delete.$model"
        ]);
    }

    /**
     * remove permissions from database and admin.
     *
     * @param string $model [explicite description]
     *
     * @return void
     */
    protected function removeRoleAndPermissions(string $model)
    {
        $role = Role::findByName('admin');

        $role->revokePermissionTo([
            "$model view",
            "$model create",
            "$model edit",
            "$model delete"
        ]);

        Permission::where('name' , "$model view")->first()->delete();
        Permission::where('name' , "$model create")->first()->delete();
        Permission::where('name' , "$model edit")->first()->delete();
        Permission::where('name' , "$model delete")->first()->delete();


    }
}
