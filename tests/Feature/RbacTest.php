<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RbacTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolePermissionSeeder::class);
    }

    public function test_user_without_role_is_denied(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/access/roles')->assertForbidden();
    }

    public function test_staf_can_view_roles_but_not_activity(): void
    {
        $user = User::factory()->create();
        $user->assignRole('staf'); // staf has users.view only

        $this->actingAs($user)->get('/access/roles')->assertOk();
        $this->actingAs($user)->get('/access/activity')->assertForbidden();
    }

    public function test_admin_can_view_everything(): void
    {
        $user = User::factory()->create();
        $user->assignRole('admin'); // admin has all permissions

        $this->actingAs($user)->get('/access/roles')->assertOk();
        $this->actingAs($user)->get('/access/activity')->assertOk();
    }
}
