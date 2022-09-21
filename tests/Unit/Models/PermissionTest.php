<?php

namespace Tests\Unit\Entities;

use App\Models\Like;
use App\Models\Permission;
use App\Models\Review;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    protected $permission;
    protected $role;

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
    }
    public function test_permission_belong_to_many_roles()
    {
        $this->permission->roles()->sync($this->role);
        $this->assertDatabaseHas('permission_role', [
            'permission_id' => $this->permission->id,
            'role_id' => $this->role->id
        ]);
    }
}
