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
                'id'          => $i
                    + DB::select("SHOW TABLE STATUS LIKE 'assignments'")[0]->Auto_increment,
                'course_id'   => $this->course->id,
                'name'        => $this->faker->text(20),
                'content'     => $this->faker->paragraph,
                'due_time'    => $this->faker->dateTimeBetween('now', '+5 days')
                    ->format('Y-m-d H:i:s'),
                'finished_at' => null,
            ];
            $this->assignments[$i]['content_html'] = $this->parser->text(
                $this->assignments[$i]['content']
            );
        }
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

    /**
     * Test Assignment CRUD Functions
     */
    public function testAssignmentFunctions()
    {
        $this->unauthorizedUserCannotPerformOperations();
        $this->assignmentsAreEmptyAtFirst();

        $this->userCannotCreateAssignment();
        $this->courseAdminCanCreateAssignment();
        $this->userCanViewSpecificAssignment();
        $this->adminCanCreateAssignment();

        $this->userCannotUpdateAssignment();
        $this->courseAdminCanUpdateAssignment();

        $this->userCannotDeleteAssignment();
        $this->courseAdminCanDeleteAssignment();

        $this->userCannotFinishAssignmentIfNotEnrolledInCourse();
        $this->userCanFinishAssignmentIfEnrolledInCourse();
        $this->finishedAssignmentsAreHiddenIfRequired();
        $this->userCannotResetAssignmentIfNotEnrolledInCourse();
        $this->userCanResetAssignmentIfEnrolledInCourse();

        // TODO: Assignment records will be cleaned once the user quits the course
        // TODO: Assignment records will be cleaned once the assignment is updated
    }

    protected function unauthorizedUserCannotPerformOperations()
    {
        $this->get('api/assignment')->assertStatus(401);
        $this->post('api/assignment')->assertStatus(401);
        $this->put('api/assignment')->assertStatus(401);
        $this->delete('api/assignment')->assertStatus(401);
    }

    protected function assignmentsAreEmptyAtFirst()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [],
                ]
            );
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
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [$this->assignments[0]],
                ]
            );
    }

    protected function userCanViewSpecificAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->get(
            '/api/assignment?assignment_id='.$this->assignments[0]['id']
        )->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->assignments[0],
                ]
            );
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
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->assignments,
                ]
            );
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
        $this->put('/api/assignment',
            [
                'assignment_id' => $this->assignments[0]['id'],
                'content'       => $this->assignments[0]['content'],
                'due_time'      => $this->assignments[0]['due_time'],
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
            '/api/assignment',
            [
                'assignment_id' => $this->assignments[0]['id'],
                'content'       => $this->assignments[0]['content'],
                'due_time'      => $this->assignments[0]['due_time'],
            ]
        )->assertStatus(200);
        $this->quit($this->user->id, $this->assignments[0]['course_id']);

        // Check the assignments have been updated
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => $this->assignments,
                ]
            );
    }

    protected function userCannotDeleteAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->delete('/api/assignment',
            [
                'assignment_id' => $this->assignments[0]['id'],
            ]
        )->assertStatus(403);
    }

    protected function courseAdminCanDeleteAssignment()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[0]['course_id'],
            true);
        $this->delete('/api/assignment',
            [
                'assignment_id' => $this->assignments[0]['id'],
            ]
        )->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => 'Assignment deleted.',
                ]
            );
        $this->quit($this->user->id, $this->assignments[0]['course_id']);

        // Check the assignments have been deleted
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [$this->assignments[1]],
                ]
            );
    }

    protected function userCannotFinishAssignmentIfNotEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
        $this->post('/api/assignment/finish',
            [
                'assignment_id' => $this->assignments[1]['id'],
            ]
        )->assertStatus(403);
    }

    protected function userCanFinishAssignmentIfEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[1]['course_id'],
            false);
        $this->post('/api/assignment/finish',
            [
                'assignment_id' => $this->assignments[1]['id'],
            ]
        )->assertStatus(200)
            ->assertJson(
                [ // not an exact check
                    'success' => true,
                    'data'    => [
                        'user_id'       => $this->user->id,
                        'assignment_id' => $this->assignments[1]['id'],
                    ],
                ]
            );
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
    }

    protected function finishedAssignmentsAreHiddenIfRequired()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/assignment?unfinished_only=1')
            ->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => [],
                ]
            );
    }

    protected function userCannotResetAssignmentIfNotEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
        $this->post(
            '/api/assignment/reset',
            [
                'assignment_id' => $this->assignments[1]['id'],
            ]
        )->assertStatus(403);
    }

    protected function userCanResetAssignmentIfEnrolledInCourse()
    {
        $this->actingAs($this->user, 'api');
        $this->enroll($this->user->id, $this->assignments[1]['course_id'],
            false);
        $this->post(
            '/api/assignment/reset',
            [
                'assignment_id' => $this->assignments[1]['id'],
            ]
        )->assertStatus(200)
            ->assertExactJson(
                [
                    'success' => true,
                    'data'    => 'Assignment reset.',
                ]
            );
        $this->quit($this->user->id, $this->assignments[1]['course_id']);
    }
}