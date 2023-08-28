
# How to Create CRUD with DDD pattern 


Note : I am going to explain as an example with Organization CRUD
## Step 1 

You need to go routes.php inside these folder folder path
`src/BlendedConcept/Organization/Presentation/HTTP/routes.php`


```php 

Route::get('createorganization',OrganizationController::class);


```


then go to `OrganizationController.php`

```php

  public function index()
  {
    return Inertia::render(config('('route.organizations.index'));
  }

```

go to route.php inside `config/route.php`

```php
<?php

return [
    
 'organizations' => [

    'index' => 'BlendedConcept/Organization/Presentation/Resources/Organization/Index',

    ],
]

```

then go to route.js inside `resources/js/route.js` and configure that route.

```
const pages = { 

"BlendedConcept/Organization/Presentation/Resources/Organization/Index": import('../../src/BlendedConcept/Organization/Presentation/Resources/Organization/Index.vue'),

}


```

Then you can start writing UI  go to `src/BlendedConcept/Organization/Presentation/Resources/Organization/Index.vue` and you can start writing UI file here 





