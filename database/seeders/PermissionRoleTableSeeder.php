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
            ['name' => 'BC Subscriber', 'guard_name' => 'web'],
            ['name' => 'BC Staff', 'guard_name' => 'web'],
            ['name' => 'Teacher', 'guard_name' => 'web'],
            ['name' => 'Organization Admin', 'guard_name' => 'web'],
            ['name' => 'Student', 'guard_name' => 'web'],
        ];
        foreach ($datas as $data) {
            // $role = RoleEloquentModel::create($data);
            // $role->permissions()->sync([25, 26, 27, 28, 29]);
            if ($data['name'] == 'BC Super Admin') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_student',
                        'create_student',
                        'delete_student',
                        'delete_announcement',
                        'edit_announcement',
                        'create_announcement',
                        'access_library',
                        'show_user',
                        'show_role',
                        'show_organization',
                        'show_announcement',
                        'show_announcement',
                        'edit_user',
                        'edit_student',
                        'edit_role',
                        'edit_permission',
                        'edit_organization',
                        'delete_user',
                        'delete_role',
                        'delete_permission',
                        'delete_organization',
                        'create_user',
                        'create_role',
                        'create_permission',
                        'create_organization',
                        'access_user',
                        'access_settings',
                        'access_role',
                        'access_permission',
                        'access_organization',
                        'access_announcement',
                        'access_plan',
                        'access_pagebuilder',
                        'access_system',
                        'access_subscriber',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'BC Subscriber') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_plan',
                        'access_teacherStorybook',
                        'access_resources',
                        'access_viewStudents',
                        'access_reports',
                        'access_playlists',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'BC Staff') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_surveyResults',
                        'access_userSurveys',
                        'access_surveys',
                        'access_storybook',
                        'access_games',
                        'access_books',
                        'access_pathways',
                        'access_rewards',
                        'create_plan',
                        'edit_plan',
                        'delete_plan',
                        'access_student',
                        'create_student',
                        'edit_student',
                        'delete_student',
                        'access_accessibility',
                        'access_accessibilityDevice',
                        'access_disabilityDevice',
                        'access_user',
                        'create_user',
                        'show_user',
                        'edit_user',
                        'delete_user',
                        'access_announcement',
                        'delete_announcement',
                        'edit_announcement',
                        'create_announcement',
                        'access_plan',
                        'access_pagebuilder',
                        'access_library',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'Teacher') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_resources',
                        'access_reports',
                        'access_viewStudents',
                        'access_teacherStorybook',
                        'access_playlists',
                        'acccess_orgClassroom',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'Organization Admin') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_reports',
                        'access_resources',
                        'delete_announcement',
                        'edit_announcement',
                        'show_announcement',
                        'create_announcement',
                        'access_announcement',
                        'access_orgusers',
                        'delete_classroom',
                        'edit_classroom',
                        'create_classroom',
                        'access_classroom',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'Student') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_studentRewards',
                        'access_studentGames',
                        'access_studentStorybook',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            }
        }
    }
}
