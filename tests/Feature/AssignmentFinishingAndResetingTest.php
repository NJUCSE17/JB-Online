<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignmentFinishingAndResetingTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testRecordsWillBeRevokedIfAssignmentIsUpdated()
    {
        $user = factory(User::class)->create(
            [
                'privilege_level' => 2, // as a admin
            ]
        );
        $assignment = factory(Assignment::class)->create();

        $this->actingAs($user, 'api');

        // Enroll the user to the course.
        $this->post('/api/course/'.$assignment->course_id.'/enroll')
            ->assertStatus(200);
        $this->assertDatabaseHas('course_enroll_records',
            [
                'user_id'    => $user->id,
                'course_id'  => $assignment->course_id,
                'deleted_at' => null,
            ]
        );

        // Finish the assignment.
        $this->post('/api/assignment/'.$assignment->id.'/finish')
            ->assertStatus(200);
        $this->assertDatabaseHas('assignment_finish_records',
            [
                'user_id'       => $user->id,
                'assignment_id' => $assignment->id,
                'deleted_at'    => null,
            ]
        );

        // Update the assignment now.
        $this->put('/api/assignment/'.$assignment->id,
            [
                'content' => $this->faker->realText(200),
            ]
        )->assertStatus(200);

        // TODO: ASSERT EVENT AND NOTIFICATIONS
        // The records shall all be deleted after the update.
        $this->assertDatabaseMissing('assignment_finish_records',
            [
                'user_id'       => $user->id,
                'assignment_id' => $assignment->id,
                'deleted_at'    => null,
            ]
        );
    }

    public function testRecordsWillBeRevokedIfUserQuitsCourse()
    {
        $user = factory(User::class)->create();
        $assignment = factory(Assignment::class)->create();

        $this->actingAs($user, 'api');

        // Enroll the user to the course.
        $this->post('/api/course/'.$assignment->course_id.'/enroll')
            ->assertStatus(200);
        $this->assertDatabaseHas('course_enroll_records',
            [
                'user_id'    => $user->id,
                'course_id'  => $assignment->course_id,
                'deleted_at' => null,
            ]
        );

        // Finish the assignment.
        $this->post('/api/assignment/'.$assignment->id.'/finish')
            ->assertStatus(200);
        $this->assertDatabaseHas('assignment_finish_records',
            [
                'user_id'       => $user->id,
                'assignment_id' => $assignment->id,
                'deleted_at'    => null,
            ]
        );

        // Quit the course now.
        $this->post('/api/course/'.$assignment->course_id.'/quit')
            ->assertStatus(200);
        $this->assertDatabaseMissing('course_enroll_records',
            [
                'user_id'    => $user->id,
                'course_id'  => $assignment->course_id,
                'deleted_at' => null,
            ]
        );

        // The records shall all be deleted after the update.
        $this->assertDatabaseMissing('assignment_finish_records',
            [
                'user_id'       => $user->id,
                'assignment_id' => $assignment->id,
                'deleted_at'    => null,
            ]
        );
    }

    /**
     * Setup the test case.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');
    }
}
