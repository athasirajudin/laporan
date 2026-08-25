<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['super_admin', 'admin', 'pemilik_kos'])
                ->default('pemilik_kos')
                ->after('password');
            $table->foreignId('wilayah_id')
                ->nullable()
                ->after('role')
                ->constrained('wilayah')
                ->nullOnDelete();
            $table->enum('status', ['active', 'inactive'])
                ->default('active')
                ->after('wilayah_id');

            $table->index(['role', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['wilayah_id']);
            $table->dropIndex(['role', 'status']);
            $table->dropColumn(['role', 'wilayah_id', 'status']);
        });
    }
};
