<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\RoleEloquentModel;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "id"  => 1,
            "organization_id" => null,
            "name"    => "Super Admin",
            "dob"      => Carbon::now(),
            "email"     => "superadmin@mail.com",
            "password"       => bcrypt('password'),
            "contact_number"    => "09951613400",
            "storage_limit"     => "0",
            "is_active"         => 1,
            "trial_end_at"      => Carbon::now(),
            "email_verified_at" => Carbon::now(),
            "remember_token" => null,
        ];


        $user = UserEloquentModel::create($data);
        $permission = PermissionEloquentModel::whereNotIn(
            'name',
            [
                'create_announcement',
                'edit_announcement',
                'delete_announcement',
                'access_student',
                'create_student',
                'delete_student',
                'access_teacher',
                'create_teacher',
                'delete_teacher',
                'access_classroom',
                'create_classroom',
                'delete_classroom',
            ]
        )->pluck('id');
        $role = RoleEloquentModel::find(1);
        $role->permissions()->sync($permission);
        $user->roles()->sync(['1']);
    }
}
