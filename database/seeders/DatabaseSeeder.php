<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
                // =========================
        // 1. USER (Admin, Siswa, Guru)
        // =========================
        User::create([
            'name' => 'Admin SIPAL',
            'email' => 'admin@sipal.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Abdul Aziz Nurrahman',
            'email' => '1001', // NISN
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'class' => 'XII RPL C',
        ]);
        
        User::create([
            'name' => 'Adiputra Aryasena',
            'email' => '1002',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'class' => 'XII RPL A',
        ]);

        User::create([
            'name' => 'Alvin Yourry Putra Mentari',
            'email' => '1003',
            'password' => Hash::make('password'),
            'role' => 'siswa',
            'class' => 'XI TKJ 1',
        ]);

        // TAMBAHAN AKUN GURU
        User::create([
            'name' => 'Kurniasari, S.Kom.',
            'email' => '2001', // NIP Pendek
            'password' => Hash::make('password'),
            'role' => 'guru',
            'class' => 'Guru Pemrograman Perangkat Bergerak', // Penanda kelas untuk guru
        ]);

                // =========================
        // 2. CATEGORIES (Dibuat lebih spesifik)
        // =========================
        $categories = [
            ['name' => 'Komputer & Aksesori', 'description' => 'Perangkat utama dan aksesori PC/Laptop'],
            ['name' => 'Jaringan & Multimedia', 'description' => 'Peralatan jaringan, presentasi, dan audio visual'],
            ['name' => 'Elektronika & Arduino', 'description' => 'Alat soldering, mikrokontroler, dan komponen elektronika'],
            ['name' => 'Peralatan Teknik', 'description' => 'Alat bantu praktik seperti bor dan obeng'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // =========================
        // 3. TOOLS (Data Real Lab)
        // =========================
        $tools = [
            // Kategori 1: Komputer & Aksesori
            [
                'category_id' => 1,
                'name' => 'Laptop HP',
                'specification' => 'Laptop untuk praktikum siswa',
                'stock' => 3,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 1,
                'name' => 'Flashdisk',
                'specification' => 'Kapasitas 16GB/32GB',
                'stock' => 10,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 1,
                'name' => 'Mouse',
                'specification' => 'Mouse optik USB',
                'stock' => 20,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 1,
                'name' => 'Keyboard',
                'specification' => 'Keyboard USB standar',
                'stock' => 10,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 1,
                'name' => 'Monitor',
                'specification' => 'Monitor LCD LED 17-19 inch',
                'stock' => 3,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],

            // Kategori 2: Jaringan & Multimedia
            [
                'category_id' => 2,
                'name' => 'Proyektor',
                'specification' => 'LCD Projector HDMI',
                'stock' => 3,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 2,
                'name' => 'Speaker',
                'specification' => 'Speaker aktif standar',
                'stock' => 1,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 2,
                'name' => 'Mic + Sound System',
                'specification' => 'Wireless microphone & mixer',
                'stock' => 1,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],

            // Kategori 3: Elektronika & Arduino
            [
                'category_id' => 3,
                'name' => 'Arduino Uno',
                'specification' => 'Board Mikrokontroler ATmega328P',
                'stock' => 30,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 3,
                'name' => 'Solder',
                'specification' => 'Soldering iron 40W',
                'stock' => 1,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],

            // Kategori 4: Peralatan Teknik
            [
                'category_id' => 4,
                'name' => 'Obeng Mini',
                'specification' => '1 Set obeng presisi',
                'stock' => 1,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 4,
                'name' => 'Bor Tembok',
                'specification' => 'Bor listrik impact',
                'stock' => 1,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
            [
                'category_id' => 4,
                'name' => 'Bor Mini Listrik',
                'specification' => 'Bor mini untuk PCB/elektronik',
                'stock' => 1,
                'condition' => 'Baik',
                'status' => 'Tersedia',
            ],
        ];

        foreach ($tools as $tool) {
            Tool::create($tool);
        }
    }
}