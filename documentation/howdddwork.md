## Our DDD folder structure
![Alt text](images/rootfolderstructure.png)
  This is the root folder structure of our project that contains the `BlendedConcept` , `Common` and `Auth` as root domain.

  <span> **BlendedConcept** contains all the module and feature that we implement we might need to write inside by create `Domain` name according to each module </span>

  <span> **Auth** contains the basic `login` and `register` that we have implement inside that domain. </span>


  <span> **Common** are the root folder structure setup of laravel that we have implement inside it.
  </span>

  <span> Under **BlendedConcept** contains all the modules that are related to our Project that are call domain</span>

  As a example <br/>
  You have `RouteServiceProvider` , `AppServiceProvider` inside  `Common` folder here we might need to link their `routes` and `ServiceProvider` from other Domains to these Domain
<ul> 
</ul>


## Auth 

On the Auth Domain contains basic login and register where we need to that contains `Four` Layers 

###  Application
- On the application layer contains `Providers` that are used for Services provider that need to inject that `RepositroyInterFace` and `Repository` on the Application Service Provider that might need to called on the config/app.php same as use configure to user these provider on that Config.

- Repository contains where we write business on these repository on these `Repository` where we need to implement `RepositoryInterFace` from Domain Layer.
  
- Requests contains that used for services validation check from client site data inserting (form submiting).
-UseCases are use to implement the RepostoryInterface as function where we have `Command` and `Queries`
<br/>

<strong>Note: Command is used for Create and Update on the databse funciton where we need to implement from repository and Queries from database Queries form RepositoryInterface</strong>

## Presentation 

- Presentation contains all the UI resources on the folders and routes and controller that implements on the folders.

## Common 

- Common folder that are the basic requirement setup that need for laravel and all vue components contains inside these Presentation/Resources/Components/* folder path.

## BlendedConcept

BlendedConcept are the main root that contains all the domains that might needs to our project.

Here are the these domains contains on our project 

- **System Domain**  <br/><br/>
  System Domain Includes `Annouments`,`System` ,`Supports`, `Dashboard` , `Reports` , `SystemSettings` and `SiteThemes` on these Domain.

- **Security**
  <br/><br/>
  Securtiy Domain includes `Users` , `Roles`,`Permissions` all the modules on these Domain.

- **Organization** <br/><br/>
 Organizaiton Domains include only  `Organizations` Domain.

 - **Finance** <br/><br/>
   Finance Domain contains `PlanForOrg` , `Plans` and `SubscriptionInvoice` modules on the Domains.

- **StoryBook** <br/><br/>
   StoryBook Domain contains `Books` , `Games` , `Pathways` , `Rewards` , `StudentGames` , `StudentStoryBook` , `TeacherStoryBook` , `AssignRe`


