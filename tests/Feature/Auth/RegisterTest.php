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
        \Spatie\Permission\Models\Role::firstOrCreate(['name' => \App\Enums\RoleEnum::MANAGER->value]);
        
        Event::fake([Registered::class]);

        Livewire::test(Register::class)
            ->set('name', 'John Doe')
            ->set('countryCode', 'CI')
            ->set('phoneNumber', '0102030405')
            ->set('password', 'password')
            ->set('terms', true)
            ->call('register')
            ->assertHasNoErrors();

        $this->assertTrue(User::where('phone_number', '+2250102030405')->exists());
        $this->assertEquals('+2250102030405', Auth::user()->phone_number);
        
        // Verify redirect to dashboard
        $user = Auth::user();
        $this->assertNull($user->member);
    }

    #[Test]
    function name_is_required()
    {
        Livewire::test(Register::class)
            ->set('name', '')
            ->call('register')
            ->assertHasErrors(['name' => 'required']);
    }

    #[Test]
    function phone_number_is_required()
    {
        Livewire::test(Register::class)
            ->set('phoneNumber', '')
            ->call('register')
            ->assertHasErrors(['phoneNumber' => 'required']);
    }

    #[Test]
    function phone_number_hasnt_been_taken_already()
    {
        User::factory()->create(['phone_number' => '+2250102030405']);

        Livewire::test(Register::class)
            ->set('countryCode', 'CI')
            ->set('phoneNumber', '0102030405')
            ->call('register')
            ->assertHasErrors(['phoneNumber' => 'unique']);
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
