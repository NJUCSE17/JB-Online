<?php

namespace Tests\Feature\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
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
            'id'          => DB::select("SHOW TABLE STATUS LIKE 'courses'")[0]->Auto_increment,
            'name'        => $this->faker->realText(20),
            'semester'    => $this->faker->numberBetween(1, 10),
            'start_time'  => $this->faker->dateTimeBetween('-1 year', 'now')
                ->format(
                    'Y-m-d H:i:s'
                ),
            'end_time'    => $this->faker->dateTimeBetween('now', '+1 year')
                ->format(
                    'Y-m-d H:i:s'
                ),
            'notice'      => $notice,
            'notice_html' => $this->parser->text($notice),
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
        $this->userCanViewCourses();
        $this->userCanFilterCourses();
        $this->userCanViewSpecificCourse();
        $this->userCanEnrollCourse();
        $this->userCanQuitCourse();
        $this->userCanNotJoinAsCourseAdmin();
        $this->userCanBeSetAsCourseAdmin();
        $this->userCannotUpdateCourse();
        $this->adminCanUpdateCourse();
        $this->courseAdminCanUpdateCourse();
        $this->userCannotDeleteCourse();
        $this->courseAdminCannotDeleteCourse();
        $this->adminCanDeleteCourse();
    }

    protected function noCoursesAtFirst()
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

    protected function userCannotCreateCourse()
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

    protected function adminCanCreateCourse()
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

    protected function userCanViewCourses()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/course')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [$this->course],
                ]
            );
    }

    protected function userCanFilterCourses()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/course?semester='.$this->course['semester'])
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [$this->course],
                ]
            );
        $this->get('/api/course?semester='.($this->course['semester'] + 1))
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [],
                ]
            );
    }

    protected function userCanViewSpecificCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/course?course_id=' . $this->course['id'])
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->course,
                ]
            );
    }

    protected function userCanEnrollCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/course/enroll',
            [
                'course_id' => $this->course['id'],
            ]
        )
            ->assertStatus(200)
            ->assertJson( // not an exact assertion
                [
                    'success' => true,
                    'data'    => [
                        'user_id'       => $this->user->id,
                        'course_id'     => $this->course['id'],
                        'type_is_admin' => false,
                    ],
                ]
            );
        $this->assertDatabaseHas('course_enroll_records',
            [
                'user_id'       => $this->user->id,
                'course_id'     => $this->course['id'],
                'type_is_admin' => false,
            ]
        );
    }

    protected function userCanQuitCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/course/quit',
            [
                'course_id' => $this->course['id'],
            ]
        )
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => 'Course quited.',
                ]
            );
        $this->assertDatabaseMissing('course_enroll_records',
            [
                'user_id'   => $this->user->id,
                'course_id' => $this->course['id'],
            ]
        );
    }

    protected function userCanNotJoinAsCourseAdmin()
    {
        $this->actingAs($this->course_admin, 'api');
        $this->assertDatabaseMissing('course_enroll_records',
            [
                'user_id'   => $this->course_admin->id,
                'course_id' => $this->course['id'],
            ]
        );
        $this->post('/api/course/enroll',
            [
                'user_id'   => $this->course_admin->id,
                'course_id' => $this->course['id'],
            ]
        )->assertStatus(403);
        $this->post('/api/course/enroll',
            [
                'course_id'     => $this->course['id'],
                'type_is_admin' => true,
            ]
        )->assertStatus(403);
    }

    protected function userCanBeSetAsCourseAdmin()
    {
        $this->actingAs($this->admin, 'api');
        $this->assertDatabaseMissing('course_enroll_records',
            [
                'user_id'   => $this->course_admin->id,
                'course_id' => $this->course['id'],
            ]
        );
        $this->post('/api/course/enroll',
            [
                'user_id'       => $this->course_admin->id,
                'course_id'     => $this->course['id'],
                'type_is_admin' => true,
            ]
        )->assertStatus(200)
            ->assertJson(
                [
                    'success' => true,
                    'data'    => [
                        'user_id'       => $this->course_admin->id,
                        'course_id'     => $this->course['id'],
                        'type_is_admin' => true,
                    ],
                ]
            );
        $this->assertDatabaseHas('course_enroll_records',
            [
                'user_id'       => $this->course_admin->id,
                'course_id'     => $this->course['id'],
                'type_is_admin' => true,
            ]
        );
    }

    protected function userCannotUpdateCourse()
    {
        $this->actingAs($this->user, 'api');
        $notice = $this->faker->paragraph;
        $this->course['notice'] = $notice;
        $this->course['notice_html'] = $this->parser->text($notice);
        $this->put('/api/course',
            [
                'course_id' => $this->course['id'],
                'notice' => $notice,
            ]
        )->assertStatus(403);
    }

    protected function adminCanUpdateCourse()
    {
        $this->actingAs($this->admin, 'api');
        $notice = $this->faker->paragraph;
        $this->course['notice'] = $notice;
        $this->course['notice_html'] = $this->parser->text($notice);
        $this->put('/api/course',
            [
                'course_id' => $this->course['id'],
                'notice' => $notice,
            ]
        )->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->course,
                ]
            );
    }

    protected function courseAdminCanUpdateCourse()
    {
        $this->actingAs($this->course_admin, 'api');
        $this->course['semester'] = $this->faker->numberBetween(1, 10);
        $this->put('/api/course',
            [
                'course_id' => $this->course['id'],
                'semester'  => $this->course['semester'],
            ]
        )->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->course,
                ]
            );
    }

    protected function userCannotDeleteCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->delete('/api/course',
            [
                'course_id' => $this->course['id'],
            ]
        )->assertStatus(403);
    }

    protected function courseAdminCannotDeleteCourse()
    {
        $this->actingAs($this->course_admin, 'api');
        $this->delete('/api/course',
            [
                'course_id' => $this->course['id'],
            ]
        )->assertStatus(403);
    }

    protected function adminCanDeleteCourse()
    {
        $this->actingAs($this->admin, 'api');
        $this->delete('/api/course',
            [
                'course_id' => $this->course['id'],
            ]
        )->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => 'Course deleted.',
                ]
            );
        $this->assertDatabaseMissing('courses', [
            'id' => $this->course['id'],
        ]);
    }
}
