const pages = {


    // admin dashboard
    "BlendedConcept/System/Presentation/Resources/index": import('../../src/BlendedConcept/System/Presentation/Resources/index.vue'),

    /***
     * this below contains  Orgainzations lists that will used for superadmin
     *
     *  Index,Create,Edit,Show Organizations
     *
     */
    "BlendedConcept/Organization/Presentation/Resources/Organization/Index": import('../../src/BlendedConcept/Organization/Presentation/Resources/Organization/Index.vue'),

    "BlendedConcept/Organization/Presentation/Resources/Organization/Create": import('../../src/BlendedConcept/Organization/Presentation/Resources/Organization/Create.vue'),

    "BlendedConcept/Organization/Presentation/Resources/Organization/Edit": import('../../src/BlendedConcept/Organization/Presentation/Resources/Organization/Edit.vue'),

    "BlendedConcept/Organization/Presentation/Resources/Organization/Show": import('../../src/BlendedConcept/Organization/Presentation/Resources/Organization/Show.vue'),


    /***
     * this below contains plans lists that will used for superadmin
     *
     *  Index,Create,Edit,Show Plans
     *
     */
    "BlendedConcept/Organization/Presentation/Resources/Plans/Index": import('../../src/BlendedConcept/Organization/Presentation/Resources/Plans/Index.vue'),

    "BlendedConcept/Organization/Presentation/Resources/Plans/Create": import('../../src/BlendedConcept/Organization/Presentation/Resources/Plans/Create.vue'),

    "BlendedConcept/Organization/Presentation/Resources/Plans/Edit": import('../../src/BlendedConcept/Organization/Presentation/Resources/Plans/Edit.vue'),

    "BlendedConcept/Organization/Presentation/Resources/Plans/Show": import('../../src/BlendedConcept/Organization/Presentation/Resources/Plans/Show.vue'),



    /***
     * this below contains users  lists that will used for superadmin
     *
     *  Index,Show announcement
     *
     *  @hareom284
     *
     */
    "BlendedConcept/Security/Presentation/Resources/Users/Index": import('../../src/BlendedConcept/Security/Presentation/Resources/Users/Index.vue'),

    "BlendedConcept/Security/Presentation/Resources/Users/Show": import('../../src/BlendedConcept/Security/Presentation/Resources/Users/Show.vue'),




    // Security Domain
    "BlendedConcept/Security/Presentation/Resources/Permissions/Index": import('../../src/BlendedConcept/Security/Presentation/Resources/Permissions/Index.vue'),
    "BlendedConcept/Security/Presentation/Resources/Roles/Index": import('../../src/BlendedConcept/Security/Presentation/Resources/Roles/Index.vue'),

    //authnication route :🧑
    "Auth/Presentation/Resources/Login": import("../../src/Auth/Presentation/Resources/Login.vue"),
    "Auth/Presentation/Resources/Register": import("../../src/Auth/Presentation/Resources/Register.vue"),
    "Auth/Presentation/Resources/Verify": import("../../src/Auth/Presentation/Resources/Verify.vue"),
    "Auth/Presentation/Resources/UserProfile": import('../../src/Auth/Presentation/Resources/UserProfile.vue'),





    /***
     * this below contains announcement  lists that will used for superadmin
     *
     *  Index,Create,Edit,Show announcement
     *
     */
    "BlendedConcept/System/Presentation/Resources/Announcements/Index": import('../../src/BlendedConcept/System/Presentation/Resources/Announcements/Index.vue'),

    "BlendedConcept/System/Presentation/Resources/Announcements/Create": import('../../src/BlendedConcept/System/Presentation/Resources/Announcements/Create.vue'),





    //settings
    "BlendedConcept/System/Presentation/Resources/Settings/Index": import('../../src/BlendedConcept/System/Presentation/Resources/Settings/Index.vue'),

    //siteTheme UI
    "BlendedConcept/System/Presentation/Resources/Settings/SiteTheme": import('../../src/BlendedConcept/System/Presentation/Resources/Settings/SiteTheme.vue'),

    //support

    "BlendedConcept/System/Presentation/Resources/Supports/Index" : import("../../src/BlendedConcept/System/Presentation/Resources/Supports/Index.vue"),


    //students crud

    "BlendedConcept/Student/Presentation/Resources/Student/Index": import('../../src/BlendedConcept/Student/Presentation/Resources/Student/Index.vue'),

    //teacher crud

    "BlendedConcept/Teacher/Presentation/Resources/Teacher/Index": import('../../src/BlendedConcept/Teacher/Presentation/Resources/Teacher/Index.vue'),


    //classRoom crud
    "BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index.vue')


};
export default pages;
