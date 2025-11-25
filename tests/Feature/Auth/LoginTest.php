<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Livewire\Auth\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_view_login_page()
    {
        $this->get(route('auth.login'))
            ->assertSuccessful()
            ->assertSeeLivewire(Login::class);
    }

    #[Test]
    public function is_redirected_if_already_logged_in()
    {
        $user = User::factory()->create();

        $this->be($user);

        $this->get(route('auth.login'))
            ->assertRedirect(route('home'));
    }

    #[Test]
    public function a_user_can_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $company = \App\Models\Company::factory()->create();
        \App\Models\Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);
        $user->load('member');

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertAuthenticatedAs($user);
    }

    #[Test]
    public function is_redirected_to_the_home_page_after_login()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);
        $company = \App\Models\Company::factory()->create();
        \App\Models\Member::factory()->create(['user_id' => $user->id, 'company_id' => $company->id]);
        $user->load('member');

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect(route('dashboard.index', ['tenant' => $company]));
    }

    #[Test]
    public function email_is_required()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        Livewire::test(Login::class)
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['email' => 'required']);
    }

    #[Test]
    public function email_must_be_valid_email()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        Livewire::test(Login::class)
            ->set('email', 'invalid-email')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['email' => 'email']);
    }

    #[Test]
    public function password_is_required()
    {
        $user = User::factory()->create(['password' => Hash::make('password')]);

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->call('authenticate')
            ->assertHasErrors(['password' => 'required']);
    }

    #[Test]
    public function bad_login_attempt_shows_message()
    {
        $user = User::factory()->create();

        Livewire::test(Login::class)
            ->set('email', $user->email)
            ->set('password', 'bad-password')
            ->call('authenticate')
            ->assertHasErrors('email');

        $this->assertFalse(Auth::check());
    }
}
