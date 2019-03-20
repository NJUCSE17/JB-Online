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

        // Unauthorized user cannot perform CRUD operations
        $this->get('api/personal')->assertStatus(302);
        $this->post('api/personal')->assertStatus(302);
        $this->put('api/personal')->assertStatus(302);
        $this->delete('api/personal')->assertStatus(302);

        $user  = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $personal_assignments = array();
        for ($i = 0; $i < 2; ++$i) {
            $personal_assignments[] = [
                'id'          => $i + 1,
                'user_id'     => $user->id,
                'name'        => $this->faker->text(20),
                'content'     => $this->faker->paragraph,
                'due_time'    => $this->faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s'),
                'finished_at' => null,
            ];
            $personal_assignments[$i]['content_html'] = $this->parser->text($personal_assignments[$i]['content']);
        }

        // User can read empty personal assignments
        $response = $this->get('/api/personal');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'data'    => [],
        ]);

        // User can create a personal assignment
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
}
