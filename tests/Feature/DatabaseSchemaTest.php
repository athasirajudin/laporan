<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DatabaseSchemaTest extends TestCase
{
    use RefreshDatabase;

    public function test_v1_core_tables_and_columns_exist(): void
    {
        $this->assertTrue(Schema::hasTable('users'));
        $this->assertTrue(Schema::hasTable('wilayah'));
        $this->assertTrue(Schema::hasTable('kos'));
        $this->assertTrue(Schema::hasTable('penghuni'));

        $this->assertTrue(Schema::hasColumns('users', [
            'name',
            'email',
            'password',
            'role',
            'wilayah_id',
            'status',
        ]));

        $this->assertTrue(Schema::hasColumns('wilayah', [
            'rt',
            'rw',
            'kelurahan',
            'kecamatan',
            'kabupaten_kota',
            'provinsi',
            'kode_pos',
        ]));

        $this->assertTrue(Schema::hasColumns('kos', [
            'user_id',
            'wilayah_id',
            'nama_kos',
            'alamat',
            'status',
        ]));

        $this->assertTrue(Schema::hasColumns('penghuni', [
            'kos_id',
            'jenis_identitas',
            'nomor_identitas',
            'nama_lengkap',
            'pekerjaan',
            'tanggal_masuk',
            'tanggal_keluar',
            'status',
            'keterangan',
        ]));
    }
}
