<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_have_wilayah_and_many_kos(): void
    {
        $wilayah = Wilayah::factory()->create();
        $user = User::factory()->create([
            'role' => 'pemilik_kos',
            'wilayah_id' => null,
        ]);

        $kos = Kos::factory()->for($user)->for($wilayah)->create();

        $this->assertTrue($user->kos->contains($kos));
        $this->assertTrue($kos->user->is($user));
        $this->assertTrue($kos->wilayah->is($wilayah));
        $this->assertTrue($wilayah->kos->contains($kos));
    }

    public function test_kos_has_many_penghuni(): void
    {
        $kos = Kos::factory()->create(['status' => 'active']);
        $penghuni = Penghuni::factory()->for($kos)->create();

        $this->assertTrue($kos->penghuni->contains($penghuni));
        $this->assertTrue($penghuni->kos->is($kos));
    }

    public function test_models_expose_expected_role_helpers(): void
    {
        $superAdmin = User::factory()->create(['role' => 'super_admin']);
        $admin = User::factory()->create(['role' => 'admin']);
        $pemilikKos = User::factory()->create(['role' => 'pemilik_kos']);

        $this->assertTrue($superAdmin->isSuperAdmin());
        $this->assertTrue($admin->isAdmin());
        $this->assertTrue($pemilikKos->isPemilikKos());
    }
}
