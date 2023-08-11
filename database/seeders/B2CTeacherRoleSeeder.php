<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\UserEloquentModel;

class B2CTeacherRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Teacher One',
                'organization_id' => null,
                'email_verified_at' => now(),
                'dob' => now(),
                'contact_number' => '1234567890',
                'storage_limit' => 100,
                'is_active' => true,
                'email' => 'teacherone@mail.com',
                'password' => 'password',
            ],
            [
                'name' => 'Teacher Two',
                'organization_id' => null,
                'email_verified_at' => now(),
                'dob' => now(),
                'contact_number' => '1234567890',
                'storage_limit' => 100,
                'is_active' => true,
                'email' => 'teachertwo@mail.com',
                'password' => 'password',
            ],

        ];

        foreach ($users as $user) {
            $userCreate = UserEloquentModel::create($user);

            $userCreate->roles()->sync([2]);
        }
    }
}
