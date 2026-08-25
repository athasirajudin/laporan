<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wilayah', function (Blueprint $table) {
            $table->id();
            $table->string('rt', 10);
            $table->string('rw', 10);
            $table->string('kelurahan', 100);
            $table->string('kecamatan', 100);
            $table->string('kabupaten_kota', 100);
            $table->string('provinsi', 100);
            $table->string('kode_pos', 10)->nullable();
            $table->timestamps();

            $table->index(['rt', 'rw']);
            $table->index(['kelurahan', 'kecamatan']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wilayah');
    }
};
