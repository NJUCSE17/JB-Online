<?php

namespace Tests\Feature;

use App\Models\Course;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $course = factory(Course::class)->create();
        $assignments = array();
        for ($i = 0; $i < 2; ++$i) {
            $assignments[] = [
                'id' => $i + 1,
                'course_id' => $course->id,
                'name' => $this->faker->text(20),
                'content' => $this->faker->paragraph,
                'due_time' => $this->faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s'),
            ];
            $assignments[$i]['content_html'] = $this->parser->text($assignments[$i]['content']);
        }

        /**
         * Get (EMPTY)
         */
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data' => [],
            ]);

        /**
         * Create
         */
        $this->post('/api/assignment', [
            'course_id' => $assignments[0]['course_id'],
            'name'      => $assignments[0]['name'],
            'content'   => $assignments[0]['content'],
            'due_time'  => $assignments[0]['due_time'],
        ])->assertStatus(201);
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [$assignments[0]],
            ]);

        $this->post('/api/assignment', [
            'course_id' => $assignments[1]['course_id'],
            'name'      => $assignments[1]['name'],
            'content'   => $assignments[1]['content'],
            'due_time'  => $assignments[1]['due_time'],
        ])->assertStatus(201);
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => $assignments,
            ]);

        /**
         * Update
         */
        $assignments[0]['content'] = $this->faker->paragraph(2);
        $assignments[0]['content_html'] = $this->parser->text($assignments[0]['content']);
        $assignments[0]['due_time'] = $this->faker->dateTimeInInterval('now', '+5 days')->format('Y-m-d H:i:s');

        $this->put('/api/assignment', [
            'assignment_id' => $assignments[0]['id'],
            'content'       => $assignments[0]['content'],
            'due_time'      => $assignments[0]['due_time'],
        ])->assertStatus(200);
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => $assignments,
            ]);

        /**
         * Delete
         */
        $this->delete('/api/assignment', [
            'assignment_id' => $assignments[0]['id'],
        ])->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => 'Assignment deleted.',
            ]);
        $this->get('/api/assignment')
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => [$assignments[1]],
            ]);
    }
}