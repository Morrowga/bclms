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
                        'show_student',
                        'edit_student',
                        'delete_student',
                        'delete_announcement',
                        'edit_announcement',
                        'create_announcement',
                        'access_library',
                        'access_userMenu',
                        'access_user',
                        'edit_user',
                        'create_user',
                        'show_user',
                        'delete_user',
                        'show_role',
                        'show_organisation',
                        'show_announcement',
                        'show_announcement',
                        'edit_role',
                        'edit_permission',
                        'edit_organisation',
                        'delete_role',
                        'delete_permission',
                        'delete_organisation',
                        'create_role',
                        'create_permission',
                        'create_organisation',
                        'access_setting',
                        'create_setting',
                        'show_setting',
                        'edit_setting',
                        'delete_setting',
                        'access_role',
                        'access_permission',
                        'access_organisation',
                        'access_announcement',
                        'access_plan',
                        'show_plan',
                        'create_plan',
                        'edit_plan',
                        'delete_plan',
                        'access_pagebuilder',
                        'access_system',
                        'access_subscriber',
                        'access_subscription',
                        'edit_subscription',
                        'show_subscription',
                        'delete_subscription',
                        'access_siteTheme',
                        'create_siteTheme',
                        'edit_siteTheme',
                        'delete_siteTheme',
                        'access_exportData',
                        'access_techSupport',
                        'create_techSupport',
                        'edit_techSupport',
                        'delete_techSupport',
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
                        'access_exportData',
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
                        'access_exportData',

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
                        'access_book',
                        'create_book',
                        'edit_book',
                        'show_book',
                        'delete_book',
                        'access_pathway',
                        'create_pathway',
                        'show_pathway',
                        'edit_pathway',
                        'delete_pathway',
                        'access_reward',
                        'create_reward',
                        'edit_reward',
                        'show_reward',
                        'update_reward',
                        'delete_reward',
                        'create_plan',
                        'edit_plan',
                        'delete_plan',
                        'access_student',
                        'create_student',
                        'edit_student',
                        'delete_student',
                        'access_accessibility',
                        'create_accessibility',
                        'show_accessibility',
                        'edit_accessibility',
                        'delete_accessibility',
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
                        'show_game',
                        'access_survey',
                        'show_survey',
                        'delete_survey',
                        'edit_survey',
                        'create_survey',
                        'access_surveyresponses',
                        'create_surveyresponses',
                        'edit_surveyresponses',
                        'delete_surveyresponses',
                        'access_userMenu',
                        'access_exportData',
                        'edit_organisation',
                        'access_subscription',
                        'create_subscription',
                        'access_reports',
                        'access_bookReview',
                        'show_bookReview',
                        'create_bookReview',
                        'edit_bookReview',
                        'delete_bookReview',
                        'access_disability',
                        'create_disability',
                        'edit_disability',
                        'delete_disability',
                        'access_learning',
                        'create_learning',
                        'edit_learning',
                        'delete_learning',
                        'access_theme',
                        'create_theme',
                        'edit_theme',
                        'delete_theme',
                        'access_profilling',
                        'create_profilling'

                    ]
                )->pluck('id');
                $role->permissions()->sync($permission);
            } elseif ($data['name'] == 'Teacher') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_resources',
                        'show_resources',
                        'create_resources',
                        'edit_resources',
                        'delete_resources',
                        'access_reports',
                        'access_exportData',

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
                        'access_exportData',
                        'access_resources',
                        'show_resources',
                        'create_resources',
                        'edit_resources',
                        'delete_resources',
                        'delete_announcement',
                        'edit_announcement',
                        'show_announcement',
                        'create_announcement',
                        'access_announcement',
                        'access_orgusers',
                        'delete_classroom',
                        'show_classroom',
                        'edit_classroom',
                        'create_classroom',
                        'access_classroom',
                        'delete_b2bteacher',
                        'edit_b2bteacher',
                        'create_b2bteacher',
                        'access_b2bteacher',
                        'access_organisationUser',
                        'create_organisationUser',
                        'edit_organisationUser',
                        'update_organisationUser',
                        'delete_organisationUser',
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
            } elseif ($data['name'] == 'Parent') {
                $role = RoleEloquentModel::create($data);
                $permission = PermissionEloquentModel::whereIn(
                    'name',
                    [
                        'access_resources',
                        'show_resources',
                        'create_resources',
                        'edit_resources',
                        'delete_resources',
                        'access_reports',
                        'access_exportData',

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
