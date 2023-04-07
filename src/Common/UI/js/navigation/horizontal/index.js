export default [
    {
      title: 'Dashboard',
      url: '#',
      icon: { icon: 'mdi-home' },
      children:[
        { title: 'Home', url: '/home',icon: { icon: 'mdi-home' }, route_name:'dashboard',},
      ],
    },
    {
      title: 'Organizations',
      url: "/organizations",
      icon: { icon: 'mdi-home-city' },
      route_name:'organizations',
      children: []
    },
    {
      title: 'User Managements',
      url: "#",
      icon: { icon: 'mdi-account' },
        children: [
          { title: 'Permissions', url: '/permissions',icon: { icon: 'mdi-shield' }, route_name:'permissions',},
          { title: 'Roles', url: '/roles',icon: { icon: 'mdi-alpha-r-circle' }, route_name:'roles',},
          { title: 'Users', url: '/',icon: { icon: 'mdi-account-group' }, route_name:'users',},
        ],
    },
    {
      title: 'Subscribers',
      url: "/",
      icon: { icon: 'mdi-youtube-subscription' },
      route_name:'subscribers',
      children: []
    },
    {
      title: 'Libraries',
      url: "/",
      icon: { icon: 'mdi-file-document-multiple' },
      route_name:'libraries',
      children: []
    },
    {
      title: 'System',
      url: "/",
      icon: { icon: 'mdi-cog' },
      route_name:'system',
      children: []
    },
    // {
    //     title: 'Announcment',
    //     url: "/announcments",
    //     icon: { icon: 'mdi-bullhorn' },
    //     route_name:'announcments',
    //   },
  ]








