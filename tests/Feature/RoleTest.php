<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Database\Factories\UserFactory;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Src\BlendedConcept\User\Domain\Model\Permission;
use Src\BlendedConcept\User\Domain\Model\Role;
use Src\BlendedConcept\User\Domain\Model\User;


class RoleTest extends TestCase
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

        // Set up some test data
    }

    /** @test blank_role_name*/
    public function test_blank_role_name()
    {
        $data = [
            "name" => "",
            "description" => $this->faker->text,
        ];
        $response = $this->post(route('roles.store'), $data);
        $response->assertStatus(302);
    }
}
