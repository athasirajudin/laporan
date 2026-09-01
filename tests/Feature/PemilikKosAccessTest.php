<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PemilikKosAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_view_only_their_kos(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $otherOwner = User::factory()->pemilikKos()->create();
        $wilayah = Wilayah::factory()->create();

        $ownKos = Kos::factory()->for($owner, 'user')->for($wilayah)->create();
        $otherKos = Kos::factory()->for($otherOwner, 'user')->for($wilayah)->create();

        $this->actingAs($owner)->get(route('pemilik-kos.kos.show', $ownKos))->assertOk();
        $this->actingAs($owner)->get(route('pemilik-kos.kos.show', $otherKos))->assertForbidden();
    }

    public function test_owner_cannot_add_occupant_to_inactive_kos(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $wilayah = Wilayah::factory()->create();
        $kos = Kos::factory()->for($owner, 'user')->for($wilayah)->create(['status' => 'pending']);

        $this->actingAs($owner)
            ->post(route('pemilik-kos.penghuni.store'), [
                'kos_id' => $kos->id,
                'jenis_identitas' => 'KTP',
                'nomor_identitas' => '3201010101010001',
                'nama_lengkap' => 'Budi Santoso',
                'pekerjaan' => 'Karyawan',
                'tanggal_masuk' => now()->format('Y-m-d'),
            ])
            ->assertSessionHasErrors('kos_id');

        $this->assertDatabaseMissing('penghuni', ['nama_lengkap' => 'Budi Santoso']);
    }

    public function test_new_occupant_is_automatically_active(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $wilayah = Wilayah::factory()->create();
        $kos = Kos::factory()->for($owner, 'user')->for($wilayah)->create(['status' => 'active']);

        $this->actingAs($owner)
            ->post(route('pemilik-kos.penghuni.store'), [
                'kos_id' => $kos->id,
                'jenis_identitas' => 'KTP',
                'nomor_identitas' => '3201010101010002',
                'nama_lengkap' => 'Sinta Putri',
                'pekerjaan' => 'Mahasiswa',
                'tanggal_masuk' => now()->format('Y-m-d'),
            ])
            ->assertRedirect(route('pemilik-kos.penghuni.index'));

        $this->assertDatabaseHas('penghuni', [
            'kos_id' => $kos->id,
            'nama_lengkap' => 'Sinta Putri',
            'status' => 'active',
            'tanggal_keluar' => null,
        ]);
    }

    public function test_owner_cannot_set_exit_date_before_entry_date(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $wilayah = Wilayah::factory()->create();
        $kos = Kos::factory()->for($owner, 'user')->for($wilayah)->create(['status' => 'active']);
        $penghuni = Penghuni::factory()->for($kos)->create([
            'status' => 'active',
            'tanggal_masuk' => now()->subDays(5)->format('Y-m-d'),
            'tanggal_keluar' => null,
        ]);

        $this->actingAs($owner)
            ->patch(route('pemilik-kos.penghuni.keluar', $penghuni), [
                'tanggal_keluar' => now()->subDays(6)->format('Y-m-d'),
                'keterangan' => 'Tanggal tidak valid',
            ])
            ->assertSessionHasErrors('tanggal_keluar');

        $this->assertDatabaseHas('penghuni', [
            'id' => $penghuni->id,
            'status' => 'active',
            'tanggal_keluar' => null,
        ]);
    }

    public function test_owner_can_mark_their_active_occupant_as_exited(): void
    {
        $owner = User::factory()->pemilikKos()->create();
        $wilayah = Wilayah::factory()->create();
        $kos = Kos::factory()->for($owner, 'user')->for($wilayah)->create(['status' => 'active']);
        $penghuni = Penghuni::factory()->for($kos)->create([
            'status' => 'active',
            'tanggal_masuk' => now()->subDays(5)->format('Y-m-d'),
            'tanggal_keluar' => null,
        ]);

        $tanggalKeluar = now()->format('Y-m-d');

        $this->actingAs($owner)
            ->patch(route('pemilik-kos.penghuni.keluar', $penghuni), [
                'tanggal_keluar' => $tanggalKeluar,
                'keterangan' => 'Pindah tempat tinggal',
            ])
            ->assertRedirect(route('pemilik-kos.penghuni.history'));

        $this->assertDatabaseHas('penghuni', [
            'id' => $penghuni->id,
            'status' => 'inactive',
            'keterangan' => 'Pindah tempat tinggal',
        ]);

        $this->assertSame(
            $tanggalKeluar,
            $penghuni->fresh()->tanggal_keluar?->format('Y-m-d')
        );
    }
}
