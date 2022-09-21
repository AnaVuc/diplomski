<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\Concerns\WithTestUser;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_be_added()
    {
        $data = [
            'username' => 'Username',
            'email' => 'test@gmail.com',
            'password' => Hash::make('password'),
            'firstName' => 'Test',
            'lastName' => 'Testic',
            'role_id' => 1
        ];

        $response = $this->call('POST','api/createUser',$data);
        $this->assertDatabaseHas('users',[
            'email' => 'test@gmail.com'
        ]);

        $response->assertStatus(200);
    }

    public function test_role_can_be_added()
    {
        $data = [
            'name' => 'Admin',
        ];

        $response = $this->call('POST','api/createRole',$data);
        $this->assertDatabaseHas('roles',[
            'name' => 'Admin',
        ]);

        $response->assertSuccessful();
    }

    public function test_can_get_users()
    {
        User::factory(5)->create();
        $response = $this->call('GET','api/getUsers');
        $this->assertDatabaseCount('users',User::all()->count());
        $response->assertStatus(200);
    }

    public function test_can_get_roles()
    {
        Role::factory(5)->create();
        $response = $this->call('GET','api/getRoles');
        $this->assertDatabaseCount('roles',Role::all()->count());
        $response->assertStatus(200);
    }

    public function test_can_get_permission()
    {
        Permission::factory(5)->create();
        $response = $this->call('GET','api/getPermissions');
        $this->assertDatabaseCount('permissions',Permission::all()->count());
        $response->assertStatus(200);
    }

    public function test_can_find_user_by_username()
    {
        $user = User::factory()->create();
        $response = $this->call('GET','api/userByUsername',['username'=>$user->username]);
        $r=(json_decode($response->content()));
        $this->assertNotEmpty($r);
        $response->assertStatus(200);

    }

    public function test_user_can_be_deleted()
    {
        $user = User::factory()->create();

        $response = $this->delete('api/deleteUser',['id'=>$user->id]);
        $this->assertDatabaseMissing('users',[
            'email' => $user->email
        ]);
        $this->assertDatabaseCount('users',0);
        $response->assertStatus(200);
    }

    public function test_role_can_be_deleted()
    {
        $role = Role::factory()->create();

        $response = $this->delete('api/deleteRole',['id'=>$role->id]);
        $this->assertDatabaseMissing('roles',[
            'name' => $role->name
        ]);
        $this->assertDatabaseCount('roles',0);
        $response->assertStatus(204);
    }
    public function test_user_can_be_updated()
    {
        $user = User::factory()->create();
        $params=[
            'username' => $user->username,
            'email' => $user->email,
            'password' => $user->password,
            'firstName' => 'new first name',
            'lastName' => $user->lastName,
            'role_id' => $user->role_id,
            'id' => $user->id,
        ];
        $response = $this->call('POST','api/updateUser',$params)
        ->assertSuccessful()
        ->assertJsonFragment(['firstName' =>'new first name']);
    }

    public function test_role_can_be_updated()
    {
        $role = Role::factory()->create();
        $params=[
            'name' => 'new',
            'id' => $role->id,
        ];
        $response = $this->call('POST','api/updateRole',$params)
        ->assertSuccessful()
        ->assertJsonFragment(['name' => 'new']);
    }
}
