<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Src\BlendedConcept\User\Domain\Model\User;
use Src\BlendedConcept\User\Domain\Model\Role;
use Src\BlendedConcept\User\Domain\Model\Permission;
use Illuminate\Database\Seeder;

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


        $user = User::create($data);
        $permission = Permission::pluck('id');
        $role = Role::find(1);
        $role->permissions()->sync($permission);
        $user->roles()->sync(['1']);
    }
}
