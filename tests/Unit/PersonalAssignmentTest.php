<?php

namespace Tests\Feature\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PersonalAssignmentTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /**
     * @var \Parsedown|null
     */
    private $parser = null;
    private $users = array();
    private $admin = null;
    private $personal_assignments = array();

    /**
     * Test Personal Assignment CRUD Functions
     */
    public function testPersonalAssignmentFunctions()
    {
        $this->PAShouldBeEmptyAtFirst();

        $this->userCanCreatePAs();
        $this->userCanViewItsOwnPA();
        $this->userCannotViewOthersPA();
        $this->adminCanViewOthersPA();

        $this->userCanUpdateItsOwnPA();
        $this->userCannotUpdateOthersPA();
        $this->adminCanUpdateOthersPA();

        $this->userCanFinishItsOwnPA();
        $this->userCannotFinishOthersPA();
        $this->adminCannotFinishOthersPA();

        $this->userCanResetItsOwnPA();
        $this->userCannotResetOthersPA();
        $this->adminCannotResetOthersPA();

        $this->userCanDeleteItsOwnPA();
        $this->userCannotDeleteOthersPA();
        $this->adminCanDeleteOthersPA();
    }

    protected function PAShouldBeEmptyAtFirst()
    {
        $this->actingAs($this->users[0], 'api');
        $this->get('/api/personalAssignment')
            ->assertStatus(200)
            ->assertExactJson([]);
    }

    protected function userCanCreatePAs()
    {
        $this->actingAs($this->users[0], 'api');
        $this->post('/api/personalAssignment',
            [
                'name'     => $this->personal_assignments[0]['name'],
                'content'  => $this->personal_assignments[0]['content'],
                'due_time' => $this->personal_assignments[0]['due_time'],
            ]
        )->assertStatus(201)
            ->assertExactJson($this->personal_assignments[0]);

        // Check that the PA is correctly created
        $this->get('/api/personalAssignment')
            ->assertStatus(200)
            ->assertExactJson([$this->personal_assignments[0]]);

        $this->actingAs($this->users[1], 'api');
        $this->post('/api/personalAssignment',
            [
                'name'     => $this->personal_assignments[1]['name'],
                'content'  => $this->personal_assignments[1]['content'],
                'due_time' => $this->personal_assignments[1]['due_time'],
            ]
        )->assertStatus(201)
            ->assertExactJson($this->personal_assignments[1]);

        // Check the assignment is correctly created
        $this->get('/api/personalAssignment')
            ->assertStatus(200)
            ->assertExactJson([$this->personal_assignments[1]]);
    }

    protected function userCanViewItsOwnPA()
    {
        $this->actingAs($this->users[1], 'api');
        $this->get('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'])
            ->assertStatus(200)
            ->assertExactJson($this->personal_assignments[1]);
    }

    protected function userCannotViewOthersPA()
    {
        $this->actingAs($this->users[1], 'api');
        $this->get('/api/personalAssignment/'
            .$this->personal_assignments[0]['id'])
            ->assertStatus(403);
    }

    protected function adminCanViewOthersPA()
    {
        $this->actingAs($this->admin, 'api');
        $this->get('/api/personalAssignment/'
            .$this->personal_assignments[0]['id'])
            ->assertStatus(200)
            ->assertExactJson($this->personal_assignments[0]);
    }

    protected function userCanUpdateItsOwnPA()
    {
        $this->actingAs($this->users[1], 'api');
        $this->personal_assignments[1]['content'] = $this->faker->paragraph;
        $this->personal_assignments[1]['content_html'] = $this->parser->text(
            $this->personal_assignments[1]['content']
        );
        $this->personal_assignments[1]['due_time']
            = $this->faker->dateTimeBetween(
            'now',
            '+5 days'
        )->format('Y-m-d H:i:s');

        $this->put('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'],
            [
                'content'  => $this->personal_assignments[1]['content'],
                'due_time' => $this->personal_assignments[1]['due_time'],
            ]
        )->assertStatus(200)
            ->assertExactJson($this->personal_assignments[1]);
    }

    protected function userCannotUpdateOthersPA()
    {
        $this->actingAs($this->users[0], 'api');
        $this->put('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'],
            [
                'content'  => $this->personal_assignments[1]['content'],
                'due_time' => $this->personal_assignments[1]['due_time'],
            ]
        )->assertStatus(403);
    }

    protected function adminCanUpdateOthersPA()
    {
        $this->actingAs($this->admin, 'api');
        $this->put('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'],
            [
                'content'  => $this->personal_assignments[1]['content'],
                'due_time' => $this->personal_assignments[1]['due_time'],
            ]
        )->assertStatus(200)
            ->assertExactJson($this->personal_assignments[1]);
    }

    protected function userCanFinishItsOwnPA()
    {
        unset($this->personal_assignments[0]['finished_at']); // remove for non-exact assertions
        $this->actingAs($this->users[0], 'api');
        $this->post(
            '/api/personalAssignment/'.$this->personal_assignments[0]['id']
            .'/finish'
        )->assertStatus(200)
            ->assertJson($this->personal_assignments[0]); // not an exact assertion
    }

    protected function userCannotFinishOthersPA()
    {
        $this->actingAs($this->users[0], 'api');
        $this->post(
            '/api/personalAssignment/'.$this->personal_assignments[1]['id']
            .'/finish'
        )->assertStatus(403);
    }

    protected function adminCannotFinishOthersPA()
    {
        $this->actingAs($this->admin, 'api');
        $this->post(
            '/api/personalAssignment/'.$this->personal_assignments[1]['id']
            .'/finish'
        )->assertStatus(403);
    }

    protected function userCanResetItsOwnPA()
    {
        $this->actingAs($this->users[0], 'api');
        $this->post(
            '/api/personalAssignment/'.$this->personal_assignments[0]['id']
            .'/reset'
        )->assertStatus(200)
            ->assertExactJson(['Personal assignment reset.',]);
    }

    protected function userCannotResetOthersPA()
    {
        $this->actingAs($this->users[0], 'api');
        $this->post(
            '/api/personalAssignment/'.$this->personal_assignments[1]['id']
            .'/reset'
        )->assertStatus(403);
    }

    protected function adminCannotResetOthersPA()
    {
        $this->actingAs($this->admin, 'api');
        $this->post(
            '/api/personalAssignment/'.$this->personal_assignments[1]['id']
            .'/reset'
        )->assertStatus(403);
    }

    protected function userCanDeleteItsOwnPA()
    {
        $this->actingAs($this->users[0], 'api');
        $this->delete('/api/personalAssignment/'
            .$this->personal_assignments[0]['id'])
            ->assertStatus(204);

        // check the assignment has been deleted
        $this->get('/api/personalAssignment/'
            .$this->personal_assignments[0]['id'])
            ->assertStatus(404);

        $this->get('/api/personalAssignment')
            ->assertStatus(200)
            ->assertExactJson([]);
    }

    protected function userCannotDeleteOthersPA()
    {
        $this->actingAs($this->users[0], 'api');
        $this->delete('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'])
            ->assertStatus(403);
    }

    protected function adminCanDeleteOthersPA()
    {
        $this->actingAs($this->admin, 'api');
        $this->delete('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'])
            ->assertStatus(204);

        $this->get('/api/personalAssignment/'
            .$this->personal_assignments[1]['id'])
            ->assertStatus(404);
    }

    /**
     * Setup the test case.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->parser = new \Parsedown();
        $this->withHeader('Accept', 'application/json');

        for ($i = 0; $i < 2; ++$i) {
            $this->users[] = factory(User::class)->create();
        }

        $this->admin = factory(User::class)->create();
        $this->admin->privilege_level = 2;

        for ($i = 0; $i < 2; ++$i) {
            $this->personal_assignments[] = [
                'id'          => $i
                    + DB::select("SHOW TABLE STATUS LIKE 'personal_assignments'")[0]->Auto_increment,
                'user_id'     => $this->users[$i]->id,
                'name'        => $this->faker->text(20),
                'content'     => $this->faker->paragraph,
                'due_time'    => $this->faker->dateTimeBetween('now', '+5 days')
                    ->format('Y-m-d H:i:s'),
                'finished_at' => null,
            ];
            $this->personal_assignments[$i]['content_html']
                = $this->parser->text(
                $this->personal_assignments[$i]['content']
            );
        }
    }
}
