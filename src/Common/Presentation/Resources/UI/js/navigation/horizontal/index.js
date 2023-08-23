/**
 * this below code will add prefix c. for organiation admin login
 *
 * user
 *
 */
const PREFIX = localStorage.getItem("tenant") !="" ? `/${localStorage.getItem("tenant") }` : "";

const DASHBOARD_URL = PREFIX != "" ? "/c" : "/home";
const DASHBOARD_ROUTE = PREFIX != "" ? "c.organizationaadmin" : "dashboard";
const HASH_ROUTE = "#"

export default [
    {
        title: 'Home',
        url: DASHBOARD_URL,
        icon: { icon: 'mdi-home' },
        access_module: "access_dashboard",
        route_name: DASHBOARD_ROUTE,
    },
    // {
    //     title: 'Resources',
    //     url: "#",
    //     icon: { icon: 'mdi-folder-outline' },
    //     access_module: "access_dashboard",
    //     route_name: DASHBOARD_ROUTE,
    // },
    {
        title: 'Storybooks',
        url: "/",
        icon: { icon: 'mdi-book-variant' },
        route_name: 'accessibility',
        access_module: "access_user",
        children: [
            { title: 'Books', url: '/books', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'books', access_module: "access_user", },
            { title: 'Games', url: '/games', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'games', access_module: "access_user", },
            { title: 'Pathways', url: '/pathways', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'pathways', access_module: "access_user", },
            { title: 'Rewards', url: '/rewards', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'rewards', access_module: "access_user", },
            { title: 'Reviews', url: '/bookreviews', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'bookreviews', access_module: "access_user", },
        ]
    },
    {
        title: 'Accessibility',
        url: "/",
        icon: { icon: 'mdi-wheelchair' },
        route_name: 'accessibility',
        access_module: "access_user",
        children: [
            { title: 'Manage Tags', url: '/disability_device', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'disability_device', access_module: "access_user", },
            { title: 'Devices', url: '/accessibility_device', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'accessibility_device', access_module: "access_user", },
        ]
    },

    {
        title: 'Organizations',
        url: "/organizations",
        icon: { icon: 'mdi-briefcase-variant' },
        route_name: 'organizations',
        access_module: "access_organization",
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
        title: 'Users',
        url: `#`,
        icon: { icon: ' mdi-google-classroom' },
        route_name: 'classrooms',
        access_module: "access_classroom",
    },
    {
        title: 'Reports',
        url: `#`,
        icon: { icon: 'mdi-file-chart-outline' },
        route_name: 'classrooms',
        access_module: "access_classroom",
    },
    {
        title: 'Subscriptions',
        url: "/",
        icon: { icon: 'mdi-play-circle-outline' },
        route_name: 'subscribers',
        access_module: "access_subscriber",
        children: [
            { title: 'Subscriptions', url: '/plans', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'plans', access_module: "access_plan", },
            { title: 'Plans', url: '/plans', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'plans', access_module: "access_plan", },
        ]
    },
    {
        title: 'Manage Users',
        url: "#",
        icon: { icon: 'mdi-account' },
        access_module: "access_user",
        children: [
            { title: 'Permissions', url: '/permissions', icon: { icon: 'mdi-shield' }, route_name: 'permissions', access_module: "access_permission", },
            { title: 'Roles', url: '/roles', icon: { icon: 'mdi-alpha-r-circle' }, route_name: 'roles', access_module: "access_role" },
            { title: 'Users', url: '/users', icon: { icon: 'mdi-account-group' }, route_name: 'users', access_module: "access_user" },
            { title: 'Student', url: `${PREFIX}/students`, icon: { icon: 'mdi-account-group-outline' }, route_name: 'students', access_module: "access_student" },
        ],
    },

    {
        title: 'Surveys',
        url: "#",
        icon: { icon: 'mdi-account' },
        access_module: "access_user",
        children: [
            { title: 'User Surveys', url: '/userexperiencesurvey', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'userexperiencesurvey', access_module: "access_user", },
            { title: 'Survey Results', url: '/survey_results', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'survey_results', access_module: "access_user", },
            { title: 'Profilling Surveys', url: '/profilling_survey', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'profilling_survey', access_module: "access_user", },
        ],
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
        icon: { icon: 'mdi-cog' },
        route_name: 'system',
        access_module: "access_system",
        children: [
            { title: 'Website Manager', url: '/bc/admin', icon: { icon: 'mdi-alpha-r-circle' }, route_name: '/bc/admin', access_module: "access_pagebuilder", isNativeLink: true },
            { title: 'Setting Configuration', url: '/settings', icon: { icon: 'mdi-cog' }, route_name: '/settings', access_module: "access_pagebuilder" },
            { title: 'Setting Themems', url: '/updateSiteTheme', icon: { icon: 'mdi-cog' }, route_name: 'updateSiteTheme', access_module: "access_pagebuilder" },
            { title: 'Supports', url: '/supports', icon: { icon: 'mdi-cog' }, route_name: 'supports', access_module: "access_pagebuilder" },


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
]








