<?php

namespace Tests\Feature\Unit;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $parser = null;
    private $user = null;
    private $course_admin = null;
    private $admin = null;
    private $course = null;

    /**
     * Setup the test case.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new \Parsedown();
        $this->withHeader('Accept', 'application/json');

        $this->user = factory(User::class)->create();
        $this->course_admin = factory(User::class)->create();
        $this->admin = factory(User::class)->create();
        $this->admin->privilege_level = 2;
        $this->course = factory(Course::class)->create();
    }

    /**
     * Test Course CRUD Functions
     */
    public function testCourseFunctions()
    {
        $this->noCoursesAtFirst();
        $this->userCannotCreateCourse();
        $this->adminCanCreateCourse();
        // $this->userCanViewCourse();
        // $this->userCanViewSpecificCourse();
        // $this->userCanEnrollCourse();
        // $this->userCanQuitCourse();
        // $this->userCanBeSetAsCourseAdmin();
        // $this->userCannotUpdateCourse();
        // $this->adminCanUpdateCourse();
        // $this->courseAdminCanUpdateCourse();
        // $this->userCannotDeleteCourse();
        // $this->courseAdminCannotDeleteCourse();
        // $this->adminCanDeleteCourse();
    }

    public function noCoursesAtFirst()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/course')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [],
                ]
            );
    }

    public function userCannotCreateCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/course',
            [
                'name'       => $this->course->name,
                'semester'   => $this->course->semester,
                'start_time' => $this->course->start_time,
                'end_time'   => $this->course->end_time,
                'notice'     => $this->course->notice,
            ]
        )->assertStatus(403);
    }

    public function adminCanCreateCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/course',
            [
                'name'       => $this->course->name,
                'semester'   => $this->course->semester,
                'start_time' => $this->course->start_time,
                'end_time'   => $this->course->end_time,
                'notice'     => $this->course->notice,
            ]
        )->assertStatus(403)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [$this->course],
                ]
            );
    }
}
