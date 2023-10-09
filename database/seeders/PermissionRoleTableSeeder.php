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
            ['name' => 'Organisation Admin', 'guard_name' => 'web'],
            ['name' => 'Student', 'guard_name' => 'web'],
            ['name' => 'Parent', 'guard_name' => 'web'],
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
                        'show_organisation',
                        'show_announcement',
                        'show_announcement',
                        'edit_user',
                        'edit_student',
                        'edit_role',
                        'edit_permission',
                        'edit_organisation',
                        'delete_user',
                        'delete_role',
                        'delete_permission',
                        'delete_organisation',
                        'create_user',
                        'create_role',
                        'create_permission',
                        'create_organisation',
                        'access_user',
                        'access_settings',
                        'access_role',
                        'access_permission',
                        'access_organisation',
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
            } elseif ($data['name'] == 'Parent') {
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
                        'access_userSurveys',
                        'access_profillingSurveys',
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
                        'access_bcstaffOrganisation',
                        'access_bcstaffSubscription',
                        'access_game',
                        'delete_game',
                        'edit_game',
                        'create_game',
                        'access_survey',
                        'delete_survey',
                        'edit_survey',
                        'create_survey',
                        'access_surveyresponses',
                        'create_surveyresponses',
                        'edit_surveyresponses',
                        'delete_surveyresponses'
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
                        'access_orgClassroom',
                        'access_playlist',
                        'delete_playlist',
                        'edit_playlist',
                        'create_playlist',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'Organisation Admin') {
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
                        'delete_b2bteacher',
                        'edit_b2bteacher',
                        'create_b2bteacher',
                        'access_b2bteacher',
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
            } elseif ($data['name'] == 'Parent'){
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_resources',
                        'access_reports',
                        'access_viewStudents',
                        'access_teacherStorybook',
                        'access_playlists',
                        'access_orgClassroom',
                        'access_playlist',
                        'delete_playlist',
                        'edit_playlist',
                        'create_playlist',
                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            }
        }
    }
}
