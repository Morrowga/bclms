export default [
    {
      title: 'Home',
      url: '/home',
      icon: { icon: 'mdi-home-outline' },
      route_name:'dashboard',
    },
    {
      title: 'Organizations',
      url: "/organizations",
      icon: { icon: 'mdi-widgets' },
      route_name:'organizations',
    },
    {
      title: 'User Managements',
      url: "/",
      icon: { icon: 'mdi-account-outline' },
        children: [
          { title: 'Permissions', url: '/permissions',icon: { icon: 'mdi-shield' }, route_name:'permissions',},
          { title: 'Roles', url: '/',icon: { icon: 'mdi-alpha-r-circle' }, route_name:'roles',},
          { title: 'Users', url: '/',icon: { icon: 'mdi-account-group' }, route_name:'users',},
        ],
    },
    {
        title: 'Announcment',
        url: "/announcments",
        icon: { icon: 'mdi-bullhorn' },
        route_name:'announcments',
      },
  ]








