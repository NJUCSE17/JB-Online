<?php

namespace Tests\Feature\Frontend;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PasswordExpirationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_is_requested_to_change_their_password_after_it_expires()
    {
        config(['access.users.password_expires_days' => 30]);

        $user = factory(User::class)->create(['password_changed_at' => Carbon::now()->subMonths(2)->toDateTimeString()]);

        $response = $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect('/password/expired');

        $this->assertEquals(302, $response->getStatusCode());
    }

    /** @test */
    public function a_user_is_not_requested_to_change_their_password_if_it_not_old_enough()
    {
        config(['access.users.password_expires_days' => 30]);

        $user = factory(User::class)->create(['password_changed_at' => Carbon::now()->subWeek()->toDateTimeString()]);

        $this->actingAs($user);

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function a_user_is_not_requested_to_change_password_if_expiration_is_off()
    {
        config(['access.users.password_expires_days' => false]);

        $user = factory(User::class)->create(['password_changed_at' => Carbon::now()->subMonths(2)->toDateTimeString()]);

        $response = $this->actingAs($user)->get('/dashboard');

        $this->assertEquals(200, $response->getStatusCode());
    }

    /** @test */
    public function the_password_can_be_validated()
    {
        config(['access.users.password_history' => false]);
        config(['access.users.password_expires_days' => 30]);

        $user = factory(User::class)->create([
            'password' => ']EqZL4}zBT',
            'password_changed_at' => Carbon::now()->subMonths(2)->toDateTimeString(),
        ]);

        $response = $this->actingAs($user)
            ->followingRedirects()
            ->patch('/password/expired', [
                'old_password' => ']EqZL4}zBT',
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ]);

        $this->assertContains(__('auth.password_rules'), $response->content());
    }

    /** @test */
    public function a_user_can_use_the_same_password_when_history_is_off_on_password_expiration()
    {
        config(['access.users.password_history' => false]);
        config(['access.users.password_expires_days' => 30]);

        $user = factory(User::class)->create([
            'password' => ']EqZL4}zBT',
            'password_changed_at' => Carbon::now()->subMonths(2)->toDateTimeString(),
        ]);

        $response = $this->actingAs($user)
            ->patch('/password/expired', [
                'old_password' => ']EqZL4}zBT',
                'password' => ']EqZL4}zBT',
                'password_confirmation' => ']EqZL4}zBT',
            ]);

        $response->assertSessionHas('flash_success');
        $this->assertTrue(Hash::check(']EqZL4}zBT', $user->fresh()->password));
    }

    /** @test */
    public function a_user_can_not_use_the_same_password_when_history_is_on_on_password_expiration()
    {
        config(['access.users.password_history' => 3]);
        config(['access.users.password_expires_days' => 30]);

        $user = factory(User::class)->create([
            'password' => ']EqZL4}zBT',
            'password_changed_at' => Carbon::now()->subMonths(2)->toDateTimeString(),
        ]);

        $this->actingAs($user)
            ->patch('/password/expired', [
                'old_password' => ']EqZL4}zBT',
                'password' => ':ZqD~57}1t',
                'password_confirmation' => ':ZqD~57}1t',
            ]);

        $response = $this->actingAs($user)
            ->patch('/password/expired', [
                'old_password' => ':ZqD~57}1t',
                'password' => ']EqZL4}zBT',
                'password_confirmation' => ']EqZL4}zBT',
            ]);

        $response->assertSessionHasErrors();
        $errors = session('errors');
        $this->assertEquals($errors->get('password')[0], __('auth.password_used'));
        $this->assertTrue(Hash::check(':ZqD~57}1t', $user->fresh()->password));
    }
}
