<?php

namespace Tests\Feature;

use App\Models\Kos;
use App\Models\Penghuni;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_any_kos_and_penghuni(): void
    {
        $user = User::factory()->superAdmin()->create();
        $wilayah = Wilayah::factory()->create();
        $owner = User::factory()->pemilikKos()->create();
        $kos = Kos::factory()->for($wilayah)->for($owner, 'user')->create();
        $penghuni = Penghuni::factory()->for($kos)->create();

        $this->assertTrue($user->can('view', $kos));
        $this->assertTrue($user->can('view', $penghuni));
    }

    public function test_admin_can_view_only_kos_and_penghuni_in_its_wilayah(): void
    {
        $wilayahA = Wilayah::factory()->create();
        $wilayahB = Wilayah::factory()->create();
        $admin = User::factory()->admin()->create(['wilayah_id' => $wilayahA->id]);
        $owner = User::factory()->pemilikKos()->create();
        $kosA = Kos::factory()->for($wilayahA)->for($owner, 'user')->create();
        $kosB = Kos::factory()->for($wilayahB)->for($owner, 'user')->create();
        $penghuniA = Penghuni::factory()->for($kosA)->create();
        $penghuniB = Penghuni::factory()->for($kosB)->create();

        $this->assertTrue($admin->can('view', $kosA));
        $this->assertFalse($admin->can('view', $kosB));
        $this->assertTrue($admin->can('view', $penghuniA));
        $this->assertFalse($admin->can('view', $penghuniB));
        $this->assertTrue($admin->can('verify', $kosA));
        $this->assertFalse($admin->can('verify', $kosB));
    }

    public function test_pemilik_kos_can_manage_only_owned_kos_and_penghuni(): void
    {
        $wilayah = Wilayah::factory()->create();
        $ownerA = User::factory()->pemilikKos()->create();
        $ownerB = User::factory()->pemilikKos()->create();
        $kosA = Kos::factory()->for($wilayah)->for($ownerA, 'user')->create();
        $kosB = Kos::factory()->for($wilayah)->for($ownerB, 'user')->create();
        $penghuniA = Penghuni::factory()->for($kosA)->create();
        $penghuniB = Penghuni::factory()->for($kosB)->create();

        $this->assertTrue($ownerA->can('view', $kosA));
        $this->assertFalse($ownerA->can('view', $kosB));
        $this->assertTrue($ownerA->can('update', $kosA));
        $this->assertFalse($ownerA->can('update', $kosB));
        $this->assertTrue($ownerA->can('view', $penghuniA));
        $this->assertFalse($ownerA->can('view', $penghuniB));
        $this->assertTrue($ownerA->can('markAsExited', $penghuniA));
        $this->assertFalse($ownerA->can('markAsExited', $penghuniB));
    }

    public function test_admin_cannot_manage_penghuni_or_create_kos(): void
    {
        $wilayah = Wilayah::factory()->create();
        $admin = User::factory()->admin()->create(['wilayah_id' => $wilayah->id]);
        $owner = User::factory()->pemilikKos()->create();
        $kos = Kos::factory()->for($wilayah)->for($owner, 'user')->create();
        $penghuni = Penghuni::factory()->for($kos)->create();

        $this->assertFalse($admin->can('create', $kos));
        $this->assertFalse($admin->can('update', $penghuni));
        $this->assertFalse($admin->can('markAsExited', $penghuni));
    }
}
