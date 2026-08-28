<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_only_kos_in_own_region(): void
    {
        $ownWilayah = Wilayah::factory()->create();
        $otherWilayah = Wilayah::factory()->create();
        $admin = User::factory()->admin()->create(['wilayah_id' => $ownWilayah->id]);
        $owner = User::factory()->pemilikKos()->create();
        $ownKos = Kos::factory()->create(['wilayah_id' => $ownWilayah->id, 'user_id' => $owner->id]);
        $otherKos = Kos::factory()->create(['wilayah_id' => $otherWilayah->id, 'user_id' => $owner->id]);

        $this->actingAs($admin)->get(route('admin.kos.show', $ownKos))->assertOk();
        $this->actingAs($admin)->get(route('admin.kos.show', $otherKos))->assertForbidden();
    }

    public function test_admin_can_view_only_penghuni_in_own_region(): void
    {
        $ownWilayah = Wilayah::factory()->create();
        $otherWilayah = Wilayah::factory()->create();
        $admin = User::factory()->admin()->create(['wilayah_id' => $ownWilayah->id]);
        $owner = User::factory()->pemilikKos()->create();
        $ownKos = Kos::factory()->create(['wilayah_id' => $ownWilayah->id, 'user_id' => $owner->id]);
        $otherKos = Kos::factory()->create(['wilayah_id' => $otherWilayah->id, 'user_id' => $owner->id]);
        $ownPenghuni = Penghuni::factory()->create(['kos_id' => $ownKos->id]);
        $otherPenghuni = Penghuni::factory()->create(['kos_id' => $otherKos->id]);

        $this->actingAs($admin)->get(route('admin.penghuni.show', $ownPenghuni))->assertOk();
        $this->actingAs($admin)->get(route('admin.penghuni.show', $otherPenghuni))->assertForbidden();
    }

    public function test_admin_can_verify_pending_kos_in_own_region(): void
    {
        $wilayah = Wilayah::factory()->create();
        $admin = User::factory()->admin()->create(['wilayah_id' => $wilayah->id]);
        $owner = User::factory()->pemilikKos()->create();
        $kos = Kos::factory()->create(['wilayah_id' => $wilayah->id, 'user_id' => $owner->id, 'status' => 'pending']);

        $this->actingAs($admin)
            ->patch(route('admin.kos.verify', $kos))
            ->assertRedirect();

        $this->assertDatabaseHas('kos', ['id' => $kos->id, 'status' => 'active']);
    }
}
