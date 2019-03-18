<?php

namespace Tests\Feature;

use App\Models\Course;
use Faker\Provider\DateTime;
use Faker\Provider\Lorem;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssignmentTest extends TestCase
{
    /**
     * Get an empty assignment data.
     */
    public function testGetAssignment()
    {
        $response = $this->get('/api/assignment');
        $response->assertStatus(200);
        $response->assertJson([
                'success' => true,
                'data' => []
            ]);
    }

    /**
     * Create an example assignment.
     */
    public function testCreateAssignment()
    {
        // TODO: FIX BUG AND IMPLEMENT THIS
        $data = [
            'course_id' => factory(Course::class)->create()->id,
            'name' => Lorem::word(),
            'content' => Lorem::paragraph(),
            'due_time' => DateTime::date('Y-m-d H:i:s'),
        ];
        $response = $this->post('/api/assignment');
        echo var_dump($response);
    }
}
