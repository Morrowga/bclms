<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\RoleEloquentModel;


class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            ['name' => 'BC Super Admin', 'guard_name' => 'web'],
            ['name' => "BC Subscriber", "guard_name" => "web"],
        ];
        foreach ($datas as $data) {
            $role = RoleEloquentModel::create($data);
            $role->permissions()->sync([25, 26, 27, 28, 29]);
        }

        $staffPermission = RoleEloquentModel::whereIn('name', ['create_announcement', 'edit_announcement', 'delete_announcement','access_announcement','show_announcement'])->pluck('id');
        $role = RoleEloquentModel::create(["name" => "BC Staff", "guard_name" => "web"]);
        $role->permissions()->sync($staffPermission);
    }
}
