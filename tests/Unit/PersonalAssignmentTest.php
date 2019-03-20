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

        // User can read empty personal assignments
        $response = $this->get('api/personal');
        $response->assertStatus(200);
        $response->assertExactJson([
            'success' => true,
            'data'    => [],
        ]);
    }
}
