<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Src\BlendedConcept\User\Domain\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Src\BlendedConcept\User\Domain\Factories\UserFactory;

class PermissionTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user and log them in
        $user = UserFactory::new([
            "email" => "superadmin@mail.com",
            "password" => "password"
        ]);

        Auth::login($user);
    }

    
    /** @test create*/
    public function permission_create()
    {
        $attributes = [
            'name' => $this->faker->sentence,
            'guard_name' => 'web',
        ];

        $response = $this->post('/permissions', $attributes);

        $response->assertRedirect('/permissions');

        $this->assertDatabaseHas('permissions', $attributes);
    }
}
