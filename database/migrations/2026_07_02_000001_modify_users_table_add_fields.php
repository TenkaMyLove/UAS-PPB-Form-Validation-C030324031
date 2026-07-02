<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah kolom website, telp, role, dan soft delete ke tabel users.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('website', 255)->nullable()->after('email');
            $table->string('telp', 20)->nullable()->after('website');
            $table->enum('role', ['user', 'admin'])->default('user')->after('telp');
            $table->softDeletes()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['website', 'telp', 'role', 'deleted_at']);
        });
    }
};
