<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\User\Domain\Model\User;

class AuthTest extends TestCase
{
   use RefreshDatabase, WithFaker;
   /**
    * A basic feature test example.
    *
    * @return void
    */

   /** @test create*/
   public function test_blank_b2b_name()
   {
      $data = [
         'email' => "",
         'password' => "12345678"
      ];
      $response = $this->post('/b2cstore', $data);
      $response->assertStatus(500);
   }

   /** @test create*/
   public function test_blank_b2b_password()
   {
      $data = [
         'email' => "admin@admin.com",
         'password' => ""
      ];
      $response = $this->post('/b2cstore', $data);
      $response->assertStatus(500);
   }

   /** @test create*/
   public function test_unique_b2b_email()
   {
      $existingUser = User::factory()->create();
      $response = $this->post('/b2cstore', [
         'name' => $this->faker->name,
         'email' => $existingUser->email,
         'password' => Hash::make('password'),
         'password_confirmation' => Hash::make('password'),
      ]);
      $response->assertStatus(302); // Ensure that the response is a redirect
      $response->assertSessionHasErrors(['email']);
   }
}
