<?php

return [
    'dashboard' => 'BlendedConcept/System/Presentation/Resources/index',

    'users' => [
        'index' => 'BlendedConcept/Security/Presentation/Resources/Users/Index',
        'show' => 'BlendedConcept/Security/Presentation/Resources/Users/Show',
     ],
    'permissions' => 'BlendedConcept/Security/Presentation/Resources/Permissions/Index',
    'roles' => 'BlendedConcept/Security/Presentation/Resources/Roles/Index',
    'organizations' => [
       'index' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Index',
       'show' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Show',
    ],

    'plans' => [
        'index' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Index',
        'create' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Create',
        'edit' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Edit',
        'show' => 'BlendedConcept/Organization/Presentation/Resources/Plans/Show',
     ],

     'announment' => [
        'index' => 'BlendedConcept/System/Presentation/Resources/Announcements/Index',
        'create' => 'BlendedConcept/System/Presentation/Resources/Announcements/Create',
        'edit' => 'BlendedConcept/System/Presentation/Resources/Announcements/Edit',
        'show' => 'BlendedConcept/System/Presentation/Resources/Announcements/Show',
     ],

    'settings' => 'BlendedConcept/System/Presentation/Resources/Settings/Index',
    'login'   => 'Auth/Presentation/Resources/Login',
    'verify' => 'Auth/Presentation/Resources/Verify',
    'register' => 'Auth/Presentation/Resources/Register',
    'userprofile' => 'Auth/Presentation/Resources/UserProfile',
    'students' => "BlendedConcept/Student/Presentation/Resources/Student/Index",
    'teachers' => "BlendedConcept/Teacher/Presentation/Resources/Teacher/Index",
    "classrooms" => "BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index"
];

