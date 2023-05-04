<?php
use Illuminate\Support\Facades\Artisan;
use Src\BlendedConcept\User\Domain\Model\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');


});

/***
 *
 *
 *  superadmin only create superadmin
 *
 *  step first login as superadmin then
 *  check auth login as superadmin or not
 *  then create permissions
 */

test("superadmin only create permission",function(){
//login as superadmin
$this->post('/login', [
        'email' => 'superadmin@mail.com',
        'password' => 'password',
]);

//auth check
$this->assertTrue(Auth::check());


  $response = $this->post('/permissions', [
    'name' => 'new permission',
    'description' => "new description"
  ]);

   // Then the new role should be created successfully
   $response->assertStatus(302);
   $response->assertRedirect('/permissions');
   $this->assertDatabaseHas('permissions', ['name' => 'new permission']);

});

/***
 * superadmin but mission permission checking validation
 *
 */
test("create permission mission permission name",function(){
    $this->post('/login', [
        'email' => 'superadmin@mail.com',
        'password' => 'password',
  ]);

  //auth check
 $this->assertTrue(Auth::check());

 $response = $this->post('/permissions', [
    'name' => '',
    'description' => "new description"
  ]);


  $response->assertSessionHasErrors(['name']);

});


