<?php

namespace Tests\Feature\Unit;

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

        $notice = $this->faker->paragraph;
        $this->course = [
            'id'          => 1,
            'name'        => $this->faker->realText(20),
            'semester'    => $this->faker->numberBetween(1, 10),
            'start_time'  => $this->faker->dateTimeBetween('-1 year', 'now')->format(
                'Y-m-d H:i:s'
            ),
            'end_time'    => $this->faker->dateTimeBetween('now', '+1 year')->format(
                'Y-m-d H:i:s'
            ),
            'notice'      => $notice,
            'notice_html' => $this->parser->text($notice),
            'assignments' => [],
        ];
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
                'name'       => $this->course['name'],
                'semester'   => $this->course['semester'],
                'start_time' => $this->course['start_time'],
                'end_time'   => $this->course['end_time'],
                'notice'     => $this->course['notice'],
            ]
        )->assertStatus(403);
    }

    public function adminCanCreateCourse()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/course',
            [
                'name'       => $this->course['name'],
                'semester'   => $this->course['semester'],
                'start_time' => $this->course['start_time'],
                'end_time'   => $this->course['end_time'],
                'notice'     => $this->course['notice'],
            ]
        )->assertStatus(201)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->course,
                ]
            );
    }
}
