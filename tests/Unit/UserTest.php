<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\PersonalAssignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $user = null;
    private $admin = null;
    private $super_admin = null;
    private $assignment = null;
    private $personal_assignment = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');

        $this->user = factory(User::class)->create();
        $this->admin = factory(User::class)->create();
        $this->admin->privilege_level = 2;
        $this->super_admin = factory(User::class)->create();
        $this->super_admin->privilege_level = 1;

        $this->assignment = factory(Assignment::class)->create();
        DB::table('course_enroll_records')->insert([
            'user_id'       => $this->user->id,
            'course_id'     => $this->assignment->course_id,
            'type_is_admin' => false,
        ]);

        $this->personal_assignment
            = factory(PersonalAssignment::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    public function testUserFunctions()
    {
        $this->unauthorizedUserCannotPerformOperations();

        $this->userCanViewItsInfo();
        $this->userCanViewOthersInfo();
        $this->adminCanViewUsersInfo();

        $this->userCanEditItsInfo();
        $this->userCannotEditOthersInfo();
        $this->adminCannotEditOthersInfo();
        $this->superAdminCanEditOthersInfo();

        $this->userCannotActivateUser();
        $this->adminCannotActivateUser();
        $this->superAdminCanActivateUser();

        $this->userCannotDeactivateUser();
        $this->adminCannotDeactivateUser();
        $this->superAdminCanDeactivateUser();
    }

    protected function unauthorizedUserCannotPerformOperations()
    {
        $this->get('/api/user')->assertStatus(401);
        $this->post('/api/user')->assertStatus(401);
        $this->put('/api/user')->assertStatus(401);
        $this->delete('/api/user')->assertStatus(401);
    }

    protected function userCanViewItsInfo()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/user')
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->user,
            ]);
    }

    protected function userCanViewOthersInfo()
    {
        $this->actingAs($this->user, 'api');
    }

    protected function adminCanViewUsersInfo()
    {
        $this->actingAs($this->admin, 'api');
    }

    protected function userCanEditItsInfo()
    {
        $this->actingAs($this->user, 'api');
    }

    protected function userCannotEditOthersInfo()
    {
        $this->actingAs($this->user, 'api');
    }

    protected function adminCannotEditOthersInfo()
    {
        $this->actingAs($this->admin, 'api');
    }

    protected function superAdminCanEditOthersInfo()
    {
        $this->actingAs($this->super_admin, 'api');
    }

    protected function userCannotActivateUser()
    {
        $this->actingAs($this->user, 'api');

    }

    protected function adminCannotActivateUser()
    {
        $this->actingAs($this->admin, 'api');

    }

    protected function superAdminCanActivateUser()
    {
        $this->actingAs($this->super_admin, 'api');

    }

    protected function userCannotDeactivateUser()
    {
        $this->actingAs($this->user, 'api');

    }

    protected function adminCannotDeactivateUser()
    {
        $this->actingAs($this->admin, 'api');

    }

    protected function superAdminCanDeactivateUser()
    {
        $this->actingAs($this->super_admin, 'api');

    }
}
