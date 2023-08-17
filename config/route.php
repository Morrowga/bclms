<?php

return [
    'dashboard' => 'BlendedConcept/System/Presentation/Resources/index',

    'users' => [
        'index' => 'BlendedConcept/Security/Presentation/Resources/Users/Index',
        'show' => 'BlendedConcept/Security/Presentation/Resources/Users/Show',
    ],

    'userexperiencesurvey' => [
        'index' => 'BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Index',
        'create' => 'BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Create',
        'edit' => 'BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Edit',
        'show' => 'BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Show',
    ],

    'reward' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/Rewards/Index',
        'create' => 'BlendedConcept/StoryBook/Presentation/Resources/Rewards/Create',
        'edit' => 'BlendedConcept/StoryBook/Presentation/Resources/Rewards/Edit',
        'show' => 'BlendedConcept/StoryBook/Presentation/Resources/Rewards/Show',
    ],

    'pathways' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/Pathways/Index',
        'create' => 'BlendedConcept/StoryBook/Presentation/Resources/Pathways/Create',
        'show' => 'BlendedConcept/StoryBook/Presentation/Resources/Pathways/Show'
    ],

    'bookreviews' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/BookReviews/Index'
    ],

    'permissions' => 'BlendedConcept/Security/Presentation/Resources/Permissions/Index',
    'roles' => 'BlendedConcept/Security/Presentation/Resources/Roles/Index',

    'organizations' => [
        'index' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Index',
        'create' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Create',
        'edit' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Edit',
        'show' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Show',
    ],

    'plans' => [
        'index' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Index',
        'create' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Create',
        'edit' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Edit',
        'show' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Show',
        'planorg' => 'BlendedConcept/Organization/Presentation/Resources/PlanForOrg/CreatePlan',

    ],

    'subscriptioninvoice' => [
        'index' => 'BlendedConcept/Organization/Presentation/Resources/SubScriptionInvoice/Index'
    ],

    'disability_device' => [
        'index' => 'BlendedConcept/Student/Presentation/Resources/Disability/Index',
    ],

    'accessibility_device' => [
        'index' => 'BlendedConcept/Student/Presentation/Resources/Accessibility/Index',
        'create' => 'BlendedConcept/Student/Presentation/Resources/Accessibility/Create',
        'edit' => 'BlendedConcept/Student/Presentation/Resources/Accessibility/Edit',
    ],
    'games' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/Games/Index'
    ],
    'books' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/Books/Index'
    ],

    'assign_rewards' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Index',
        'create' => 'BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Create',
        'edit' => 'BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Edit',
    ],

    'survey_results' => [
        'index' => 'BlendedConcept/Survey/Presentation/Resources/SurveyResults/Index',
        'show' => 'BlendedConcept/Survey/Presentation/Resources/SurveyResults/Show',
        'view' => 'BlendedConcept/Survey/Presentation/Resources/SurveyResults/View',
    ],

    'conduct_lessons' => [
        'index' => 'BlendedConcept/Teacher/Presentation/Resources/ConductLessons/Index',
    ],

    'announment' => [
        'index' => 'BlendedConcept/System/Presentation/Resources/Announcements/Index',
        'create' => 'BlendedConcept/System/Presentation/Resources/Announcements/Create',
    ],

    'settings' => 'BlendedConcept/System/Presentation/Resources/Settings/Index',
    'site_theme' => 'BlendedConcept/System/Presentation/Resources/Settings/SiteTheme',

    'support' => [
        'index' => 'BlendedConcept/System/Presentation/Resources/Supports/Index',
    ],

    'login' => 'Auth/Presentation/Resources/Login',
    'verify' => 'Auth/Presentation/Resources/Verify',
    'register' => 'Auth/Presentation/Resources/Register',
    'userprofile' => 'Auth/Presentation/Resources/UserProfile',
    'students' => 'BlendedConcept/Student/Presentation/Resources/Student/Index',
    'teachers' => 'BlendedConcept/Teacher/Presentation/Resources/Teacher/Index',
    'classrooms' => 'BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index',
];
