<?php

namespace Tests\Feature\Backend\Role;

use Tests\TestCase;
use App\Models\Auth\Role;
use Illuminate\Support\Facades\Event;
use App\Events\Backend\Auth\Role\RoleDeleted;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DeleteRoleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_role_can_be_deleted()
    {
        $role = factory(Role::class)->create();
        $this->loginAsAdmin();

        $this->assertDatabaseHas(config('permission.table_names.roles'), ['id' => $role->id]);

        $this->delete("/admin/auth/role/{$role->id}");

        $this->assertDatabaseMissing(config('permission.table_names.roles'), ['id' => $role->id]);
    }

    /** @test */
    public function an_event_gets_dispatched()
    {
        $role = factory(Role::class)->create();
        Event::fake();
        $this->loginAsAdmin();

        $this->delete("/admin/auth/role/{$role->id}");

        Event::assertDispatched(RoleDeleted::class);
    }
}
