<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penghuni', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kos_id')
                ->constrained('kos')
                ->restrictOnDelete();
            $table->enum('jenis_identitas', ['KTP', 'SIM']);
            $table->string('nomor_identitas', 30);
            $table->string('nama_lengkap', 150);
            $table->string('pekerjaan', 100);
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->enum('status', ['active', 'inactive'])
                ->default('active');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index(['kos_id', 'status']);
            $table->index(['nama_lengkap']);
            $table->index(['nomor_identitas']);
            $table->index(['tanggal_masuk', 'tanggal_keluar']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penghuni');
    }
};
