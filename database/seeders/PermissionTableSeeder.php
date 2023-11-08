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
                'name' => 'access_organisation',
                'guard_name' => 'web',
                'description' => 'Users can access organisation-related functionalities.',
            ],
            [
                'name' => 'create_organisation',
                'guard_name' => 'web',
                'description' => 'Users can create new organisations for management.',
            ],
            [
                'name' => 'show_organisation',
                'guard_name' => 'web',
                'description' => 'Users can view details about different organisations.',
            ],
            [
                'name' => 'edit_organisation',
                'guard_name' => 'web',
                'description' => 'Users can edit existing organisation settings.',
            ],
            [
                'name' => 'delete_organisation',
                'guard_name' => 'web',
                'description' => 'Users can delete organisations when they are no longer needed.',
            ],
            [
                'name' => 'access_userMenu',
                'guard_name' => 'web',
                'description' => 'Users can access user-menu functionalities and profiles.',
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
                'name' => 'access_subscription',
                'guard_name' => 'web',
                'description' => 'Users can access subscriber-related features and settings.',
            ],
            [
                'name' => 'show_subscription',
                'guard_name' => 'web',
                'description' => 'Users can view subscriber-related features and settings.',
            ],
            [
                'name' => 'create_subscription',
                'guard_name' => 'web',
                'description' => 'Users can create subscriber-related features and settings.',
            ],
            [
                'name' => 'edit_subscription',
                'guard_name' => 'web',
                'description' => 'Users can edit subscriber-related features and settings.',
            ],
            [
                'name' => 'delete_subscription',
                'guard_name' => 'web',
                'description' => 'Users can delete subscriber-related features and settings.',
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
                'name' => 'show_plan',
                'guard_name' => 'web',
                'description' => 'Users can view plans and subscription-related functionalities.',
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
                'name' => 'access_setting',
                'guard_name' => 'web',
                'description' => 'Users can access various application settings and configurations.',
            ],
            [
                'name' => 'create_setting',
                'guard_name' => 'web',
                'description' => 'Users can create various application settings and configurations.',
            ],
            [
                'name' => 'show_setting',
                'guard_name' => 'web',
                'description' => 'Users can view various application settings and configurations.',
            ],
            [
                'name' => 'edit_setting',
                'guard_name' => 'web',
                'description' => 'Users can edit various application settings and configurations.',
            ],
            [
                'name' => 'delete_setting',
                'guard_name' => 'web',
                'description' => 'Users can delete various application settings and configurations.',
            ],
            [
                'name' => 'access_student',
                'guard_name' => 'web',
                'description' => 'Users can access student-related functionalities and profiles.',
            ],
            [
                'name' => 'show_student',
                'guard_name' => 'web',
                'description' => 'Users can view student-related functionalities and profiles.',
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
                'name' => 'show_classroom',
                'guard_name' => 'web',
                'description' => 'Users can show classroom-related functionalities and settings.',
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
                'name' => 'show_accessibility',
                'guard_name' => 'web',
                'description' => 'Users can access accessibility-related features and settings within the application.',
            ],
            [
                'name' => 'edit_accessibility',
                'guard_name' => 'web',
                'description' => 'Users can access accessibility-related features and settings within the application.',
            ],
            [
                'name' => 'delete_accessibility',
                'guard_name' => 'web',
                'description' => 'Users can access accessibility-related features and settings within the application.',
            ],
            [
                'name' => 'create_accessibility',
                'guard_name' => 'web',
                'description' => 'Users can access accessibility-related features and settings within the application.',
            ],


            [
                'name' => 'access_disabilityDevice',
                'guard_name' => 'web',
                'description' => 'Users can access and manage disability devices and related functionalities.',
            ],

            [
                'name' => 'access_disability',
                'guard_name' => 'web',
                'description' => 'Users can access and manage disability type and related functionalities.'
            ],
            [
                'name' => 'create_disability',
                'guard_name' => 'web',
                'description' => 'Users can access and manage disability type and related functionalities.'
            ],
            [
                'name' => 'edit_disability',
                'guard_name' => 'web',
                'description' => 'Users can access and manage disability type and related functionalities.'
            ],
            [
                'name' => 'delete_disability',
                'guard_name' => 'web',
                'description' => 'Users can access and manage disability type and related functionalities.'
            ],

            [
                'name' => 'access_learning',
                'guard_name' => 'web',
                'description' => 'Users can access and manage learning type and related functionalities.'
            ],
            [
                'name' => 'create_learning',
                'guard_name' => 'web',
                'description' => 'Users can access and manage learning type and related functionalities.'
            ],
            [
                'name' => 'edit_learning',
                'guard_name' => 'web',
                'description' => 'Users can access and manage learning type and related functionalities.'
            ],
            [
                'name' => 'delete_learning',
                'guard_name' => 'web',
                'description' => 'Users can access and manage learning type and related functionalities.'
            ],

            [
                'name' => 'access_theme',
                'guard_name' => 'web',
                'description' => 'Users can access and manage theme and related functionalities.'
            ],
            [
                'name' => 'create_theme',
                'guard_name' => 'web',
                'description' => 'Users can access and manage theme and related functionalities.'
            ],
            [
                'name' => 'edit_theme',
                'guard_name' => 'web',
                'description' => 'Users can access and manage theme and related functionalities.'
            ],
            [
                'name' => 'delete_theme',
                'guard_name' => 'web',
                'description' => 'Users can access and manage theme and related functionalities.'
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
                'name' => 'access_book',
                'guard_name' => 'web',
                'description' => 'Users can access books and their configurations within the application.',
            ],
            [
                'name' => 'show_book',
                'guard_name' => 'web',
                'description' => 'Users can view books and their configurations within the application.',
            ],
            [
                'name' => 'create_book',
                'guard_name' => 'web',
                'description' => 'Users can create books and their configurations within the application.',
            ],
            [
                'name' => 'edit_book',
                'guard_name' => 'web',
                'description' => 'Users can edit books and their configurations within the application.',
            ],
            [
                'name' => 'delete_book',
                'guard_name' => 'web',
                'description' => 'Users can delete books and their configurations within the application.',
            ],

            [
                'name' => 'access_pathway',
                'guard_name' => 'web',
                'description' => 'Users can access pathways and their configurations within the application.',
            ],
            [
                'name' => 'create_pathway',
                'guard_name' => 'web',
                'description' => 'Users can create pathways and their configurations within the application.',
            ],
            [
                'name' => 'show_pathway',
                'guard_name' => 'web',
                'description' => 'Users can view pathways and their configurations within the application.',
            ],
            [
                'name' => 'edit_pathway',
                'guard_name' => 'web',
                'description' => 'Users can edit pathways and their configurations within the application.',
            ],
            [
                'name' => 'delete_pathway',
                'guard_name' => 'web',
                'description' => 'Users can delete pathways and their configurations within the application.',
            ],

            [
                'name' => 'access_reward',
                'guard_name' => 'web',
                'description' => 'Users can access rewards and their configurations within the application.',
            ],
            [
                'name' => 'create_reward',
                'guard_name' => 'web',
                'description' => 'Users can create rewards and their configurations within the application.',
            ],
            [
                'name' => 'show_reward',
                'guard_name' => 'web',
                'description' => 'Users can view rewards and their configurations within the application.',
            ],
            [
                'name' => 'edit_reward',
                'guard_name' => 'web',
                'description' => 'Users can edit rewards and their configurations within the application.',
            ],
            [
                'name' => 'update_reward',
                'guard_name' => 'web',
                'description' => 'Users can update rewards and their configurations within the application.',
            ],
            [
                'name' => 'delete_reward',
                'guard_name' => 'web',
                'description' => 'Users can delete rewards and their configurations within the application.',
            ],

            [
                'name' => 'access_mainSubscription',
                'guard_name' => 'web',
                'description' => 'Users can access mainSubscription and their configurations within the application.',
            ],
            [
                'name' => 'access_surveys',
                'guard_name' => 'web',
                'description' => 'Users can access surveys and their configurations within the application.',
            ],
            [
                'name' => 'access_userSurveys',
                'guard_name' => 'web',
                'description' => 'Users can access userSurveys and their configurations within the application.',
            ],
            [
                'name' => 'access_orgusers',
                'guard_name' => 'web',
                'description' => 'Users can access orgusers and their configurations within the application.',
            ],
            [
                'name' => 'access_teacherStorybook',
                'guard_name' => 'web',
                'description' => 'Users can access teacherStorybook and their configurations within the application.',
            ],
            [
                'name' => 'access_viewStudents',
                'guard_name' => 'web',
                'description' => 'Users can access viewStudents and their configurations within the application.',
            ],
            [
                'name' => 'access_reports',
                'guard_name' => 'web',
                'description' => 'Users can access reports and their configurations within the application.',
            ],
            [
                'name' => 'access_playlists',
                'guard_name' => 'web',
                'description' => 'Users can access playlists and their configurations within the application.',
            ],
            [
                'name' => 'access_studentStorybook',
                'guard_name' => 'web',
                'description' => 'Users can access studentStorybook and their configurations within the application.',
            ],
            [
                'name' => 'access_studentGames',
                'guard_name' => 'web',
                'description' => 'Users can access studentGames and their configurations within the application.',
            ],
            [
                'name' => 'access_studentRewards',
                'guard_name' => 'web',
                'description' => 'Users can access studentRewards and their configurations within the application.',
            ],

            [
                'name' => 'access_resources',
                'guard_name' => 'web',
                'description' => 'Users can access resources and their configurations within the application.',
            ],
            [
                'name' => 'create_resources',
                'guard_name' => 'web',
                'description' => 'Users can access resources and their configurations within the application.',
            ],
            [
                'name' => 'show_resources',
                'guard_name' => 'web',
                'description' => 'Users can view resources and their configurations within the application.',
            ],
            [
                'name' => 'edit_resources',
                'guard_name' => 'web',
                'description' => 'Users can edit resources and their configurations within the application.',
            ],
            [
                'name' => 'delete_resources',
                'guard_name' => 'web',
                'description' => 'Users can delete resources and their configurations within the application.',
            ],

            [
                'name' => 'access_orgClassroom',
                'guard_name' => 'web',
                'description' => 'Users can access orgClassroom and their configurations within the application.',
            ],
            [
                'name' => 'access_profillingSurveys',
                'guard_name' => 'web',
                'description' => 'Users can access profilling surveys and their configurations within the application.',
            ],
            [
                'name' => 'access_bcstaffOrganisation',
                'guard_name' => 'web',
                'description' => 'Users can access bcstaff organisation subscription and their configurations within the application.',
            ],
            [
                'name' => 'create_bcstaffOrganisation',
                'guard_name' => 'web',
                'description' => 'Users can create bcstaff organisation subscription surveys and their configurations within the application.',
            ],
            [
                'name' => 'access_bcstaffSubscription',
                'guard_name' => 'web',
                'description' => 'Users can access bcstaff Subscription and their configurations within the application.',
            ],
            [
                'name' => 'create_bcstaffSubscription',
                'guard_name' => 'web',
                'description' => 'Users can create bcstaff Subscription surveys and their configurations within the application.',
            ],
            [
                'name' => 'access_survey',
                'guard_name' => 'web',
                'description' => 'Users can create surveys and their configurations within the application.',
            ],
            [
                'name' => 'show_survey',
                'guard_name' => 'web',
                'description' => 'Users can view surveys and their configurations within the application.',
            ],
            [
                'name' => 'create_survey',
                'guard_name' => 'web',
                'description' => 'Users can create surveys and their configurations within the application.',
            ],
            [
                'name' => 'edit_survey',
                'guard_name' => 'web',
                'description' => 'Users can update surveys and their configurations within the application.',
            ],
            [
                'name' => 'delete_survey',
                'guard_name' => 'web',
                'description' => 'Users can delete surveys.',
            ],
            [
                'name' => 'access_game',
                'guard_name' => 'web',
                'description' => 'Users can create games and their configurations within the application.',
            ],
            [
                'name' => 'create_game',
                'guard_name' => 'web',
                'description' => 'Users can create games and their configurations within the application.',
            ],
            [
                'name' => 'show_game',
                'guard_name' => 'web',
                'description' => 'Users can view games and their configurations within the application.',
            ],
            [
                'name' => 'edit_game',
                'guard_name' => 'web',
                'description' => 'Users can update games and their configurations within the application.',
            ],
            [
                'name' => 'delete_game',
                'guard_name' => 'web',
                'description' => 'Users can delete games.',
            ],
            [
                'name' => 'access_playlist',
                'guard_name' => 'web',
                'description' => 'Users can create playlists and their configurations within the application.',
            ],
            [
                'name' => 'show_playlist',
                'guard_name' => 'web',
                'description' => 'Users can create playlists and their configurations within the application.',
            ],
            [
                'name' => 'create_playlist',
                'guard_name' => 'web',
                'description' => 'Users can create playlists and their configurations within the application.',
            ],
            [
                'name' => 'edit_playlist',
                'guard_name' => 'web',
                'description' => 'Users can update playlists and their configurations within the application.',
            ],
            [
                'name' => 'delete_playlist',
                'guard_name' => 'web',
                'description' => 'Users can delete playlists.',
            ],
            [
                'name' => 'access_b2bteacher',
                'guard_name' => 'web',
                'description' => 'Users can create b2b teacher and their configurations within the application.',
            ],
            [
                'name' => 'create_b2bteacher',
                'guard_name' => 'web',
                'description' => 'Users can create b2b teacher and their configurations within the application.',
            ],
            [
                'name' => 'edit_b2bteacher',
                'guard_name' => 'web',
                'description' => 'Users can update b2b teacher and their configurations within the application.',
            ],
            [
                'name' => 'delete_b2bteacher',
                'guard_name' => 'web',
                'description' => 'Users can delete b2b teacher.',
            ],
            [
                'name' => 'access_surveyresponses',
                'guard_name' => 'web',
                'description' => 'Users can access SurveyResponses and their configurations within the application.',
            ],
            [
                'name' => 'create_surveyresponses',
                'guard_name' => 'web',
                'description' => 'Users can create survey responses and their configurations within the application.',
            ],
            [
                'name' => 'edit_surveyresponses',
                'guard_name' => 'web',
                'description' => 'Users can update survey responses and their configurations within the application.',
            ],
            [
                'name' => 'delete_surveyresponses',
                'guard_name' => 'web',
                'description' => 'Users can delete survey responses.',
            ],

            [
                'name' => 'access_siteTheme',
                'guard_name' => 'web',
                'description' => 'Users can access site theme and their configurations within the application.',
            ],
            [
                'name' => 'create_siteTheme',
                'guard_name' => 'web',
                'description' => 'Users can create site theme and their configurations within the application.',
            ],
            [
                'name' => 'edit_siteTheme',
                'guard_name' => 'web',
                'description' => 'Users can update site theme and their configurations within the application.',
            ],
            [
                'name' => 'delete_siteTheme',
                'guard_name' => 'web',
                'description' => 'Users can delete site theme.',
            ],
            [
                'name' => 'access_exportData',
                'guard_name' => 'web',
                'description' => 'Users can access exportData',
            ],

            [
                'name' => 'access_techSupport',
                'guard_name' => 'web',
                'description' => 'Users can access technical support and their configurations within the application.',
            ],
            [
                'name' => 'create_techSupport',
                'guard_name' => 'web',
                'description' => 'Users can create technical support and their configurations within the application.',
            ],
            [
                'name' => 'edit_techSupport',
                'guard_name' => 'web',
                'description' => 'Users can update technical support and their configurations within the application.',
            ],
            [
                'name' => 'delete_techSupport',
                'guard_name' => 'web',
                'description' => 'Users can delete technical support.',
            ],

            [
                'name' => 'access_bookReview',
                'guard_name' => 'web',
                'description' => 'Users can access book review and their configurations within the application.',
            ],
            [
                'name' => 'show_bookReview',
                'guard_name' => 'web',
                'description' => 'Users can access book review and their configurations within the application.',
            ],
            [
                'name' => 'create_bookReview',
                'guard_name' => 'web',
                'description' => 'Users can create book review and their configurations within the application.',
            ],
            [
                'name' => 'edit_bookReview',
                'guard_name' => 'web',
                'description' => 'Users can update book review and their configurations within the application.',
            ],
            [
                'name' => 'delete_bookReview',
                'guard_name' => 'web',
                'description' => 'Users can delete book review.',
            ],
            [
                'name' => 'access_profilling',
                'guard_name' => 'web',
                'description' => 'Users can create surveys and their configurations within the application.',
            ],
            [
                'name' => 'create_profilling',
                'guard_name' => 'web',
                'description' => 'Users can view surveys and their configurations within the application.',
            ],

            [
                'name' => 'access_organisationUser',
                'guard_name' => 'web',
                'description' => 'Users can access organisation user and their configurations within the application.',
            ],
            [
                'name' => 'show_organisationUser',
                'guard_name' => 'web',
                'description' => 'Users can access organisation user and their configurations within the application.',
            ],
            [
                'name' => 'create_organisationUser',
                'guard_name' => 'web',
                'description' => 'Users can create organisation user and their configurations within the application.',
            ],
            [
                'name' => 'edit_organisationUser',
                'guard_name' => 'web',
                'description' => 'Users can update organisation user and their configurations within the application.',
            ],
            [
                'name' => 'delete_organisationUser',
                'guard_name' => 'web',
                'description' => 'Users can delete organisation user.',
            ],


            [
                'name' => 'access_teacherBook',
                'guard_name' => 'web',
                'description' => 'Users can access teacherBooks and their configurations within the application.',
            ],
            [
                'name' => 'show_teacherBook',
                'guard_name' => 'web',
                'description' => 'Users can view teacherBooks and their configurations within the application.',
            ],
            [
                'name' => 'create_teacherBook',
                'guard_name' => 'web',
                'description' => 'Users can create teacherBooks and their configurations within the application.',
            ],
            [
                'name' => 'edit_teacherBook',
                'guard_name' => 'web',
                'description' => 'Users can edit teacherBooks and their configurations within the application.',
            ],
            [
                'name' => 'delete_teacherBook',
                'guard_name' => 'web',
                'description' => 'Users can delete teacherBooks and their configurations within the application.',
            ],

            [
                'name' => 'access_teacherStudent',
                'guard_name' => 'web',
                'description' => 'Users can access teacherStudents and their configurations within the application.',
            ],
            [
                'name' => 'access_assignStudent',
                'guard_name' => 'web',
                'description' => 'Users can access assign student and their configurations within the application.',
            ],
            [
                'name' => 'access_createVersion',
                'guard_name' => 'web',
                'description' => 'Users can create book version and their configurations within the application.',
            ],
            [
                'name' => 'show_teacherStudent',
                'guard_name' => 'web',
                'description' => 'Users can view teacherStudents and their configurations within the application.',
            ],
            [
                'name' => 'create_teacherStudent',
                'guard_name' => 'web',
                'description' => 'Users can create teacherStudents and their configurations within the application.',
            ],
            [
                'name' => 'edit_teacherStudent',
                'guard_name' => 'web',
                'description' => 'Users can edit teacherStudents and their configurations within the application.',
            ],
            [
                'name' => 'delete_teacherStudent',
                'guard_name' => 'web',
                'description' => 'Users can delete teacherStudents and their configurations within the application.',
            ],
            [
                'name' => 'access_studentAssign',
                'guard_name' => 'web',
                'description' => 'Users has access student assign and their configurations within the application.',
            ],
            [
                'name' => 'access_studentPathway',
                'guard_name' => 'web',
                'description' => 'Users has access student pathway and their configurations within the application.',
            ],
            [
                'name' => 'access_studentPlaylist',
                'guard_name' => 'web',
                'description' => 'Users has access student playlist and their configurations within the application.',
            ],

        ];
        foreach ($permissions as $permission) {
            PermissionEloquentModel::create($permission);
        }
    }
}
