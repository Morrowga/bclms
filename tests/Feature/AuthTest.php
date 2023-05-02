<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\User\Domain\Model\User;
use Illuminate\Database\Eloquent\Factory;
use Src\BlendedConcept\User\Domain\Model\Role;
class AuthTest extends TestCase
{
   use RefreshDatabase, WithFaker;
   /**
    * A basic feature test example.
    *
    * @return void
    */


   public function setUp(): void
   {
      parent::setUp();
      User::factory()->times(10)->create();
      // Set up some test data
   }
   /** @test blank_b2c_register_email*/
   public function test_blank_b2c_register_email()
   {
      $data = [
         'email' => "",
         "password" => 'password',
      ];
      $response = $this->post('/b2cstore', $data);
      $response->assertStatus(302);
   }

   /** @test blank_b2c_register_email*/
   public function test_invalid_b2c_register_email()
   {
      $data = [
         'email' => "testing.com",
         "password" => 'password',
      ];
      $response = $this->post('/b2cstore', $data);
      $response->assertStatus(302);
   }

   /** @test blank_b2c_register_password*/
   public function test_blank_b2c_register_password()
   {
      $data = [
         'email' =>  $this->faker->email,
         'password' => ""
      ];
      $response = $this->post('/b2cstore', $data);
      $response->assertStatus(302);
   }

   /** @test unique_b2c_email*/
   public function test_unique_b2c_register_email()
   {
      $email = $this->faker->email;
      $name = explode("@", $email);
      $data = [
         'name' => $name[0],
         "email" => $email,
         "password" => 'password',
      ];
      $existingUser = User::create($data);
      $response = $this->post('/b2cstore', [
         'name' => $existingUser->name,
         'email' => $existingUser->email,
         "password" => 'password',
      ]);
      $response->assertStatus(302); // Ensure that the response is a redirect
      $response->assertSessionHasErrors(['email']);
   }

   /** @test test_before_verified_b2c_register*/
   public function test_before_verified_b2c_register()
   {

      //create role

      Role::insert([
        "id" => 2,
        "name" => "BC Subscriber",
      ]);
      $email = $this->faker->email;
      $name = explode("@", $email);
      $data = [
         'name' => $name[0],
         "email" => $email,
         "password" => 'password',
         "email_verified_at" => null
      ];

      $response = $this->post('/b2cstore', $data);
      $response->assertStatus(302);
   }

   /** @test test_after_verified_b2c_register*/
   public function test_after_verified_b2c_register()
   {

      $email = $this->faker->email;
      $name = explode("@", $email);
      $data = [
         'name' => $name[0],
         "email" => $email,
         "password" => 'password',
         "email_verified_at" => Carbon::now()
      ];
      $registerUser = User::create($data);
      $id = Crypt::encryptString($registerUser->id);
      $response = $this->get(route('verification', ['id' => $id]));
      $response->assertStatus(200);
   }

   /** @test testBlankLoginEmail*/
   public function testBlankLoginEmail()
   {
      $data = [
         "email" => "",
         "password" => 'password',
      ];
      $response = $this->post('login', $data);
      $response->assertStatus(302);
   }

   /** @test test_blank_login_password*/
   public function test_blank_login_password()
   {
      $data = [
         "email" => $this->faker->email,
         "password" => "",
      ];
      $response = $this->post('login', $data);
      $response->assertStatus(302);
   }

   /** @test test_invalid_login_email*/
   public function test_invalid_login_email()
   {
      $data = [
         'email' => "testing.com",
         "password" => Hash::make('password'),
      ];
      $response = $this->post('login', $data);
      $response->assertStatus(302);
   }

   /** @test test_mismatch_login_password*/
   public function test_mismatch_login_password()
   {
      $data = [
         'name' => $this->faker->name,
         'email' => "admin@admin.com",
         "password" => "password",
      ];
      $existingUser = User::create($data);


      $response = $this->post('login', [
         "email" => $existingUser->email,
         "password" => Hash::make('password')
      ]);


      $response->assertStatus(200);
   }

   /** @test test_match_login_password*/
   public function test_match_login_password()
   {
      $data = [
         'name' => $this->faker->name,
         'email' => "admin@admin.com",
         "password" => "password",
      ];
      $existingUser = User::create($data);
      $response = $this->post('login', [
         "email" => $existingUser->email,
         "password" => Hash::make('password')
      ]);
      $response->assertStatus(200);
   }


   /** @test test_match_login_password*/
   public function test_mismatch_login_password_and_email()
   {
      $data = [
         'name' => $this->faker->name,
         'email' => "admin@admin.com",
         "password" => "password",
      ];
      $existingUser = User::create($data);
      $response = $this->post('login', [
         "email" => "admin@user.com",
         "password" => Hash::make('password')
      ]);
      $response->assertStatus(200);
   }
}
