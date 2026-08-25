<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('name', 100)->change();
            $table->string('email', 150)->change();
            $table->enum('role', ['super_admin', 'admin', 'pemilik_kos']);
            $table->foreignId('wilayah_id')
                ->nullable()
                ->constrained('wilayah')
                ->restrictOnDelete();
            $table->enum('status', ['active', 'inactive']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropForeign(['wilayah_id']);
            $table->dropColumn(['role', 'wilayah_id', 'status']);
            $table->string('name')->change();
            $table->string('email')->change();
        });
    }
};
