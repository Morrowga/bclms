<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use Carbon\Carbon;
use Src\BlendedConcept\User\Domain\Model\User;

beforeEach(function () {
    // Run migrations
    Artisan::call('migrate:fresh');
    // Seed the database with test data
    Artisan::call('db:seed');

    //login as superadmin
    $this->post('/login', [
        'email' => 'superadmin@mail.com',
        'password' => 'password',
    ]);
});


test('superadmin create organization', function () {

    $this->assertTrue(Auth::check());

    $reponse = $this->get("/organizations");
    $reponse->assertStatus(200);
 });



 test('without login not access organization', function () {

   Auth::logout();

    $reponse = $this->get("/organizations");
    $reponse->assertRedirect('/login');
 });

 /**
  *
  *
  *
  */

 test('without other role not access organization  ', function () {

    Auth::logout();
    $user = User::create([
        "name" => "testing",
        "email" => "testinguser@gmail.com",
        "password" => "password",
        "email_verified_at" => Carbon::now()
    ]);
    $user->roles()->sync(3);

    if (Auth::attempt(["email" => "testinguser@gmail.com","password" => "password"]))
    {
        $reponse = $this->get("/organizations");
        $reponse->assertStatus(403);
    }
    $reponse = $this->get("/organizations");
    $reponse->assertStatus(403);
  });


