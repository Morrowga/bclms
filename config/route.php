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
        'show' => 'BlendedConcept/StoryBook/Presentation/Resources/Pathways/Show',
    ],

    'bookreviews' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/BookReviews/Index',
    ],

    'permissions' => 'BlendedConcept/Security/Presentation/Resources/Permissions/Index',
    'roles' => 'BlendedConcept/Security/Presentation/Resources/Roles/Index',

    'roles-create' => 'BlendedConcept/Security/Presentation/Resources/Roles/Create',
    'roles-edit' => 'BlendedConcept/Security/Presentation/Resources/Roles/Edit',

    'organizations' => [
        'index' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Index',
        'create' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Create',
        'edit' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Edit',
        'show' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Show',
    ],

    'plans' => [
        'index' => 'BlendedConcept/Finance/Presentation/Resources/Plans/Index',
        'create' => 'BlendedConcept/Finance/Presentation/Resources/Plans/Create',
        'edit' => 'BlendedConcept/Finance/Presentation/Resources/Plans/Edit',
        'show' => 'BlendedConcept/Finance/Presentation/Resources/Plans/Show',
        'planorg' => 'BlendedConcept/Finance/Presentation/Resources/PlanForOrg/CreatePlan',
    ],

    'subscriptioninvoice' => [
        'index' => 'BlendedConcept/Finance/Presentation/Resources/SubScriptionInvoice/Index',
    ],

    'disability_type' => [
        'index' => 'BlendedConcept/Disability/Presentation/Resources/Disability/Index',
    ],

    'accessibility_device' => [
        'index' => 'BlendedConcept/Disability/Presentation/Resources/Accessibility/Index',
        'create' => 'BlendedConcept/Disability/Presentation/Resources/Accessibility/Create',
        'edit' => 'BlendedConcept/Disability/Presentation/Resources/Accessibility/Edit',
    ],
    'games' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/Games/Index',
    ],
    'books' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/Books/Index',
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
        'index' => 'BlendedConcept/ClassRoom/Presentation/Resources/ConductLessons/Index',
        'show' => 'BlendedConcept/ClassRoom/Presentation/Resources/ConductLessons/Show',
    ],

    'view_students' => [
        'index' => 'BlendedConcept/Student/Presentation/Resources/ViewStudents/Index',
        'create' => 'BlendedConcept/Student/Presentation/Resources/ViewStudents/Create',
        'edit' => 'BlendedConcept/Student/Presentation/Resources/ViewStudents/Edit',
        'show' => 'BlendedConcept/Student/Presentation/Resources/ViewStudents/Show',
    ],

    'learning_activities' => [
        'index' => 'BlendedConcept/ClassRoom/Presentation/Resources/LearningActivities/Index',
    ],

    'profilling_survey' => [
        'index' => 'BlendedConcept/Survey/Presentation/Resources/ProfillingSurvey/Index',
    ],

    'set_accessibility_device' => [
        'index' => 'BlendedConcept/Disability/Presentation/Resources/SetAccessibilityDevice/Index',
    ],

    'teacher_storybook' => [
        'index' => 'BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Index',
        'edit' => 'BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Edit',
        'show' => 'BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Show',
        'assign_student' => 'BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/AssignStudent',
    ],

    'add_customisation' => [
        'create' => 'BlendedConcept/Teacher/Presentation/Resources/AddCustomisation/Create',
        'edit' => 'BlendedConcept/Teacher/Presentation/Resources/AddCustomisation/Edit',
    ],
    'org_view_teacher_student' => [
        'index' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/Index',
        'teacher-edit' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/EditTeacher',
        'teacher-create' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/CreateTeacher',
        'teacher-show' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/ViewTeacherDetail',

        'student-edit' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/EditStudent',
        'student-create' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/CreateStudent',
        'student-show' => 'BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/ViewStudentDetail',
    ],

    //teacher profile view

    'viewteacher' => [
        'viewteacher' => 'BlendedConcept/Teacher/Presentation/Resources/Profile/ViewTeacher',
        'editteacher' => 'BlendedConcept/Teacher/Presentation/Resources/Profile/EditTeacher',
    ],

    'playlist' => [
        'index' => 'BlendedConcept/Student/Presentation/Resources/PlayLists/Index',
        'create' => 'BlendedConcept/Student/Presentation/Resources/PlayLists/Create',
        'edit' => 'BlendedConcept/Student/Presentation/Resources/PlayLists/Edit',
        'show' => 'BlendedConcept/Student/Presentation/Resources/PlayLists/Show',
    ],

    'announment' => [
        'index' => 'BlendedConcept/System/Presentation/Resources/Announcements/Index',
        'create' => 'BlendedConcept/System/Presentation/Resources/Announcements/Create',
        'edit' => 'BlendedConcept/System/Presentation/Resources/Announcements/Edit',
    ],

    'settings' => 'BlendedConcept/System/Presentation/Resources/Settings/Index',
    'site_theme' => 'BlendedConcept/System/Presentation/Resources/Settings/SiteTheme',

    'support' => [
        'index' => 'BlendedConcept/System/Presentation/Resources/Supports/Index',
        'techsupport' => 'BlendedConcept/System/Presentation/Resources/Supports/TechSupport/Index',
    ],

    'login' => 'Auth/Presentation/Resources/Login',
    'verify' => 'Auth/Presentation/Resources/Verify',
    'register' => 'Auth/Presentation/Resources/Register',
    'registerplan' => 'Auth/Presentation/Resources/Plan',
    'userprofile' => 'Auth/Presentation/Resources/UserProfile',
    'students' => 'BlendedConcept/Student/Presentation/Resources/Student/Index',
    'teachers' => 'BlendedConcept/Teacher/Presentation/Resources/Teacher/Index',
    'classrooms' => 'BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index',
    //UI
    'showCopy' => 'BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Show',
    'editCopy' => 'BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Edit',
    'createCopy' => 'BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Create',

    'org-teacher-classroom' => [
        'index' => 'BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Index',
        'show' => 'BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Show',
        'edit' => 'BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Edit',
        'create' => 'BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Create',
        'add-group' => 'BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/AddGroup',
        'edit-group' => 'BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/EditGroup',
    ],
    //Storybook student
    'storybooks' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Index',
    'storybook-show' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Show',
    'storybook-pathway' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Pathway',

    //Game student
    'student-games' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentGames/Index',
    'game-show' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentGames/Show',

    //Rewards student
    'student-rewards' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/Index',
    'reward-store' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/Store',
    'be-lucky' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/BeLucky',
    'buy-sticker' => 'BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/BuySticker',

    'listofteacher' => [
        'index' => 'BlendedConcept/Teacher/Presentation/Resources/OrgTeacher/ListOfTeachers/Index',
    ],

    'profiles' => [
        'org-teacher' => 'Common/Presentation/Resources/components/UserProfile/OrgTeacherProfile',
    ],
    'edit-profiles' => [
        'org-teacher' => 'Common/Presentation/Resources/components/EditProfiles/OrgTeacherEditProfile',
    ],
    'reports' => [
        'reports' => 'BlendedConcept/System/Presentation/Resources/Reports/Reports',
    ],

    //resource
    'resource' => 'BlendedConcept/Library/Presentation/Resources/Resource/Index',
];
