<?php

namespace Tests\Feature\Unit;

use App\Models\PersonalAssignment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PersonalAssignmentTest extends TestCase
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
        $this->withHeader('Accept', 'application/json');
    }

    /**
     * Test Personal Assignment CRUD Functions
     */
    public function testPersonalAssignmentFunctions()
    {
        $users = array();
        for ($i = 0; $i < 2; ++$i) {
            $users[] = factory(User::class)->create();
        }

        $personal_assignments = array();
        for ($i = 0; $i < 2; ++$i) {
            $personal_assignments[] = [
                'id'          => $i + 1,
                'user_id'     => $users[$i]->id,
                'name'        => $this->faker->text(20),
                'content'     => $this->faker->paragraph,
                'due_time'    => $this->faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s'),
                'finished_at' => null,
            ];
            $personal_assignments[$i]['content_html'] = $this->parser->text($personal_assignments[$i]['content']);
        }

        // Unauthorized user cannot perform CRUD operations
        if (true) {
            $this->get('api/personal')->assertStatus(401);
            $this->post('api/personal')->assertStatus(401);
            $this->put('api/personal')->assertStatus(401);
            $this->delete('api/personal')->assertStatus(401);
        }

        // User can read empty personal assignments
        $this->actingAs($users[0], 'api');
        if (true) {
            $response = $this->get('/api/personal');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [],
            ]);
        }

        // User can create a personal assignment
        if (true) {
            $response = $this->post('/api/personal', [
                'name'     => $personal_assignments[0]['name'],
                'content'  => $personal_assignments[0]['content'],
                'due_time' => $personal_assignments[0]['due_time'],
            ]);
            $response->assertStatus(201);
            $response->assertExactJson([
                'success' => true,
                'data'    => $personal_assignments[0],
            ]);
        }

        // Check that the PA is correctly created
        if (true) {
            $response = $this->get('/api/personal');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [$personal_assignments[0]],
            ]);
        }

        // Another user will create a new PA now
        $this->actingAs($users[1], 'api');
        if (true) {
            $response = $this->post('/api/personal', [
                'name'     => $personal_assignments[1]['name'],
                'content'  => $personal_assignments[1]['content'],
                'due_time' => $personal_assignments[1]['due_time'],
            ]);
            $response->assertStatus(201);
            $response->assertExactJson([
                'success' => true,
                'data'    => $personal_assignments[1],
            ]);

            // Check the assignment is correctly created
            $response = $this->get('/api/personal');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [$personal_assignments[1]],
            ]);
        }

        // One user can view his own PA
        if (true) {
            $response = $this->get('/api/personal?personal_assignment_id=' . $personal_assignments[1]['id']);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $personal_assignments[1],
            ]);
        }

        // One user cannot view others' PA
        if (true) {
            $response = $this->get('/api/personal?personal_assignment_id=' . $personal_assignments[0]['id']);
            $response->assertStatus(403);
        }

        // However, a privileged user (<=2) can view others' PA
        $users[1]->privilege_level = 2;
        if (true) {
            $response = $this->get('/api/personal?personal_assignment_id=' . $personal_assignments[0]['id']);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $personal_assignments[0],
            ]);
        }
        $users[1]->privilege_level = 3;

        // One user can update his/her own PA
        $personal_assignments[1]['content'] = $this->faker->paragraph;
        $personal_assignments[1]['content_html'] = $this->parser->text($personal_assignments[1]['content']);
        $personal_assignments[1]['due_time'] = $this->faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s');
        if (true) {
            $response = $this->put('/api/personal', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
                'content'                => $personal_assignments[1]['content'],
                'due_time'               => $personal_assignments[1]['due_time'],
            ]);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $personal_assignments[1],
            ]);
        }

        // One user cannot update others' PA
        $this->actingAs($users[0], 'api');
        if (true) {
            $response = $this->put('/api/personal', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
                'content'                => $personal_assignments[1]['content'],
                'due_time'               => $personal_assignments[1]['due_time'],
            ]);
            $response->assertStatus(403);
        }

        // However, a privileged user (<=2) can update others' PA
        $users[0]->privilege_level = 2;
        if (true) {
            $response = $this->put('/api/personal', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
                'content'                => $personal_assignments[1]['content'],
                'due_time'               => $personal_assignments[1]['due_time'],
            ]);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => $personal_assignments[1],
            ]);
        }
        $users[0]->privilege_level = 3;

        // One user can finish his/her own PA
        unset($personal_assignments[0]['finished_at']); // remove for non-exact assertions
        if (true) {
            $response = $this->post('/api/personal/finish', [
                'personal_assignment_id' => $personal_assignments[0]['id'],
            ]);
            $response->assertStatus(200);
            $response->assertJson([ // not an exact assertion
                'success' => true,
                'data'    => $personal_assignments[0],
            ]);
        }

        // One user cannot finish others' PA
        if (true) {
            $response = $this->post('/api/personal/finish', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
            ]);
            $response->assertStatus(403);
        }

        // Even privileged users cannot finish others' PA
        $users[0]->privilege_level = 0;
        if (true) {
            $response = $this->post('/api/personal/finish', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
            ]);
            $response->assertStatus(403);
        }
        $users[0]->privilege_level = 3;

        // One user can reset his/her own PA
        if (true) {
            $response = $this->post('/api/personal/reset', [
                'personal_assignment_id' => $personal_assignments[0]['id'],
            ]);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => 'Personal assignment reset.',
            ]);
        }

        // One user cannot reset others' PA
        if (true) {
            $response = $this->post('/api/personal/reset', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
            ]);
            $response->assertStatus(403);
        }

        // Even privileged users cannot reset others' PA
        $users[0]->privilege_level = 0;
        if (true) {
            $response = $this->post('/api/personal/reset', [
                'personal_assignment_id' => $personal_assignments[1]['id'],
            ]);
            $response->assertStatus(403);
        }
        $users[0]->privilege_level = 3;

        // One user can delete his/her own PA
        if (true) {
            $response = $this->delete('/api/personal', [
                'personal_assignment_id' => $personal_assignments[0]['id'],
            ]);
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => 'Personal assignment deleted.',
            ]);

            // check the assignment has been deleted
            $response = $this->get('/api/personal?personal_assignment_id=' . $personal_assignments[0]['id']);
            $response->assertStatus(422);

            $response = $this->get('/api/personal');
            $response->assertStatus(200);
            $response->assertExactJson([
                'success' => true,
                'data'    => [],
            ]);
        }
        // One user cannot update others' PA
        // However, a privileged user (<=2) can delete others' PA
    }
}
