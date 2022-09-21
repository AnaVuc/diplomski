<?php

namespace Tests\Unit\Entities;

use App\Models\Like;
use App\Models\Permission;
use App\Models\Review;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    protected $permission;
    protected $role;
    protected $users;

    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function setUp() :void
    {
        parent::setUp();
        $this->role = Role::factory()->create();
        $this->permission = Permission::factory()->create();
        $this->users = User::factory()->create();
    }
    public function test_role_belong_to_many_permissions()
    {
        $this->role->permissions()->sync($this->permission);
        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $this->permission->id,
            'role_id' => $this->role->id
        ]);
    }
}
