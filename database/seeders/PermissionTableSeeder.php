<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Src\BlendedConcept\Security\Infrastructure\EloquentModels\PermissionEloquentModel;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $permissions = [
            [
                'name' => 'create_permission',
                'guard_name' => 'web',
                'description' => 'Users can create new permissions for access control customization.',
            ],
            [
                'name' => 'edit_permission',
                'guard_name' => 'web',
                'description' => 'Users can edit existing permission settings.',
            ],
            [
                'name' => 'delete_permission',
                'guard_name' => 'web',
                'description' => 'Users can delete permissions that are no longer needed.',
            ],
            [
                'name' => 'access_permission',
                'guard_name' => 'web',
                'description' => 'Users can view and manage permission-related settings.',
            ],
            [
                'name' => 'create_role',
                'guard_name' => 'web',
                'description' => 'Users can create new roles for organizing permissions.',
            ],
            [
                'name' => 'edit_role',
                'guard_name' => 'web',
                'description' => 'Users can edit existing role definitions.',
            ],
            [
                'name' => 'show_role',
                'guard_name' => 'web',
                'description' => 'Users can view details about different roles within the application.',
            ],
            [
                'name' => 'delete_role',
                'guard_name' => 'web',
                'description' => 'Users can delete roles when they are no longer necessary.',
            ],
            [
                'name' => 'access_role',
                'guard_name' => 'web',
                'description' => 'Users can view and manage roles and their permissions.',
            ],
            [
                'name' => 'access_organization',
                'guard_name' => 'web',
                'description' => 'Users can access organization-related functionalities.',
            ],
            [
                'name' => 'create_organization',
                'guard_name' => 'web',
                'description' => 'Users can create new organizations for management.',
            ],
            [
                'name' => 'show_organization',
                'guard_name' => 'web',
                'description' => 'Users can view details about different organizations.',
            ],
            [
                'name' => 'edit_organization',
                'guard_name' => 'web',
                'description' => 'Users can edit existing organization settings.',
            ],
            [
                'name' => 'delete_organization',
                'guard_name' => 'web',
                'description' => 'Users can delete organizations when they are no longer needed.',
            ],
            [
                'name' => 'access_user',
                'guard_name' => 'web',
                'description' => 'Users can access user-related functionalities and profiles.',
            ],
            [
                'name' => 'create_user',
                'guard_name' => 'web',
                'description' => 'Users can create new user accounts for registration.',
            ],
            [
                'name' => 'show_user',
                'guard_name' => 'web',
                'description' => 'Users can view user account details.',
            ],
            [
                'name' => 'edit_user',
                'guard_name' => 'web',
                'description' => 'Users can edit user account settings.',
            ],
            [
                'name' => 'delete_user',
                'guard_name' => 'web',
                'description' => 'Users can delete user accounts.',
            ],
            [
                'name' => 'access_announcement',
                'guard_name' => 'web',
                'description' => 'Users can access announcement-related features and settings.',
            ],
            [
                'name' => 'create_announcement',
                'guard_name' => 'web',
                'description' => 'Users can create new announcements for communication.',
            ],
            [
                'name' => 'show_announcement',
                'guard_name' => 'web',
                'description' => 'Users can view announcement details and content.',
            ],
            [
                'name' => 'edit_announcement',
                'guard_name' => 'web',
                'description' => 'Users can edit existing announcements.',
            ],
            [
                'name' => 'delete_announcement',
                'guard_name' => 'web',
                'description' => 'Users can delete announcements when they are no longer needed.',
            ],
            [
                'name' => 'access_library',
                'guard_name' => 'web',
                'description' => 'Users can access library-related functionalities and resources.',
            ],
            [
                'name' => 'access_subscriber',
                'guard_name' => 'web',
                'description' => 'Users can access subscriber-related features and settings.',
            ],
            [
                'name' => 'access_system',
                'guard_name' => 'web',
                'description' => 'Users can access and manage system-related settings.',
            ],
            [
                'name' => 'access_pagebuilder',
                'guard_name' => 'web',
                'description' => 'Users can access the page builder functionality for creating pages.',
            ],
            [
                'name' => 'access_plan',
                'guard_name' => 'web',
                'description' => 'Users can access plans and subscription-related functionalities.',
            ],
            [
                'name' => 'create_plan',
                'guard_name' => 'web',
                'description' => 'Users can create new subscription plans.',
            ],
            [
                'name' => 'edit_plan',
                'guard_name' => 'web',
                'description' => 'Users can edit existing subscription plans.',
            ],
            [
                'name' => 'delete_plan',
                'guard_name' => 'web',
                'description' => 'Users can delete subscription plans when necessary.',
            ],
            [
                'name' => 'access_settings',
                'guard_name' => 'web',
                'description' => 'Users can access various application settings and configurations.',
            ],
            [
                'name' => 'access_student',
                'guard_name' => 'web',
                'description' => 'Users can access student-related functionalities and profiles.',
            ],
            [
                'name' => 'create_student',
                'guard_name' => 'web',
                'description' => 'Users can create new student profiles.',
            ],
            [
                'name' => 'edit_student',
                'guard_name' => 'web',
                'description' => 'Users can edit student profiles and information.',
            ],
            [
                'name' => 'delete_student',
                'guard_name' => 'web',
                'description' => 'Users can delete student profiles and related data.',
            ],
            [
                'name' => 'access_teacher',
                'guard_name' => 'web',
                'description' => 'Users can access teacher-related functionalities and profiles.',
            ],
            [
                'name' => 'create_teacher',
                'guard_name' => 'web',
                'description' => 'Users can create new teacher profiles.',
            ],
            [
                'name' => 'edit_teacher',
                'guard_name' => 'web',
                'description' => 'Users can edit teacher profiles and information.',
            ],
            [
                'name' => 'delete_teacher',
                'guard_name' => 'web',
                'description' => 'Users can delete teacher profiles and related data.',
            ],
            [
                'name' => 'access_classroom',
                'guard_name' => 'web',
                'description' => 'Users can access classroom-related functionalities and settings.',
            ],
            [
                'name' => 'create_classroom',
                'guard_name' => 'web',
                'description' => 'Users can create new classroom environments.',
            ],
            [
                'name' => 'edit_classroom',
                'guard_name' => 'web',
                'description' => 'Users can edit classroom settings and information.',
            ],
            [
                'name' => 'delete_classroom',
                'guard_name' => 'web',
                'description' => 'Users can delete classroom environments when necessary.',
            ],

            // Added on 8/21/23
            [
                'name' => 'access_accessibility',
                'guard_name' => 'web',
                'description' => 'Users can access accessibility-related features and settings within the application.',
            ],
            [
                'name' => 'access_disabilityDevice',
                'guard_name' => 'web',
                'description' => 'Users can access and manage disability devices and related functionalities.',
            ],
            [
                'name' => 'access_accessibilityDevice',
                'guard_name' => 'web',
                'description' => 'Users can access accessibility devices and their configurations within the application.',
            ],
            //9/1/2023
            [
                'name' => 'access_storybook',
                'guard_name' => 'web',
                'description' => 'Users can access storybook and their configurations within the application.',
            ],
            [
                'name' => 'access_games',
                'guard_name' => 'web',
                'description' => 'Users can access games and their configurations within the application.',
            ],
            [
                'name' => 'access_books',
                'guard_name' => 'web',
                'description' => 'Users can access books and their configurations within the application.',
            ],
            [
                'name' => 'access_pathways',
                'guard_name' => 'web',
                'description' => 'Users can access pathways and their configurations within the application.'
            ],
            [
                'name' => 'access_rewards',
                'guard_name' => 'web',
                'description' => 'Users can access rewards and their configurations within the application.'
            ],
            [
                'name' => 'access_mainSubscription',
                'guard_name' => 'web',
                'description' => 'Users can access mainSubscription and their configurations within the application.'
            ],
            [
                'name' => 'access_subscription',
                'guard_name' => 'web',
                'description' => 'Users can access subscription and their configurations within the application.'
            ],
            [
                'name' => 'access_surveys',
                'guard_name' => 'web',
                'description' => 'Users can access surveys and their configurations within the application.'
            ],
            [
                'name' => 'access_userSurveys',
                'guard_name' => 'web',
                'description' => 'Users can access userSurveys and their configurations within the application.'
            ],
            [
                'name' => 'access_surveyResults',
                'guard_name' => 'web',
                'description' => 'Users can access surveyResults and their configurations within the application.'
            ],
            [
                'name' => 'access_orgusers',
                'guard_name' => 'web',
                'description' => 'Users can access orgusers and their configurations within the application.'
            ],
            [
                'name' => 'access_teacherStorybook',
                'guard_name' => 'web',
                'description' => 'Users can access teacherStorybook and their configurations within the application.'
            ],
            [
                'name' => 'access_viewStudents',
                'guard_name' => 'web',
                'description' => 'Users can access viewStudents and their configurations within the application.'
            ],
            [
                'name' => 'access_reports',
                'guard_name' => 'web',
                'description' => 'Users can access reports and their configurations within the application.'
            ],
            [
                'name' => 'access_playlists',
                'guard_name' => 'web',
                'description' => 'Users can access playlists and their configurations within the application.'
            ],
            [
                'name' => 'access_studentStorybook',
                'guard_name' => 'web',
                'description' => 'Users can access studentStorybook and their configurations within the application.'
            ],
            [
                'name' => 'access_studentGames',
                'guard_name' => 'web',
                'description' => 'Users can access studentGames and their configurations within the application.'
            ],
            [
                'name' => 'access_studentRewards',
                'guard_name' => 'web',
                'description' => 'Users can access studentRewards and their configurations within the application.'
            ],
            [
                'name' => 'access_resources',
                'guard_name' => 'web',
                'description' => 'Users can access resources and their configurations within the application.'
            ],
            [
                'name' => 'access_orgClassroom',
                'guard_name' => 'web',
                'description' => 'Users can access orgClassroom and their configurations within the application.'
            ],
        ];
        foreach ($permissions as $permission) {
            PermissionEloquentModel::create($permission);
        }
    }
}
