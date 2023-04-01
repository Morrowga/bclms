const pages ={
    //portal
    "BlendedConcept/User/Presentation/Resources/Portal/Portal" :import('../../src/BlendedConcept/User/Presentation/Resources/Portal/Portal.vue'),
    //organization
    "BlendedConcept/Organization/Presentation/Resources/Index" : import('../../src/BlendedConcept/Organization/Presentation/Resources/Index.vue'),
    //user module
    "BlendedConcept/User/Presentation/Resources/Users/Index" : import('../../src/BlendedConcept/User/Presentation/Resources/Users/Index.vue'),
    "BlendedConcept/User/Presentation/Resources/Users/Create" : import('../../src/BlendedConcept/User/Presentation/Resources/Users/Create.vue'),
    "BlendedConcept/User/Presentation/Resources/Users/Edit" : import('../../src/BlendedConcept/User/Presentation/Resources/Users/Edit.vue'),
    "BlendedConcept/User/Presentation/Resources/Users/Show" : import('../../src/BlendedConcept/User/Presentation/Resources/Users/Show.vue'),

    //role module
    "BlendedConcept/User/Presentation/Resources/Roles/Index" : import('../../src/BlendedConcept/User/Presentation/Resources/Roles/Index.vue'),
    "BlendedConcept/User/Presentation/Resources/Roles/Create" : import('../../src/BlendedConcept/User/Presentation/Resources/Roles/Create.vue'),
    "BlendedConcept/User/Presentation/Resources/Roles/Edit" : import('../../src/BlendedConcept/User/Presentation/Resources/Roles/Edit.vue'),

    //permission module
    "BlendedConcept/User/Presentation/Resources/Permissions/Index" : import('../../src/BlendedConcept/User/Presentation/Resources/Permissions/Index.vue'),
    "BlendedConcept/User/Presentation/Resources/Permissions/Create" : import('../../src/BlendedConcept/User/Presentation/Resources/Permissions/Create.vue'),
    "BlendedConcept/User/Presentation/Resources/Permissions/Edit" : import('../../src/BlendedConcept/User/Presentation/Resources/Permissions/Edit.vue'),
    
    //site setting
    "BlendedConcept/User/Presentation/Resources/Settings/Index" : import('../../src/BlendedConcept/User/Presentation/Resources/Settings/Index.vue'),

    //auth
    "Auth/Presentation/Resources/Login" : import("../../src/Auth/Presentation/Resources/Login.vue"),
    "Auth/Presentation/Resources/Register" : import("../../src/Auth/Presentation/Resources/Register.vue"),
  };
  export default pages;