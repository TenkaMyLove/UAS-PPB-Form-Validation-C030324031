<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel contacts untuk menyimpan pesan dari form kontak.
     * Mendukung guest (user_id nullable) dan user teregistrasi.
     */
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            // Nullable: guest tidak perlu user_id
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->string('nama', 100);
            $table->string('email', 255);
            $table->string('website', 255)->nullable();
            $table->string('telp', 20);
            $table->text('pesan');
            $table->enum('status', ['unread', 'read', 'replied'])->default('unread');
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Index untuk query umum
            $table->index('status');
            $table->index('email');
            $table->index(['user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
