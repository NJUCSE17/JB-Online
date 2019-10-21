<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseEnrollRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var \Parsedown|null
     */
    private $parser = null;
    private $user = null;
    private $admin = null;
    private $course = null;
    private $assignments = array();

    /**
     * Test Assignment CRUD Functions
     */
    public function testAssignmentFunctions()
    {
        $this->assignmentsAreEmptyAtFirst();

        $this->userCannotCreateAssignment();
        $this->courseAdminCanCreateAssignment();
        $this->adminCanCreateAssignment();

        $this->userCanViewAssignmentsOfEnrolledCourses();
        $this->userCanViewSpecificAssignment();

        $this->userCannotUpdateAssignment();
        $this->courseAdminCanUpdateAssignment();

        $this->userCannotDeleteAssignment();
        $this->courseAdminCanDeleteAssignment();

        $this->userCannotFinishAssignmentIfNotEnrolledInCourse();
        $this->userCanFinishAssignmentIfEnrolledInCourse();
        $this->finishedAssignmentsAreHiddenIfRequired();
        $this->userCannotResetAssignmentIfNotEnrolledInCourse();
        $this->userCanResetAssignmentIfEnrolledInCourse();
    }

    protected function assignmentsAreEmptyAtFirst()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson([]);
    }

    protected function userCannotCreateAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->post(
            '/api/assignment',
            [
                'course_id' => $this->assignments[0]['course_id'],
                'name'      => $this->assignments[0]['name'],
                'content'   => $this->assignments[0]['content'],
                'due_time'  => $this->assignments[0]['due_time'],
            ]
        )->assertStatus(403);
    }

    protected function courseAdminCanCreateAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[0]['course_id'],
            true);
        $this->post(
            '/api/assignment',
            [
                'course_id' => $this->assignments[0]['course_id'],
                'name'      => $this->assignments[0]['name'],
                'content'   => $this->assignments[0]['content'],
                'due_time'  => $this->assignments[0]['due_time'],
            ]
        )->assertStatus(201);
        $this->quit($this->user->id, $this->assignments[0]['course_id']);

        // Check the assignment is correctly created.
        $this->assertDatabaseHas('assignments', [
            'course_id'  => $this->assignments[0]['course_id'],
            'name'       => $this->assignments[0]['name'],
            'content'    => $this->assignments[0]['content'],
            'due_time'   => $this->assignments[0]['due_time'],
            'deleted_at' => null,
        ]);
    }

    /**
     * Enroll a user to a course.
     *
     * @param $user_id
     * @param $course_id
     */
    private function enroll($user_id, $course_id, $as_admin)
    {
        CourseEnrollRecord::query()->create(
            [
                'user_id'       => $user_id,
                'course_id'     => $course_id,
                'type_is_admin' => $as_admin,
            ]
        );
    }

    /**
     * Quit a user from a course.
     *
     * @param $user_id
     * @param $course_id
     */
    private function quit($user_id, $course_id)
    {
        CourseEnrollRecord::query()
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->delete();
    }

    protected function adminCanCreateAssignment()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/assignment',
            [
                'course_id' => $this->assignments[1]['course_id'],
                'name'      => $this->assignments[1]['name'],
                'content'   => $this->assignments[1]['content'],
                'due_time'  => $this->assignments[1]['due_time'],
            ]
        )->assertStatus(201);

        // Check the assignments have been created
        $this->assertDatabaseHas('assignments', [
            'course_id'  => $this->assignments[1]['course_id'],
            'name'       => $this->assignments[1]['name'],
            'content'    => $this->assignments[1]['content'],
            'due_time'   => $this->assignments[1]['due_time'],
            'deleted_at' => null,
        ]);
    }

    protected function userCanViewAssignmentsOfEnrolledCourses()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson([]);

        $this->enroll($this->user->id, $this->assignments[0]['course_id'],
            false);
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson($this->assignments);
        $this->quit($this->user->id, $this->assignments[0]['course_id']);
    }

    protected function userCanViewSpecificAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/assignment/'.$this->assignments[0]['id'])
            ->assertStatus(200)
            ->assertExactJson($this->assignments[0]);
    }

    protected function userCannotUpdateAssignment()
    {
        $this->assignments[0]['content'] = $this->faker->paragraph(2);
        $this->assignments[0]['content_html'] = $this->parser->text(
            $this->assignments[0]['content']
        );
        $this->assignments[0]['due_time'] = $this->faker->dateTimeInInterval(
            'now',
            '+5 days'
        )->format('Y-m-d H:i:s');

        $this->actingAs($this->user, 'api');
        $this->put('/api/assignment/'.$this->assignments[0]['id'],
            [
                'content'  => $this->assignments[0]['content'],
                'due_time' => $this->assignments[0]['due_time'],
            ]
        )->assertStatus(403);
    }

    protected function courseAdminCanUpdateAssignment()
    {
        $this->assignments[0]['content'] = $this->faker->paragraph(2);
        $this->assignments[0]['content_html'] = $this->parser->text(
            $this->assignments[0]['content']
        );
        $this->assignments[0]['due_time'] = $this->faker->dateTimeInInterval(
            'now',
            '+5 days'
        )->format('Y-m-d H:i:s');

        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[0]['course_id'],
            true);
        $this->put(
            '/api/assignment/'.$this->assignments[0]['id'],
            [
                'content'  => $this->assignments[0]['content'],
                'due_time' => $this->assignments[0]['due_time'],
            ]
        )->assertStatus(200);
        $this->quit($this->user->id, $this->assignments[0]['course_id']);

        // Check the assignments have been updated
        $this->assertDatabaseHas('assignments', [
            'course_id'  => $this->assignments[0]['course_id'],
            'name'       => $this->assignments[0]['name'],
            'content'    => $this->assignments[0]['content'],
            'due_time'   => $this->assignments[0]['due_time'],
            'deleted_at' => null,
        ]);
    }

    protected function userCannotDeleteAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->delete('/api/assignment/'.$this->assignments[0]['id'])
            ->assertStatus(403);
    }

    protected function courseAdminCanDeleteAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[0]['course_id'],
            true);
        $this->delete('/api/assignment/'.$this->assignments[0]['id'])
            ->assertStatus(204);
        $this->quit($this->user->id, $this->assignments[0]['course_id']);

        // Check the assignments have been deleted
        $this->assertDatabaseMissing('assignments', [
            'id'         => $this->assignments[0]['id'],
            'deleted_at' => null,
        ]);
    }

    protected function userCannotFinishAssignmentIfNotEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
        $this->post('/api/assignment/'.$this->assignments[1]['id'].'/finish')
            ->assertStatus(403);
    }

    protected function userCanFinishAssignmentIfEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[1]['course_id'],
            false);
        $this->post('/api/assignment/'.$this->assignments[1]['id'].'/finish',
            [
                'is_ongoing' => true,
            ]
        )->assertStatus(200)
            ->assertJson(
                [ // not an exact check
                    'user_id'       => $this->user->id,
                    'assignment_id' => $this->assignments[1]['id'],
                    'is_ongoing'    => true,
                ]
            );
        $this->post('/api/assignment/'.$this->assignments[1]['id'].'/finish')
            ->assertStatus(200)
            ->assertJson(
                [ // not an exact check
                    'user_id'       => $this->user->id,
                    'assignment_id' => $this->assignments[1]['id'],
                    'is_ongoing'    => false,
                ]
            );
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
    }

    protected function finishedAssignmentsAreHiddenIfRequired()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[1]['course_id'],
            false);
        $this->get('/api/assignment?unfinished_only=1')
            ->assertStatus(200)
            ->assertExactJson([]);
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
    }

    protected function userCannotResetAssignmentIfNotEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
        $this->post('/api/assignment/'.$this->assignments[1]['id'].'/reset')
            ->assertStatus(403);
    }

    protected function userCanResetAssignmentIfEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[1]['course_id'],
            false);
        $this->post('/api/assignment/'.$this->assignments[1]['id'].'/reset')
            ->assertStatus(204);
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
    }

    /**
     * Setup the test case.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new \Parsedown();
        $this->withHeader('Accept', 'application/json');

        $this->user = factory(User::class)->create();
        $this->admin = factory(User::class)->create();
        $this->admin->privilege_level = 2;
        $this->course = factory(Course::class)->create();
        for ($i = 0; $i < 2; ++$i) {
            $this->assignments[] = [
                'id' => $i
                    + DB::select("SHOW TABLE STATUS LIKE 'assignments'")[0]->Auto_increment,
                'course_id'       => $this->course->id,
                'course_name'     => $this->course->name,
                'is_course_admin' => false,
                'name'            => $this->faker->text(20),
                'content'         => $this->faker->paragraph,
                'due_time'        => $this->faker->dateTimeBetween('now', '+5 days')
                    ->format('Y-m-d H:i:s'),
                'is_ongoing'  => null,
                'finished_at' => null,
                'rate_info'   => [
                    'rated' => 'null',
                    'stats' => [
                        'like'    => 0,
                        'dislike' => 0,
                    ]
                ]
            ];
            $this->assignments[$i]['content_html'] = $this->parser->text(
                $this->assignments[$i]['content']
            );
        }
    }
}
