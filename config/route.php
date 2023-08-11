<?php

return [
    'dashboard' => 'BlendedConcept/System/Presentation/Resources/index',

    'users' => [
        'index' => 'BlendedConcept/Security/Presentation/Resources/Users/Index',
        'show' => 'BlendedConcept/Security/Presentation/Resources/Users/Show',
    ],

    'userexperiencesurvey' => [
        'index' => 'BlendedConcept/Security/Presentation/Resources/UserExperienceSurvey/Index',
        'create' => 'BlendedConcept/Security/Presentation/Resources/UserExperienceSurvey/Survey/Create',
        'show' => 'BlendedConcept/Security/Presentation/Resources/UserExperienceSurvey/Survey/show',
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
    ],

    'disability_device' => [
        'index' => 'BlendedConcept/Student/Presentation/Resources/Disability/Index',
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
