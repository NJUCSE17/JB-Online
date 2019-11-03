<?php

namespace Tests\Feature;

use App\Helpers\UserGreetings;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SchoolEmailUsersAreAutoActivatedTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testSchoolEmailUserRegisterAndActivation() {
        $externalUser = factory(User::class)->create(
            [
                'email'        => 'someone@seu.edu.cn',
                'activated_at' => null,
            ]
        );
        $internalUser = factory(User::class)->create(
            [
                'email'        => 'someone@nju.edu.cn',
                'activated_at' => null,
            ]
        );

        $this->actingAs($externalUser);
        $this->get(route('home'))
            ->assertRedirect(route('auth.activate'));

        $this->actingAs($internalUser);
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee(UserGreetings::greet($internalUser));
    }
}
