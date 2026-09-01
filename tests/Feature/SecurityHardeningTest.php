<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SecurityHardeningTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_user_is_logged_out_on_authenticated_request(): void
    {
        $user = User::factory()->pemilikKos()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();

        $user->update(['status' => 'inactive']);

        $this->get(route('dashboard'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_owner_cannot_move_an_active_kos_to_another_region(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $currentWilayah = Wilayah::factory()->create();
        $otherWilayah = Wilayah::factory()->create();
        $kos = Kos::factory()->for($owner, 'user')->for($currentWilayah)->create([
            'status' => 'active',
        ]);

        $this->actingAs($owner)
            ->put(route('pemilik-kos.kos.update', $kos), [
                'nama_kos' => $kos->nama_kos,
                'alamat' => $kos->alamat,
                'wilayah_id' => $otherWilayah->id,
            ])
            ->assertSessionHasErrors('wilayah_id');

        $this->assertDatabaseHas('kos', [
            'id' => $kos->id,
            'wilayah_id' => $currentWilayah->id,
        ]);
    }
}
