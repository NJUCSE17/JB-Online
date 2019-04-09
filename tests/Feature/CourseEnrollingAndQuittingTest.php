<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseEnrollingAndQuittingTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testRecordsWillBeRevokedIfCourseIsDeleted()
    {
        $user = factory(User::class)->create(
            [
                'privilege_level' => 2, // as a admin
            ]
        );
        $course = factory(Course::class)->create();

        $this->actingAs($user, 'api');

        // Enroll the user to the course.
        $this->post('/api/course/enroll',
            [
                'course_id' => $course->id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseHas('course_enroll_records',
            [
                'user_id'    => $user->id,
                'course_id'  => $course->id,
                'deleted_at' => null,
            ]
        );

        // Delete the course now.
        $this->delete('/api/course',
            [
                'course_id' => $course->id,
            ]
        )->assertStatus(200);
        $this->assertDatabaseMissing('courses', [
            'id'         => $course->id,
            'deleted_at' => null,
        ]);

        // The enroll record should be deleted.
        $this->assertDatabaseMissing('course_enroll_records',
            [
                'user_id'    => $user->id,
                'course_id'  => $course->id,
                'deleted_at' => null,
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
