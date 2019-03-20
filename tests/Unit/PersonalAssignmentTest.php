<?php

namespace Tests\Feature\Unit;

use App\Models\User;
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
            $this->get('api/personal')->assertStatus(302);
            $this->post('api/personal')->assertStatus(302);
            $this->put('api/personal')->assertStatus(302);
            $this->delete('api/personal')->assertStatus(302);
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

        // TODO TODO TODO
        // One user cannot view others' PA
        // However, a privileged user (<=2) can view others' PA
        // One user can update his/her own PA
        // One user cannot update others' PA
        // Even a privileged user (<=2) cannot update others' PA
        // One user can finish his/her own PA
        // One user cannot finish his/her own PA
        // Even privileged users cannot finish others' PA
        // One user can reset his/her own PA
        // One user cannot reset his/her own PA
        // Even privileged users cannot reset others' PA
        // One user can delete his/her own PA
        // One user cannot update others' PA
        // However, a privileged user (<=2) can delete others' PA
    }
}
