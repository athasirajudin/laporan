<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class RoleMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::middleware(['auth', 'role:admin'])->get('/__test/admin-only', fn () => 'ok');
    }

    public function test_user_with_allowed_role_can_access_route(): void
    {
        $user = User::factory()->admin()->create();

        $this->actingAs($user)
            ->get('/__test/admin-only')
            ->assertOk()
            ->assertSeeText('ok');
    }

    public function test_user_with_disallowed_role_receives_forbidden(): void
    {
        $user = User::factory()->pemilikKos()->create();

        $this->actingAs($user)
            ->get('/__test/admin-only')
            ->assertForbidden();
    }
}
