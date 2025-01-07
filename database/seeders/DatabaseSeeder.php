<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
// use App\Models\Category;
// use App\Models\Employee;
// use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Category::factory(10)->create();

        User::create([
            'name' => 'Super Admin',
            'email' => 'superAdmin@gmail.com',
            'password' => bcrypt('4dm1n!@#'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Rully',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminRully123!'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Saled Admin',
            'email' => 'salesAdmin@gmail.com',
            'password' => bcrypt('salesAdmin123!'),
            'role' => 'salesAdmin',
        ]);

        // Category::create([
        //     'name' => 'Humas',
        //     'slug'=> 'humas'
        // ]);

        // Category::create([
        //     'name' => 'Penerimaan Peserta Didik Baru',
        //     'slug'=> 'penerimaan-peserta-didik-baru'
        // ]);



        // Employee::create([
        //     'employee'=>110,
        //     'student'=>1200
        // ]);

        // $position = [
        //     'Kepala SMK Al-Hasra',
        //     'Wakil Kepala SMK Al-Hasra Bidang Kurikulum',
        //     'Wakil Kepala SMK Al-Hasra Bidang Kesiswaan',
        //     'Kaprog AKL & Guru Produktif AKL',
        //     'Guru Produktif AKL',
        //     'Kaprog TJKT & Guru IPAS',
        //     'Kabag Sarpras & Guru Produktif TJKT',
        //     'Kabag Administrasi Yayasan & Guru PKn',
        //     'Kabag Keuangan & Guru Informatika',
        //     'Guru Pendidikan Agama Islam & BPI',
        //     'Guru Bahasa Indonesia',
        //     'Guru Bahasa Inggris',
        //     'Guru Produktif TJKT',
        //     'Guru Pendidikan Jasmani Olah Raga & Kesehatan',
        //     'Guru B. Inggris Mulok',
        //     'Guru Pendidikan Agama dan Budi Pekerti',
        //     'Supervisor Yayasan',
        //     'Staf Pembukuan dan Piutang SMK',
        //     'Staf Akuntansi Yayasan, IC, Aset',
        //     'Staf Akuntansi Yayasan',
        //     'Staf Humas',
        //     'Petugas Kebersihan',
        //     'Petugas Keamanan',
        //     'Marbot Masjid',
        // ];

        // foreach($position as $p){
        //     DB::table('positions')->insert([
        //         'name' => $p,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ]);
        // }
    }
}
