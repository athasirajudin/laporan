<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('wilayah_id')
                ->constrained('wilayah')
                ->restrictOnDelete();
            $table->string('nama_kos', 150);
            $table->text('alamat');
            $table->enum('status', ['pending', 'active', 'inactive', 'rejected'])
                ->default('pending');
            $table->timestamps();

            $table->index(['wilayah_id', 'status']);
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};
