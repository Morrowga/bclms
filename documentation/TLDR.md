# How to write CRUD with DDD patterns
```
 I am going to explain as an example with User CRUD

```
# How to create Domain 

<strong>You can do as below command</strong>
```

```

### Step 1

<strong>Create a `routes.php` that can be found inside this folder path  `src/BlendedConcept/Security/Presentation/HTTP/routes.php` where you can write your Route that files.
 </strong>

 ## Step 2 

 <strong>
 Then you need to Create `UserController.php` you need to create Controller and you need to create some file before working on Controller 
 </strong>


<br/>

<details>
 
<summary>
 <b>Create Repository and Interface for that</b>
 </br>
 <strong style="color:#EB5A5A">
 Repository is implement for RepositoryInterFace for database related queries
 </strong>
</summary>

<h4>
Create `SecurityRepositoryInterface.php` inside these folder path  `src/BlendedConcept/Security/Domain/Repositories/SecurityRepositoryInterface.php`
</h4>

<h4>Create `SecurityRepository.php` inside these folder path `src/BlendedConcept/Security/Application/Repositories/Eloquent/SecurityRepository.php`</h4>

<p>
Before implementing `SecurityRepository.php` you might need to create the following.
</p> 
<ul>
<li><b style="color:#EB5A5A">Mappers</b></li>
   Map is used to 
<li><b style="color:#EB5A5A">DTO</b> </li>
<li><b style="color:#EB5A5A">UseCases</b></li>  
<li><b style="color:#EB5A5A">Models</b></li>
</ul>
</details>