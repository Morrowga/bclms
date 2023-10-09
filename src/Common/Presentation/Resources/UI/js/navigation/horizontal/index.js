/**
 * this below code will add prefix c. for organiation admin login
 *
 * user
 *
 */
const PREFIX = localStorage.getItem("tenant") !="" ? `/${localStorage.getItem("tenant") }` : "";

const DASHBOARD_URL = PREFIX != "" ? "/c" : "/home";
const DASHBOARD_ROUTE = PREFIX != "" ? "c.organisationaadmin" : "dashboard";
const HASH_ROUTE = "#"

export default [
    {
        title: 'Home',
        url: DASHBOARD_URL,
        icon: { icon: 'mdi-home' },
        access_module: "access_dashboard",
        route_name: DASHBOARD_ROUTE,
    },

    {
        title: 'Storybooks',
        url: "/",
        icon: { icon: 'mdi-book-variant' },
        route_name: 'accessibility',
        access_module: "access_storybook",
        children: [
            { title: 'Books', url: '/books', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'books', access_module: "access_user", },
            { title: 'Games', url: '/games', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'games', access_module: "access_user", },
            { title: 'Pathways', url: '/pathways', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'pathways', access_module: "access_user", },
            { title: 'Rewards', url: '/rewards', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'rewards', access_module: "access_user", },
            { title: 'Reviews', url: '/bookreviews', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'bookreviews', access_module: "access_user", },
        ]
    },
    {
        title: 'StoryBooks',
        url: "/teacher_storybook",
        icon: { icon: 'mdi-book' },
        route_name: 'teacher_storybook',
        access_module: "access_teacherStorybook",
    },
    {
        title: 'Resources',
        url: "/resource",
        icon: { icon: 'mdi-folder-outline' },
        access_module: "access_resources",
        route_name: "resource",
    },
    {
        title: 'Students',
        url: "/teacher_students",
        icon: { icon: 'mdi-account-multiple-outline' },
        access_module: "access_viewStudents",
        route_name: "teacher_students",
    },
    {
        title: 'Playlists',
        url: "/playlists",
        icon: { icon: 'mdi-play-circle-outline' },
        access_module: "access_playlists",
        route_name: "playlists",
    },
    {
        title: 'Accessibility',
        url: "/",
        icon: { icon: 'mdi-wheelchair' },
        route_name: 'accessibility',
        access_module: "access_accessibility",
        children: [
            { title: 'Manage Tags', url: '/disability_type', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'disability_type', access_module: "access_disabilityDevice", },
            { title: 'Devices', url: '/accessibility_device', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'accessibility_device', access_module: "access_accessibilityDevice", },
        ]
    },

    {
        title: 'Organisations',
        url: "/organisations",
        icon: { icon: 'mdi-briefcase-variant' },
        route_name: 'organisations',
        access_module: "access_organisation",
    },
    {
        title: 'Teachers',
        url: `${PREFIX}/teachers`,
        icon: { icon: 'mdi-account-group-outline' },
        route_name: 'teachers',
        access_module: "access_teacher",
    },
    {
        title: 'ClassRoom',
        url: `${PREFIX}/classrooms`,
        icon: { icon: ' mdi-google-classroom' },
        route_name: 'classrooms',
        access_module: "access_classroom",
    },
    {
        title: 'ClassRoom',
        url: `${PREFIX}/classroom/org-teacher`,
        icon: { icon: ' mdi-google-classroom' },
        route_name: 'org-teacher-classroom',
        access_module: "access_orgClassroom",
    },
    {
        title: 'Users',
        url: `/organisations-teacher`,
        icon: { icon: ' mdi-google-classroom' },
        route_name: 'organisations-teacher',
        access_module: "access_orgusers",
    },

    {
        title: 'Subscriptions',
        url: "/",
        icon: { icon: 'mdi-play-circle-outline' },
        route_name: 'subscribers',
        access_module: "access_subscriber",
        children: [
            { title: 'Subscriptions', url: '/subscribptioninvoice', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'subscription_invoice', access_module: "access_plan", },
            { title: 'Plans', url: '/plans', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'plans', access_module: "access_plan", },
        ]
    },
    {
        title: 'Manage Users',
        url: "#",
        icon: { icon: 'mdi-account' },
        access_module: "access_user",
        children: [
            { title: 'Users', url: '/users', icon: { icon: 'mdi-account-group' }, route_name: 'users', access_module: "access_user" },
            { title: 'Student', url: `${PREFIX}/students`, icon: { icon: 'mdi-account-group-outline' }, route_name: 'students', access_module: "access_student" },
            { title: 'Roles', url: '/roles', icon: { icon: 'mdi-alpha-r-circle' }, route_name: 'roles', access_module: "access_role" },
            { title: 'Permissions', url: '/permissions', icon: { icon: 'mdi-shield' }, route_name: 'permissions', access_module: "access_permission", },
            { title: 'Organisations', url: '/organisations', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'access_organisations', access_module: "access_bcstaffOrganisation", },
            { title: 'Subscriptions', url: '/subscribptioninvoice', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'access_subscription_invoice', access_module: "access_bcstaffSubscription", },
        ],
    },

    {
        title: 'Surveys',
        url: "#",
        icon: { icon: 'mdi-note-edit' },
        access_module: "access_surveys",
        children: [
            { title: 'User Surveys', url: '/userexperiencesurvey', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'userexperiencesurvey', access_module: "access_userSurveys", },
            { title: 'Survey Responses', url: '/surveyresponse', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'surveyresponse', access_module: "access_surveyresponses", },
            { title: 'Profilling Surveys', url: '/profilling_survey', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'profilling_survey', access_module: "access_profillingSurveys", },
        ],
    },
    {
        title: 'Reports',
        url: `/reports`,
        icon: { icon: 'mdi-file-chart-outline' },
        route_name: 'reports',
        access_module: "access_reports",
    },
    // {
    //     title: 'Libraries',
    //     url: "/",
    //     icon: { icon: 'mdi-file-document-multiple' },
    //     route_name: 'libraries',
    //     access_module: "access_library",
    //     children: [
    //         {
    //             title: "Libraries", url: `${PREFIX}/libraries`, icon: { icon: 'mdi mdi-library' }, route_name: "c.libraries", access_module: 'access_library', isNativeLink: true
    //         },
    //         {
    //             title: "H5p", url: '/admin/h5p/h5p', icon: { icon: 'mdi mdi-video' }, route_name: "/admin/h5p/h5p", access_module: 'access_library', isNativeLink: true
    //         }
    //     ]
    // },
    {
        title: 'Settings',
        url: "/",
        icon: { icon: 'mdi-wrench' },
        route_name: 'system',
        access_module: "access_system",
        children: [
            { title: 'System', url: '/settings', icon: { icon: 'mdi-alpha-r-circle' }, route_name: 'settings', access_module: "access_pagebuilder" },
            { title: 'Site Theme', url: '/updateSiteTheme', icon: { icon: 'mdi-cog' }, route_name: 'updateSiteTheme', access_module: "access_pagebuilder" },
            { title: 'Export Data', url: '/reports', icon: { icon: 'mdi-cog' }, route_name: 'reports', access_module: "access_pagebuilder" },
            { title: 'Tech Support', url: '/supports', icon: { icon: 'mdi-cog' }, route_name: 'supports', access_module: "access_pagebuilder" },
        ]
    },

    {
        title: 'StoryBooks',
        url: "/storybooks",
        icon: { icon: 'mdi-bullhorn' },
        route_name: 'storybooks',
        access_module: "access_studentStorybook",
    },
    {
        title: 'Games',
        url: "/student-games",
        icon: { icon: 'mdi-rocket-launch-outline' },
        route_name: 'student-games',
        access_module: "access_studentStorybook",
    },
    {
        title: 'Rewards',
        url: "/student-rewards",
        icon: { icon: 'mdi-emoticon-happy-outline' },
        route_name: 'student-rewards',
        access_module: "access_studentRewards",
    },

    {
        title: 'Announcements',
        url: "/announcements",
        icon: { icon: 'mdi-bullhorn' },
        route_name: 'announcements',
        access_module: "access_announcement",
    },
]








