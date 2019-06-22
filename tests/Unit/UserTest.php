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

    protected function userCanViewItsInfo()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/user/'.$this->user->id)
            ->assertStatus(200)
            ->assertExactJson($this->getUserData($this->user));
    }

    protected function getUserData(User $user)
    {
        return [
            'id'              => $user->id,
            'student_id'      => $user->student_id,
            'name'            => $user->name,
            'email'           => $user->email,
            'want_email'      => $user->want_email,
            'blog_feed_url'   => $user->blog_feed_url,
            'is_verified'     => $user->isVerified(),
            'is_active'       => $user->isActive(),
            'privilege_level' => $user->privilege_level,
        ];
    }

    protected function userCanViewOthersInfo()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/user/'.$this->admin->id)
            ->assertStatus(200)
            ->assertExactJson($this->getUserData($this->admin));
    }

    protected function adminCanViewUsersInfo()
    {
        $this->actingAs($this->admin, 'api');
        $this->get('/api/user/'.$this->user->id)
            ->assertStatus(200)
            ->assertExactJson($this->getUserData($this->user));
    }

    protected function userCanEditItsInfo()
    {
        $this->actingAs($this->user, 'api');
        $data = $this->getUserData($this->user);
        $data['name'] = $this->faker->name;
        $this->put('/api/user/'.$this->user->id,
            [
                'name'     => $data['name'],
                'password' => 'password',
            ]
        )->assertStatus(200)
            ->assertExactJson($data);
        $this->user->name = $data['name'];
        $this->assertDatabaseHas('users', [
            'id'         => $this->user->id,
            'name'       => $this->user->name,
            'deleted_at' => null,
        ]);
    }

    protected function userWillBeDeactivedIfEmailEdited()
    {
        $this->actingAs($this->user, 'api');
        $data = $this->getUserData($this->user);

        $data['email'] = $this->faker->safeEmail;
        $data['is_active'] = false;
        $data['is_verified'] = false;

        $this->put('/api/user/'.$this->user->id,
            [
                'email'    => $data['email'],
                'password' => 'password',
            ]
        )->assertStatus(200)
            ->assertExactJson($data);

        $this->user->email = $data['email'];
        $this->user->activated_at = null;
        $this->user->email_verified_at = null;

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
        $this->put('/api/user/'.$this->admin->id,
            [
                'name' => $this->faker->name,
            ]
        )->assertStatus(403);
    }

    protected function adminCannotEditOthersInfo()
    {
        $this->actingAs($this->admin, 'api');
        $this->put('/api/user/'.$this->user->id,
            [
                'name' => $this->faker->name,
            ]
        )->assertStatus(403);
    }

    protected function superAdminCanEditOthersInfo()
    {
        $this->actingAs($this->super_admin, 'api');
        $this->user->name = $this->faker->name;
        $this->put('/api/user/'.$this->user->id,
            [
                'name' => $this->user->name,
                // no password required
            ]
        )->assertStatus(200)
            ->assertExactJson($this->getUserData($this->user));
    }

    protected function userCannotActivateUser()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/user/'.$this->user->id.'/activate')
            ->assertStatus(403);
    }

    protected function adminCannotActivateUser()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/user/'.$this->user->id.'/activate')
            ->assertStatus(403);
    }

    protected function superAdminCanActivateUser()
    {
        $this->actingAs($this->super_admin, 'api');
        $this->post('/api/user/'.$this->user->id.'/activate')
            ->assertStatus(200);
        $this->assertDatabaseMissing('users', [
            'id'           => $this->user->id,
            'activated_at' => null,
            'deleted_at'   => null,
        ]);
    }

    protected function userCannotDeactivateUser()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/user/'.$this->user->id.'/deactivate')
            ->assertStatus(403);
    }

    protected function adminCannotDeactivateUser()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/user/'.$this->user->id.'/deactivate')
            ->assertStatus(403);
    }

    protected function superAdminCanDeactivateUser()
    {
        $this->actingAs($this->super_admin, 'api');
        $this->post('/api/user/'.$this->user->id.'/deactivate')
            ->assertStatus(200);
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
        $this->admin->save();
        $this->super_admin = factory(User::class)->create();
        $this->super_admin->privilege_level = 1;
        $this->admin->save();

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
