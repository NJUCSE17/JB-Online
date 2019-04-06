<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\CourseEnrollRecord;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var \Parsedown|null
     */
    private $parser = null;

    /**
     * AssignmentTest constructor.
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->parser = new \Parsedown();
    }

    /**
     * Test Assignment CRUD Functions
     */
    public function testAssignmentFunctions()
    {
        $user = factory(User::class)->create();
        $course = factory(Course::class)->create();
        $assignments = array();
        for ($i = 0; $i < 2; ++$i) {
            $assignments[] = [
                'id'          => $i + 1,
                'course_id'   => $course->id,
                'name'        => $this->faker->text(20),
                'content'     => $this->faker->paragraph,
                'due_time'    => $this->faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s'),
                'finished_at' => null,
            ];
            $assignments[$i]['content_html'] = $this->parser->text($assignments[$i]['content']);
        }

        // Unauthorized user cannot perform CRUD operations
        if (true) {
            $this->get('api/assignment')->assertStatus(302);
            $this->post('api/assignment')->assertStatus(302);
            $this->put('api/assignment')->assertStatus(302);
            $this->delete('api/assignment')->assertStatus(302);
        }

        // Assignment is empty at first
        $this->actingAs($user, 'api');
        if (true) {
            $response = $this->get('/api/assignment');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data' => [],
            ]);
        }

        // A non-admin user cannot create assignments
        if (true) {
            $response = $this->post('/api/assignment', [
                'course_id' => $assignments[0]['course_id'],
                'name' => $assignments[0]['name'],
                'content' => $assignments[0]['content'],
                'due_time' => $assignments[0]['due_time'],
            ]);
            $response->assertStatus(403);
        }

        // An admin user can create assignments
        $this->enroll($user->id, $assignments[0]['course_id'], true);
        if (true) {
            $response = $this->post('/api/assignment', [
                'course_id' => $assignments[0]['course_id'],
                'name' => $assignments[0]['name'],
                'content' => $assignments[0]['content'],
                'due_time' => $assignments[0]['due_time'],
            ]);
            $response->assertStatus(201);
        }
        $this->quit($user->id, $assignments[0]['course_id']);

        // Check the assignment is correctly created.
        if (true) {
            $response = $this->get('/api/assignment');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [$assignments[0]],
            ]);
        }

        // Assignment can be specified by assignment ID.
        if (true) {
            $response = $this->get('/api/assignment?assignment_id=' . $assignments[0]['id']);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $assignments[0],
            ]);
        }

        // Privileged user can create assignments
        $user->privilege_level = 2;
        if (true) {
            $response = $this->post('/api/assignment', [
                'course_id' => $assignments[1]['course_id'],
                'name' => $assignments[1]['name'],
                'content' => $assignments[1]['content'],
                'due_time' => $assignments[1]['due_time'],
            ]);
            $response->assertStatus(201);
        }
        $user->privilege_level = 3;

        // Check the assignments have been created
        if (true) {
            $response = $this->get('/api/assignment');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $assignments,
            ]);
        }

        $assignments[0]['content'] = $this->faker->paragraph(2);
        $assignments[0]['content_html'] = $this->parser->text($assignments[0]['content']);
        $assignments[0]['due_time'] = $this->faker->dateTimeInInterval('now', '+5 days')->format('Y-m-d H:i:s');

        // A non-admin user cannot update assignments
        if (true) {
            $response = $this->put('/api/assignment', [
                'assignment_id' => $assignments[0]['id'],
                'content' => $assignments[0]['content'],
                'due_time' => $assignments[0]['due_time'],
            ]);
            $response->assertStatus(403);
        }

        // An admin user can update assignments
        $this->enroll($user->id, $assignments[0]['course_id'], true);
        if (true) {
            $response = $this->put('/api/assignment', [
                'assignment_id' => $assignments[0]['id'],
                'content' => $assignments[0]['content'],
                'due_time' => $assignments[0]['due_time'],
            ]);
            $response->assertStatus(200);
        }
        $this->quit($user->id, $assignments[0]['course_id']);

        // Check the assignments have been updated
        if (true) {
            $response = $this->get('/api/assignment');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $assignments,
            ]);
        }

        // A non-admin user cannot delete assignments
        if (true) {
            $response = $this->delete('/api/assignment', [
                'assignment_id' => $assignments[0]['id'],
            ]);
            $response->assertStatus(403);
        }

        // An admin user can delete assignments
        $this->enroll($user->id, $assignments[0]['course_id'], true);
        if (true) {
            $response = $this->delete('/api/assignment', [
                'assignment_id' => $assignments[0]['id'],
            ]);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => 'Assignment deleted.',
            ]);
        }
        $this->quit($user->id, $assignments[0]['course_id']);

        // Check the assignment has been deleted
        if (true) {
            $response = $this->get('/api/assignment');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [$assignments[1]],
            ]);
        }

        // A user cannot finish assignment if not enrolled in course
        if (true) {
            $response = $this->post('/api/assignment/finish', [
                'assignment_id' => $assignments[1]['id'],
            ]);
            $response->assertStatus(403);
        }

        // A user can finish assignment if enrolled in course
        $this->enroll($user->id, $assignments[1]['course_id'], false);
        if (true) {
            $response = $this->post('/api/assignment/finish', [
                'assignment_id' => $assignments[1]['id'],
            ]);
            $response->assertStatus(200);
            $response->assertJson([ // not an exact check
                'success' => true,
                'data'    => [
                    'user_id' => $user->id,
                    'assignment_id' => $assignments[1]['id'],
                ]
            ]);
        }
        $this->quit($user->id, $assignments[1]['course_id']);

        // Finished assignments will not be shown in assignments list if required
        if (true) {
            $response = $this->get('/api/assignment?unfinished_only=1');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [],
            ]);
        }

        // A user cannot reset assignment if not enrolled in course
        if (true) {
            $response = $this->post('/api/assignment/reset', [
                'assignment_id' => $assignments[1]['id'],
            ]);
            $response->assertStatus(403);
        }

        // A user can reset assignment if enrolled in course
        $this->enroll($user->id, $assignments[1]['course_id'], false);
        if (true) {
            $response = $this->post('/api/assignment/reset', [
                'assignment_id' => $assignments[1]['id'],
            ]);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => 'Assignment reset.'
            ]);
        }
        $this->quit($user->id, $assignments[1]['course_id']);

        // TODO: Assignment records will be cleaned once the user quits the course
        // TODO: Assignment records will be cleaned once the assignment is updated
    }

    /**
     * Enroll a user to a course.
     *
     * @param $user_id
     * @param $course_id
     */
    private function enroll($user_id, $course_id, $as_admin)
    {
        CourseEnrollRecord::query()->create([
            'user_id' => $user_id,
            'course_id' => $course_id,
            'type_is_admin' => $as_admin,
        ]);
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
}