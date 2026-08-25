<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_is_available_to_guests(): void
    {
        $this->get(route('login'))
            ->assertSuccessful()
            ->assertViewIs('auth.login');
    }

    public function test_user_can_login_with_valid_credentials(): void
    {
        $password = 'password123';

        User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make($password),
        ]);

        $this->post(route('login.store'), [
            'email' => 'test@example.com',
            'password' => $password,
        ])
            ->assertRedirect(route('home'));

        $this->assertAuthenticated();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $password = 'password123';

        User::query()->create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => Hash::make($password),
            'status' => 'inactive',
        ]);

        $this->post(route('login.store'), [
            'email' => 'inactive@example.com',
            'password' => $password,
        ])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_invalid_credentials_are_rejected(): void
    {
        User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('correct-password'),
        ]);

        $this->post(route('login.store'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::query()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
