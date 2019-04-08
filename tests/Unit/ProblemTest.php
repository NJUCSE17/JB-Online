<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProblemTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private $user = null;
    private $course_admin = null;
    private $admin = null;
    private $assignments = array();
    private $problems = array();

    protected function setUp(): void
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');

        $this->user = factory(User::class)->create();
        $this->course_admin = factory(User::class)->create();
        $this->admin = factory(User::class)->create();
        $this->admin->privilege_level = 2;

        for ($i = 0; $i < 2; ++$i) {
            $this->assignments[] = factory(Assignment::class)->create();
        }
        DB::table('course_enroll_records')->insert([
            'user_id'       => $this->course_admin->id,
            'course_id'     => $this->assignments[0]->course->id,
            'type_is_admin' => true,
        ]);

        for ($i = 0; $i < 2; ++$i) {
            $this->problems[] = [
                'id'      => $i
                    + DB::select("SHOW TABLE STATUS LIKE 'problems'")[0]->Auto_increment,
                'content' => $this->faker->realText(50),
            ];
        }
    }

    public function testProblemFunctions()
    {
        $this->unauthorizedUserCannotPerformOperations();

        $this->userCannotCreateProblem();
        $this->courseAdminCanCreateProblem();
        $this->adminCanCreateProblem();

        $this->problemCanNotBeViewedWithoutFiltering();
        $this->userCanViewProblemIfFiltered();

        $this->userCannotUpdateProblem();
        $this->courseAdminCanUpdateProblem();
        $this->adminCanUpdateProblem();

        $this->userCannotDeleteProblem();
        $this->courseAdminCanDeleteProblem();
        $this->adminCanDeleteProblem();
    }

    protected function unauthorizedUserCannotPerformOperations()
    {
        $this->get('/api/problem')->assertStatus(401);
        $this->post('/api/problem')->assertStatus(401);
        $this->put('/api/problem')->assertStatus(401);
        $this->delete('/api/problem')->assertStatus(401);
    }

    protected function userCannotCreateProblem()
    {
        $this->actingAs($this->user, 'api');
        $this->post('/api/problem', [
            'course_id'     => $this->assignments[0]->course->id,
            'assignment_id' => $this->assignments[0]->id,
            'content'       => $this->problems[0]['content'],
        ])->assertStatus(403);
    }

    protected function courseAdminCanCreateProblem()
    {
        $this->actingAs($this->course_admin, 'api');
        $this->post('/api/problem', [
            'course_id'     => $this->assignments[0]->course->id,
            'assignment_id' => $this->assignments[0]->id,
            'content'       => $this->problems[0]['content'],
        ])->assertStatus(201)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->problems[0],
            ]);
    }

    protected function adminCanCreateProblem()
    {
        $this->actingAs($this->admin, 'api');
        $this->post('/api/problem', [
            'course_id'     => $this->assignments[1]->course->id,
            'assignment_id' => $this->assignments[1]->id,
            'content'       => $this->problems[1]['content'],
        ])->assertStatus(201)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->problems[1],
            ]);
    }

    protected function problemCanNotBeViewedWithoutFiltering()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/problem')
            ->assertStatus(422);
    }

    protected function userCanViewProblemIfFiltered()
    {
        $this->actingAs($this->user, 'api');
        $this->get('/api/problem?problem_id='.$this->problems[0]['id'])
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->problems[0],
            ]);
        $this->get('/api/problem?assignment_id='.$this->assignments[1]->id)
            ->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => [$this->problems[1]],
            ]);
        $this->get('/api/problem?course_id=-1')
            ->assertStatus(422);
    }

    protected function userCannotUpdateProblem()
    {
        $this->actingAs($this->user, 'api');
        $this->problems[0]['content'] = $this->faker->realText(50);
        $this->put('/api/problem',
            [
                'problem_id' => $this->problems[0]['id'],
                'content'    => $this->problems[0]['content'],
            ]
        )->assertStatus(403);
    }

    protected function courseAdminCanUpdateProblem()
    {
        $this->actingAs($this->course_admin, 'api');
        $this->problems[0]['content'] = $this->faker->realText(50);
        $this->put('/api/problem',
            [
                'problem_id' => $this->problems[0]['id'],
                'content'    => $this->problems[0]['content'],
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->problems[0],
            ]);
        $this->assertDatabaseHas('problems', [
            'id'            => $this->problems[0]['id'],
            'assignment_id' => $this->assignments[0]->id,
            'course_id'     => $this->assignments[0]->course->id,
            'content'       => $this->problems[0]['content'],
            'deleted_at'    => null,
        ]);
    }

    protected function adminCanUpdateProblem()
    {
        $this->actingAs($this->admin, 'api');
        $this->problems[1]['content'] = $this->faker->realText(50);
        $this->put('/api/problem',
            [
                'problem_id' => $this->problems[1]['id'],
                'content'    => $this->problems[1]['content'],
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => $this->problems[1],
            ]);
        $this->assertDatabaseHas('problems', [
            'id'            => $this->problems[1]['id'],
            'assignment_id' => $this->assignments[1]->id,
            'course_id'     => $this->assignments[1]->course->id,
            'content'       => $this->problems[1]['content'],
            'deleted_at'    => null,
        ]);
    }

    protected function userCannotDeleteProblem()
    {
        $this->actingAs($this->user, 'api');
        $this->delete('/api/problem',
            [
                'problem_id' => $this->problems[0]['id'],
            ]
        )->assertStatus(403);
    }

    protected function courseAdminCanDeleteProblem()
    {
        $this->actingAs($this->course_admin, 'api');
        $this->delete('/api/problem',
            [
                'problem_id' => $this->problems[0]['id'],
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => 'Problem deleted.',
            ]);
        $this->assertDatabaseMissing('problems', [
            'id'         => $this->problems[0]['id'],
            'content'    => $this->problems[0]['content'],
            'deleted_at' => null,
        ]);
    }

    protected function adminCanDeleteProblem()
    {
        $this->actingAs($this->admin, 'api');
        $this->delete('/api/problem',
            [
                'problem_id' => $this->problems[1]['id'],
            ]
        )->assertStatus(200)
            ->assertExactJson([
                'success' => true,
                'data'    => 'Problem deleted.',
            ]);
        $this->assertDatabaseMissing('problems', [
            'id'         => $this->problems[1]['id'],
            'content'    => $this->problems[1]['content'],
            'deleted_at' => null,
        ]);
    }
}
