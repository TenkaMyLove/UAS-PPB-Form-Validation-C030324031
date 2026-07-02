<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat user admin default untuk keperluan pengujian.
     * Jalankan dengan: php artisan db:seed --class=AdminSeeder
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@uas-ppb.test'],
            [
                'name'     => 'Administrator',
                'email'    => 'admin@uas-ppb.test',
                'password' => Hash::make('admin123456'),
                'website'  => 'http://localhost',
                'telp'     => '081234567890',
                'role'     => 'admin',
            ]
        );

        $this->command->info('✅ Admin user berhasil dibuat:');
        $this->command->table(
            ['Field', 'Value'],
            [
                ['Email',    'admin@uas-ppb.test'],
                ['Password', 'admin123456'],
                ['Role',     'admin'],
            ]
        );
    }
}
