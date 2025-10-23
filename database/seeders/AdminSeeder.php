<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'username' => 'owner',
            'nama_lengkap' => 'Pemilik Toko',
            'email' => 'owner@example.com',
            'password' => Hash::make('owner123'),
            'role' => 'owner',
        ]);

        Admin::create([
            'username' => 'admin',
            'nama_lengkap' => 'Admin Utama',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        Admin::create([
            'username' => 'petugas',
            'nama_lengkap' => 'Petugas CS',
            'email' => 'petugas@example.com',
            'password' => Hash::make('petugas123'),
            'role' => 'petugas',
        ]);
    }
}
