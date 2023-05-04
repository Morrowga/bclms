<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use  Src\BlendedConcept\User\Domain\Model\User;

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

test('page builde access for superadmin', function () {

    $this->assertTrue(Auth::check());


    $this->get("/bc/admin");

});


test("page builder not superadmin access",function(){

    Auth::logout();
    $response = $this->get("/bc/admin");

    $response->assertRedirect("/login");

});


test("page builder access with other roles ",function(){
    Auth::logout();

    $user = User::create([
        "name" => "testing",
        "email" => "testing@gmail.com",
        "password" => "password"
    ]);

    $user->roles()->sync(2);

    if (Auth::attempt(["email" => "testing@gmail.com", "password" => "password",])) {

        $response = $this->get("/bc/admin");
        $response->assertStatus(403);
    }


    $response = $this->get("/bc/admin");
    $response->assertStatus(403);

});
