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
    "BlendedConcept/Finance/Presentation/Resources/Plans/Index": import('../../src/BlendedConcept/Finance/Presentation/Resources/Plans/Index.vue'),

    "BlendedConcept/Finance/Presentation/Resources/Plans/Create": import('../../src/BlendedConcept/Finance/Presentation/Resources/Plans/Create.vue'),

    "BlendedConcept/Finance/Presentation/Resources/Plans/Edit": import('../../src/BlendedConcept/Finance/Presentation/Resources/Plans/Edit.vue'),

    "BlendedConcept/Finance/Presentation/Resources/Plans/Show": import('../../src/BlendedConcept/Finance/Presentation/Resources/Plans/Show.vue'),

    "BlendedConcept/Finance/Presentation/Resources/PlanForOrg/CreatePlan": import('../../src/BlendedConcept/Finance/Presentation/Resources/PlanForOrg/CreatePlan.vue'),


    "BlendedConcept/Finance/Presentation/Resources/SubScriptionInvoice/Index": import('../../src/BlendedConcept/Finance/Presentation/Resources/SubScriptionInvoice/Index.vue'),

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


    //manage disabilty device
    "BlendedConcept/Disability/Presentation/Resources/Disability/Index": import('../../src/BlendedConcept/Disability/Presentation/Resources/Disability/Index.vue'),

    //manage accessibility device
    "BlendedConcept/Disability/Presentation/Resources/Accessibility/Index": import('../../src/BlendedConcept/Disability/Presentation/Resources/Accessibility/Index.vue'),
    "BlendedConcept/Disability/Presentation/Resources/Accessibility/Create": import('../../src/BlendedConcept/Disability/Presentation/Resources/Accessibility/Create.vue'),
    "BlendedConcept/Disability/Presentation/Resources/Accessibility/Edit": import('../../src/BlendedConcept/Disability/Presentation/Resources/Accessibility/Edit.vue'),

    //manage games
    "BlendedConcept/StoryBook/Presentation/Resources/Games/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Games/Index.vue'),

    //manage books
    "BlendedConcept/StoryBook/Presentation/Resources/Books/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Books/Index.vue'),

    //assign rewards
    "BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Index.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Create": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Create.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Edit": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/AssignRewards/Edit.vue'),

    //survey results
    "BlendedConcept/Survey/Presentation/Resources/SurveyResults/Index": import('../../src/BlendedConcept/Survey/Presentation/Resources/SurveyResults/Index.vue'),
    "BlendedConcept/Survey/Presentation/Resources/SurveyResults/Show": import('../../src/BlendedConcept/Survey/Presentation/Resources/SurveyResults/Show.vue'),
    "BlendedConcept/Survey/Presentation/Resources/SurveyResults/View": import('../../src/BlendedConcept/Survey/Presentation/Resources/SurveyResults/View.vue'),

    //conduct lesson
    "BlendedConcept/ClassRoom/Presentation/Resources/ConductLessons/Index": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ConductLessons/Index.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/ConductLessons/Show" : import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ConductLessons/Show.vue'),

    //view student
    "BlendedConcept/Student/Presentation/Resources/ViewStudents/Index": import('../../src/BlendedConcept/Student/Presentation/Resources/ViewStudents/Index.vue'),
    "BlendedConcept/Student/Presentation/Resources/ViewStudents/Create": import('../../src/BlendedConcept/Student/Presentation/Resources/ViewStudents/Create.vue'),
    "BlendedConcept/Student/Presentation/Resources/ViewStudents/Edit": import('../../src/BlendedConcept/Student/Presentation/Resources/ViewStudents/Edit.vue'),
    "BlendedConcept/Student/Presentation/Resources/ViewStudents/Show": import('../../src/BlendedConcept/Student/Presentation/Resources/ViewStudents/Show.vue'),

    //learning activities
    "BlendedConcept/ClassRoom/Presentation/Resources/LearningActivities/Index": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/LearningActivities/Index.vue'),

    //profilling survey
    "BlendedConcept/Survey/Presentation/Resources/ProfillingSurvey/Index": import('../../src/BlendedConcept/Survey/Presentation/Resources/ProfillingSurvey/Index.vue'),

    //set accessibility device
    "BlendedConcept/Disability/Presentation/Resources/SetAccessibilityDevice/Index": import('../../src/BlendedConcept/Disability/Presentation/Resources/SetAccessibilityDevice/Index.vue'),

    //teacher view storybook
    "BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Index.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Edit": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Edit.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Show": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/Show.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/AssignStudent": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/TeacherStorybook/AssignStudent.vue'),

    //teacher add customisation
    "BlendedConcept/Teacher/Presentation/Resources/AddCustomisation/Create": import('../../src/BlendedConcept/Teacher/Presentation/Resources/AddCustomisation/Create.vue'),
    "BlendedConcept/Teacher/Presentation/Resources/AddCustomisation/Edit": import('../../src/BlendedConcept/Teacher/Presentation/Resources/AddCustomisation/Edit.vue'),

    //org teacher and student list
    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/Index": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/Index.vue'),
    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/ViewTeacherDetail": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/ViewTeacherDetail.vue'),
    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/EditTeacher": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/EditTeacher.vue'),
    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/CreateTeacher": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfTeacher/CreateTeacher.vue'),

    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/ViewStudentDetail": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/ViewStudentDetail.vue'),
    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/EditStudent": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/EditStudent.vue'),
    "BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/CreateStudent": import('../../src/BlendedConcept/Organization/Presentation/Resources/OrgAdminListOfUsers/components/OrgAdminListOfStudent/CreateStudent.vue'),



     "BlendedConcept/Teacher/Presentation/Resources/Profile/ViewTeacher" : import('../../src/BlendedConcept/Teacher/Presentation/Resources/Profile/ViewTeacher.vue'),

     "BlendedConcept/Teacher/Presentation/Resources/Profile/EditTeacher" : import('../../src/BlendedConcept/Teacher/Presentation/Resources/Profile/EditTeacher.vue'),

     //playlists

     'BlendedConcept/Student/Presentation/Resources/PlayLists/Index' : import('../../src/BlendedConcept/Student/Presentation/Resources/PlayLists/Index.vue'),
     'BlendedConcept/Student/Presentation/Resources/PlayLists/Create' : import('../../src/BlendedConcept/Student/Presentation/Resources/PlayLists/Create.vue'),
     'BlendedConcept/Student/Presentation/Resources/PlayLists/Edit' : import('../../src/BlendedConcept/Student/Presentation/Resources/PlayLists/Edit.vue'),
     'BlendedConcept/Student/Presentation/Resources/PlayLists/Show' : import('../../src/BlendedConcept/Student/Presentation/Resources/PlayLists/Show.vue'),


    // Security Domain
    "BlendedConcept/Security/Presentation/Resources/Permissions/Index": import('../../src/BlendedConcept/Security/Presentation/Resources/Permissions/Index.vue'),
    "BlendedConcept/Security/Presentation/Resources/Roles/Index": import('../../src/BlendedConcept/Security/Presentation/Resources/Roles/Index.vue'),
    "BlendedConcept/Security/Presentation/Resources/Roles/Create": import('../../src/BlendedConcept/Security/Presentation/Resources/Roles/Create.vue'),
    "BlendedConcept/Security/Presentation/Resources/Roles/Edit": import('../../src/BlendedConcept/Security/Presentation/Resources/Roles/Edit.vue'),


    //user experience survey

    "BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Index": import('../../src/BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Index.vue'),

    "BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Create": import('../../src/BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Create.vue'),

    "BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Show": import('../../src/BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Show.vue'),


    "BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Edit": import('../../src/BlendedConcept/Survey/Presentation/Resources/UserExperienceSurvey/Survey/Edit.vue'),



    //rewards


    "BlendedConcept/StoryBook/Presentation/Resources/Rewards/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Rewards/Index.vue'),

    "BlendedConcept/StoryBook/Presentation/Resources/Rewards/Create": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Rewards/Create.vue'),

    "BlendedConcept/StoryBook/Presentation/Resources/Rewards/Show": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Rewards/Show.vue'),


    "BlendedConcept/StoryBook/Presentation/Resources/Rewards/Edit": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Rewards/Edit.vue'),



    //pathways

    "BlendedConcept/StoryBook/Presentation/Resources/Pathways/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Pathways/Index.vue'),

    "BlendedConcept/StoryBook/Presentation/Resources/Pathways/Create": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Pathways/Create.vue'),

    "BlendedConcept/StoryBook/Presentation/Resources/Pathways/Show": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/Pathways/Show.vue'),


    //bookreview

    "BlendedConcept/StoryBook/Presentation/Resources/BookReviews/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/BookReviews/Index.vue'),




    //authnication route :🧑
    "Auth/Presentation/Resources/Login": import("../../src/Auth/Presentation/Resources/Login.vue"),
    "Auth/Presentation/Resources/Register": import("../../src/Auth/Presentation/Resources/Register.vue"),
    "Auth/Presentation/Resources/Plan": import("../../src/Auth/Presentation/Resources/Plan.vue"),
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
    "BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Index.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Show": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Show.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Create": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Create.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Edit": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/ClassRoom/Edit.vue'),

    //org teacher classRoom crud
    "BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Index": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Index.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Show": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Show.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Create": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Create.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Edit": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/Edit.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/AddGroup": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/AddGroup.vue'),
    "BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/EditGroup": import('../../src/BlendedConcept/ClassRoom/Presentation/Resources/OrgTeacherClassroom/EditGroup.vue'),

    //Resource
    "BlendedConcept/Library/Presentation/Resources/Resource/Index": import('../../src/BlendedConcept/Library/Presentation/Resources/Resource/Index.vue'),

    //list of organization teacher

    "BlendedConcept/Teacher/Presentation/Resources/OrgTeacher/ListOfTeachers/Index" : import('../../src/BlendedConcept/Teacher/Presentation/Resources/OrgTeacher/ListOfTeachers/Index.vue'),


    //Student story book
    "BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Index.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Pathway": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Pathway.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Show": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentStorybook/Show.vue'),

    //Student game
    "BlendedConcept/StoryBook/Presentation/Resources/StudentGames/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentGames/Index.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/StudentGames/Show": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentGames/Show.vue'),

    //Student rewards
    "BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/Index": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/Index.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/Store": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/Store.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/BeLucky": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/BeLucky.vue'),
    "BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/BuySticker": import('../../src/BlendedConcept/StoryBook/Presentation/Resources/StudentRewards/BuySticker.vue'),

    //profiles
    "Common/Presentation/Resources/components/UserProfile/OrgTeacherProfile" : import('../../src/Common/Presentation/Resources/components/UserProfile/OrgTeacherProfile.vue'),
    "Common/Presentation/Resources/components/EditProfiles/OrgTeacherEditProfile" : import('../../src/Common/Presentation/Resources/components/EditProfiles/OrgTeacherEditProfile.vue'),

    //reports
    "BlendedConcept/System/Presentation/Resources/Reports/Reports": import('../../src/BlendedConcept/System/Presentation/Resources/Reports/Reports.vue'),
};
export default pages;
