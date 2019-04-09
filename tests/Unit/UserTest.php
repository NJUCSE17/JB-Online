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

    public function testUserFunctions()
    {
        $this->unauthorizedUserCannotPerformOperations();

        $this->userCanViewItsInfo();
        $this->userCanViewOthersInfo();
        $this->adminCanViewUsersInfo();

        $this->userCanEditItsInfo();
        $this->userWillBeDeactivedIfEmailEdited();
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
                'data'    => $this->getUserData($this->user),
            ]);
    }

    protected function getUserData(User $user)
    {
        return [
            'id'         => $user->id,
            'student_id' => $user->student_id,
            'name'       => $user->name,
            'email'      => $user->email,
            'blog'       => $user->blog,
            'verified'   => $user->isVerified(),
            'active'     => $user->isActive(),
        ];
    }

    protected function userCanViewOthersInfo()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/user?user_id='.$this->admin->id)
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->getUserData($this->admin),
            ]);
    }

    protected function adminCanViewUsersInfo()
    {
        $this->actingAs($this->admin, 'api');
        $this->get('/api/user?user_id='.$this->user->id)
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->getUserData($this->user),
            ]);
    }

    protected function userCanEditItsInfo()
    {
        $this->actingAs($this->user, 'api');
        $this->put('/api/user',
            [
                'name' => $this->faker->name,
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->getUserData($this->user),
            ]);
        $this->assertDatabaseHas('users', [
            'id'         => $this->user->id,
            'name'       => $this->user->name,
            'deleted_at' => null,
        ]);
    }

    protected function userWillBeDeactivedIfEmailEdited()
    {
        $this->actingAs($this->user, 'api');
        $this->put('/api/user',
            [
                'email' => $this->faker->safeEmail,
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->getUserData($this->user),
            ]);
        $this->assertDatabaseHas('users', [
            'id'                => $this->user->id,
            'name'              => $this->user->name,
            'email_verified_at' => null,
            'activated_at'      => null,
            'deleted_at'        => null,
        ]);
    }

    protected function userCannotEditOthersInfo()
    {
        $this->actingAs($this->user, 'api');
        $this->put('/api/user',
            [
                'user_id' => $this->admin->id,
                'name'    => $this->faker->name,
            ]
        )->assertStatus(403);
    }

    protected function adminCannotEditOthersInfo()
    {
        $this->actingAs($this->admin, 'api');
        $this->put('/api/user',
            [
                'user_id' => $this->user->id,
                'name'    => $this->faker->name,
            ]
        )->assertStatus(403);
    }

    protected function superAdminCanEditOthersInfo()
    {
        $this->actingAs($this->super_admin, 'api');
        $this->user->name = $this->faker->name;
        $this->put('/api/user',
            [
                'user_id' => $this->user->id,
                'name'    => $this->user->name,
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->getUserData($this->user),
            ]);
    }

    protected function userCannotActivateUser()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/user/activate',
            [
                'user_id' => $this->user->id,
            ]
        )->assertStatus(403);
    }

    protected function adminCannotActivateUser()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/user/activate',
            [
                'user_id' => $this->user->id,
            ]
        )->assertStatus(403);
    }

    protected function superAdminCanActivateUser()
    {
        $this->actingAs($this->super_admin, 'api');
        $this->post('/api/user/activate',
            [
                'user_id' => $this->user->id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id'           => $this->user->id,
            'activated_at' => null,
            'deleted_at'   => null,
        ]);
    }

    protected function userCannotDeactivateUser()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/user/deactivate',
            [
                'user_id' => $this->user->id,
            ]
        )->assertStatus(403);
    }

    protected function adminCannotDeactivateUser()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/user/deactivate',
            [
                'user_id' => $this->user->id,
            ]
        )->assertStatus(403);
    }

    protected function superAdminCanDeactivateUser()
    {
        $this->actingAs($this->super_admin, 'api');
        $this->post('/api/user/deactivate',
            [
                'user_id' => $this->user->id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseHas('users', [
            'id'           => $this->user->id,
            'activated_at' => null,
            'deleted_at'   => null,
        ]);
    }

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
}
