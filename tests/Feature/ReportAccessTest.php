<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_open_system_report(): void
    {
        $user = User::factory()->superAdmin()->create();

        $this->actingAs($user)
            ->get(route('super-admin.laporan.index'))
            ->assertOk()
            ->assertViewIs('super-admin.laporan.index');
    }

    public function test_admin_report_is_scoped_to_admin_wilayah(): void
    {
        $wilayah = Wilayah::factory()->create();
        $otherWilayah = Wilayah::factory()->create();
        $admin = User::factory()->admin()->create(['wilayah_id' => $wilayah->id]);
        $owner = User::factory()->pemilikKos()->create();
        $kos = Kos::factory()->for($owner, 'user')->for($wilayah)->create(['status' => 'active']);
        $otherKos = Kos::factory()->for($owner, 'user')->for($otherWilayah)->create(['status' => 'active']);

        Penghuni::factory()->for($kos)->create(['status' => 'active']);
        Penghuni::factory()->for($otherKos)->create(['status' => 'active']);

        $response = $this->actingAs($admin)->get(route('admin.laporan.index'));

        $response->assertOk()
            ->assertSee($kos->nama_kos)
            ->assertDontSee($otherKos->nama_kos);
    }

    public function test_owner_report_is_scoped_to_selected_owned_kos(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $wilayah = Wilayah::factory()->create();
        $ownKos = Kos::factory()->for($owner, 'user')->for($wilayah)->create(['status' => 'active']);
        $otherOwner = User::factory()->pemilikKos()->create();
        $otherKos = Kos::factory()->for($otherOwner, 'user')->for($wilayah)->create(['status' => 'active']);

        $this->actingAs($owner)
            ->get(route('pemilik-kos.laporan.index', ['kos_id' => $ownKos->id]))
            ->assertOk()
            ->assertSee($ownKos->nama_kos)
            ->assertDontSee($otherKos->nama_kos);
    }
}
