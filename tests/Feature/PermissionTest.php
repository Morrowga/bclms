<?php

namespace Tests\Feature;

use Tests\TestCase;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Src\BlendedConcept\User\Domain\Model\Role;
use Src\BlendedConcept\User\Domain\Model\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Src\BlendedConcept\User\Domain\Model\Permission;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PermissionTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    protected function getAdminUser()
    {
        $admin = UserFactory::factory()->create();
        // $adminRole = Role::factory()->create(['name' => 'admin']);
        // $permissions = Permission::all();
        // $adminRole->permissions()->sync($permissions);
        // $admin->roles()->sync([$adminRole->id]);

        dd($admin);
    }
    protected function setUp(): void
    {
        parent::setUp();

        dd($this->getAdminUser());
        // Create a test user and log them in

        // Auth::login($user);
    }


    /** @test create*/
    // public function test_user_can_be_created()
    // {

    // dd($this->getAdminUser());
    // $permissionData = [
    //     'name' => $this->faker->name,
    //     'guard_name' => 'web',
    // ];

    // $response = $this->actingAs($this->getAdminUser())->post('/permissions', $permissionData);

    // $response->assertStatus(201);

    // $this->assertDatabaseHas('permissions', [
    //     'name' => $userData['name'],
    //     'guard_name' => 'web'
    // ]);
    // // $this->authorize('view', Permission::class);
    // $role = RoleFactory::new(['id'=> 1, 'name' => 'user']);

    // $permission = PermissionFactory::new(['id' => 1, 'name' => 'create_permission']);

    // $role->permissions()->sync([$permission->id]);

    // auth()->user()->roles()->sync([$role->id]);

    // $permissionData = [
    //     'name' => $this->faker->name,
    //     'guard' => 'web'
    // ];

    // $response = $this->post('/permissions', $permissionData);

    // $response->assertStatus(201);

    // $this->assertDatabaseHas('permissions', [
    //     'name' => $permissionData['name'],
    //     'web' => 'web'
    // ]);
    // }
}
