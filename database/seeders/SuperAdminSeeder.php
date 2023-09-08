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

        /**
         * Get the ID of the super admin role.
         *
         * This function retrieves the ID of the super admin role by querying the database for a role with the specified name
         * (usually configured in the 'userrole.bcsuperadmin' configuration). It then extracts the ID of the first matching
         * role using the 'pluck' method.
         *
         * @return int|null The ID of the super admin role if found, or null if no matching role is found.
         * author @hareom284
         */


        $super_admin_roles_id = RoleEloquentModel::where('name', config('userrole.bcsuperadmin'))
            ->pluck('id')
            ->first();

        $data = [
            'id' => 1,
            'role_id' => $super_admin_roles_id,
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('password'),
            'contact_number' => '9951613400',
            'status' => 'ACTIVE',
            'email_verification_send_on' => Carbon::now(),
            'profile_pic' => "images/profile/profilefive.png",
        ];
        $user = UserEloquentModel::create($data);
    }
}
