<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;use Livewire\Livewire;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use App\Livewire\Auth\Register;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    function registration_page_contains_livewire_component()
    {
        $this->get(route('auth.register'))
            ->assertSuccessful()
            ->assertSeeLivewire(Register::class);
    }

    #[Test]
    public function is_redirected_if_already_logged_in()
    {
        $user = User::factory()->create();

        $this->be($user);

        $this->get(route('auth.register'))
            ->assertRedirect(route('home'));
    }

    #[Test]
    function a_user_can_register()
    {
        // Create role manually to ensure it exists
        \Spatie\Permission\Models\Role::create(['name' => \App\Enums\RoleEnum::MANAGER->value]);
        
        Event::fake([Registered::class]);

        Livewire::test(Register::class)
            ->set('firstname', 'John')
            ->set('lastname', 'Doe')
            ->set('companyName', 'Acme Corp')
            ->set('phoneNumber', '1234567890')
            ->set('email', 'john@example.com')
            ->set('password', 'password')
            ->set('terms', true)
            ->call('register')
            ->assertHasNoErrors();

        $this->assertTrue(User::whereEmail('john@example.com')->exists());
        $this->assertEquals('john@example.com', Auth::user()->email);
        
        // Verify redirect to dashboard
        $user = Auth::user();
        $this->assertNotNull($user->member);
        $this->assertNotNull($user->member->company);
    }

    #[Test]
    function firstname_is_required()
    {
        Livewire::test(Register::class)
            ->set('firstname', '')
            ->call('register')
            ->assertHasErrors(['firstname' => 'required']);
    }

    #[Test]
    function lastname_is_required()
    {
        Livewire::test(Register::class)
            ->set('lastname', '')
            ->call('register')
            ->assertHasErrors(['lastname' => 'required']);
    }

    #[Test]
    function company_name_is_required()
    {
        Livewire::test(Register::class)
            ->set('companyName', '')
            ->call('register')
            ->assertHasErrors(['companyName' => 'required']);
    }

    #[Test]
    function email_is_required()
    {
        Livewire::test(Register::class)
            ->set('email', '')
            ->call('register')
            ->assertHasErrors(['email' => 'required']);
    }

    #[Test]
    function email_is_valid_email()
    {
        Livewire::test(Register::class)
            ->set('email', 'invalid-email')
            ->call('register')
            ->assertHasErrors(['email' => 'email']);
    }

    #[Test]
    function email_hasnt_been_taken_already()
    {
        User::factory()->create(['email' => 'john@example.com']);

        Livewire::test(Register::class)
            ->set('email', 'john@example.com')
            ->call('register')
            ->assertHasErrors(['email' => 'unique']);
    }

    #[Test]
    function password_is_required()
    {
        Livewire::test(Register::class)
            ->set('password', '')
            ->call('register')
            ->assertHasErrors(['password' => 'required']);
    }

    #[Test]
    function password_is_minimum_of_six_characters()
    {
        Livewire::test(Register::class)
            ->set('password', 'secret') // 6 chars
            ->call('register')
            ->assertHasNoErrors(['password']);
            
        Livewire::test(Register::class)
            ->set('password', 'short') // 5 chars
            ->call('register')
            ->assertHasErrors(['password']);
    }

    #[Test]
    function terms_must_be_accepted()
    {
        Livewire::test(Register::class)
            ->set('terms', false)
            ->call('register')
            ->assertHasErrors(['terms' => 'accepted']);
    }
}
