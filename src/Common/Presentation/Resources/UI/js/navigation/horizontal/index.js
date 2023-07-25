/**
 * this below code will add prefix c. for organiation admin login
 *
 * user
 *
 */
const PREFIX = localStorage.getItem("tenant") !="" ? `/${localStorage.getItem("tenant") }` : "";

const DASHBOARD_URL = PREFIX != "" ? "/c" : "/home";
const DASHBOARD_ROUTE = PREFIX != "" ? "c.organizationaadmin" : "dashboard";


export default [
    {
        title: 'Dashboard',
        url: '#',
        icon: { icon: 'mdi-home' },
        access_module: "access_dashboard",
        children: [
            { title: 'Home', url: DASHBOARD_URL, icon: { icon: 'mdi-home' }, route_name: DASHBOARD_ROUTE, },
        ],
    },
    {
        title: 'Organizations',
        url: "/organizations",
        icon: { icon: 'mdi-home-city' },
        route_name: 'organizations',
        access_module: "access_organization",
        children: [
            { title: 'Organizations', url: '/organizations', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'organizations', access_module: "access_organization", },
        ]
    },
    {
        title: 'Teachers',
        url: `${PREFIX}/teachers`,
        icon: { icon: 'mdi-account-group-outline' },
        route_name: 'teachers',
        access_module: "access_teacher",
    },
    {
        title: 'Students',
        url: `${PREFIX}/students`,
        icon: { icon: 'mdi-account-group-outline' },
        route_name: 'students',
        access_module: "access_student",
    },
    {
        title: 'ClassRoom',
        url: `${PREFIX}/classrooms`,
        icon: { icon: ' mdi-google-classroom' },
        route_name: 'classrooms',
        access_module: "access_classroom",
    },
    {
        title: 'User Managements',
        url: "#",
        icon: { icon: 'mdi-account' },
        access_module: "access_user",
        children: [
            { title: 'Permissions', url: '/permissions', icon: { icon: 'mdi-shield' }, route_name: 'permissions', access_module: "access_permission", },
            { title: 'Roles', url: '/roles', icon: { icon: 'mdi-alpha-r-circle' }, route_name: 'roles', access_module: "access_role" },
            { title: 'Users', url: '/users', icon: { icon: 'mdi-account-group' }, route_name: 'users', access_module: "access_user" },
        ],
    },
    {
        title: 'Subscribers',
        url: "/",
        icon: { icon: 'mdi-youtube-subscription' },
        route_name: 'subscribers',
        access_module: "access_subscriber",
        children: [
            { title: 'Plans', url: '/plans', icon: { icon: 'mdi-account-group-outline ' }, route_name: 'plans', access_module: "access_plan", },
        ]
    },
    {
        title: 'Libraries',
        url: "/",
        icon: { icon: 'mdi-file-document-multiple' },
        route_name: 'libraries',
        access_module: "access_library",
        children: [
            {
                title: "Libraries", url: `${PREFIX}/libraries`, icon: { icon: 'mdi mdi-library' }, route_name: "c.libraries", access_module: 'access_library', isNativeLink: true
            },
            {
                title: "H5p", url: '/admin/h5p/h5p', icon: { icon: 'mdi mdi-video' }, route_name: "/admin/h5p/h5p", access_module: 'access_library', isNativeLink: true
            }
        ]
    },
    {
        title: 'System',
        url: "/",
        icon: { icon: 'mdi-cog' },
        route_name: 'system',
        access_module: "access_system",
        children: [
            { title: 'Website Manager', url: '/bc/admin', icon: { icon: 'mdi-alpha-r-circle' }, route_name: '/bc/admin', access_module: "access_pagebuilder", isNativeLink: true },
            { title: 'Setting Configuration', url: '/settings', icon: { icon: 'mdi-cog' }, route_name: '/settings', access_module: "access_pagebuilder" }

        ]
    },
    {
        title: 'Announcement',
        url: "/announcements",
        icon: { icon: 'mdi-bullhorn' },
        route_name: 'announcements',
        access_module: "access_announcement",
    },
]








