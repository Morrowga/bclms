
# How to Create CRUD with DDD pattern 


Note : I am going to explain as an example with Organisation CRUD
## Step 1 

You need to go routes.php inside these folder folder path
`src/BlendedConcept/Organisation/Presentation/HTTP/routes.php`


```php 

Route::get('createorganisation',OrganisationController::class);


```


then go to `OrganisationController.php`

```php

  public function index()
  {
    return Inertia::render(config('('route.organisations.index'));
  }

```

go to route.php inside `config/route.php`

```php
<?php

return [
    
 'organisations' => [

    'index' => 'BlendedConcept/Organisation/Presentation/Resources/Organisation/Index',

    ],
]

```

then go to route.js inside `resources/js/route.js` and configure that route.

```
const pages = { 

"BlendedConcept/Organisation/Presentation/Resources/Organisation/Index": import('../../src/BlendedConcept/Organisation/Presentation/Resources/Organisation/Index.vue'),

}


```

Then you can start writing UI  go to `src/BlendedConcept/Organisation/Presentation/Resources/Organisation/Index.vue` and you can start writing UI file here 





