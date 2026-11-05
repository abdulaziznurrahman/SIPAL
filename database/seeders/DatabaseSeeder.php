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
        // 1. USER (Admin & Siswa)
        // =========================
        User::create([
            'name' => 'Admin SIPAL',
            'email' => 'admin@sipal.sch.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Data Siswa XII RPL C (Sesuai Foto)
        $siswa = [
            ['nis' => '24122', 'nama' => 'ABDUL AZIZ NURRAHMAN', 'jk' => 'L'],
            ['nis' => '24123', 'nama' => 'ADIPUTRA ARYA SENA', 'jk' => 'L'],
            ['nis' => '24124', 'nama' => 'ALVIN YOURRY PUTRA MENTARI', 'jk' => 'L'],
            ['nis' => '24125', 'nama' => 'AMADEO BRIAN RANASTYA PUTRA', 'jk' => 'L'],
            ['nis' => '24127', 'nama' => 'ANDREAS KELVIN ANASTA PUTRA', 'jk' => 'L'],
            ['nis' => '24128', 'nama' => 'ANUELI AFIFAH DARAJATI', 'jk' => 'P'],
            ['nis' => '24129', 'nama' => 'AZRIEL AIDA NUROCHIM', 'jk' => 'P'],
            ['nis' => '24130', 'nama' => 'BINTANG FAHRI HASCARYA', 'jk' => 'L'],
            ['nis' => '24131', 'nama' => 'CARISHA AMIRA INSANI', 'jk' => 'P'],
            ['nis' => '24132', 'nama' => 'CHELSEA MUHAMMAD ADLI', 'jk' => 'L'],
            ['nis' => '24133', 'nama' => 'CHRISTIAN WARDANA', 'jk' => 'L'],
            ['nis' => '24134', 'nama' => 'CLEODORA BERTHA FORTUNA', 'jk' => 'P'],
            ['nis' => '24135', 'nama' => 'CRISTIANO VIELI KALIGIS', 'jk' => 'L'],
            ['nis' => '24136', 'nama' => 'DAFFA FARIH IRFANUDIN', 'jk' => 'L'],
            ['nis' => '24137', 'nama' => 'DESTA TIAR REDRIANA', 'jk' => 'P'],
            ['nis' => '24138', 'nama' => 'FARREL BRILLIANT NUGROHO', 'jk' => 'L'],
            ['nis' => '24139', 'nama' => 'FIDA QUROTTU AINI', 'jk' => 'P'],
            ['nis' => '24140', 'nama' => 'GHOZI MUMTAZA HANIF', 'jk' => 'L'],
            ['nis' => '24141', 'nama' => 'IRFAN AJI WARDANA', 'jk' => 'L'],
            ['nis' => '24142', 'nama' => 'MANESTIKO BANYUBIRU', 'jk' => 'L'],
            ['nis' => '24144', 'nama' => 'MICHAEL ADITYA', 'jk' => 'L'],
            ['nis' => '24145', 'nama' => 'MOSES ADI SAPUTRA', 'jk' => 'L'],
            ['nis' => '24146', 'nama' => 'MUHAMMAD ANSHORI', 'jk' => 'L'],
            ['nis' => '24147', 'nama' => 'MUHAMMAD FAHRI RAHMAN ARRAFI', 'jk' => 'L'],
            ['nis' => '24148', 'nama' => 'MUHAMMAD ROSYID MURYANTO', 'jk' => 'L'],
            ['nis' => '24149', 'nama' => 'NICHOLAS GUSTI SAPUTRA', 'jk' => 'L'],
            ['nis' => '24150', 'nama' => 'PRANAJA ABI PRAYA WIDYATAMA', 'jk' => 'L'],
            ['nis' => '24151', 'nama' => 'RAMADITYA SURYA PUTRA', 'jk' => 'L'],
            ['nis' => '24152', 'nama' => 'SABIAN APTA AIRA', 'jk' => 'L'],
            ['nis' => '24153', 'nama' => 'SATRIA RAHMANSYAH', 'jk' => 'L'],
            ['nis' => '24154', 'nama' => 'THEODORICK BAKUH PANGGAILIH', 'jk' => 'L'],
            ['nis' => '24155', 'nama' => 'XIAN ADI NUGROHO', 'jk' => 'L'],
        ];

        foreach ($siswa as $s) {
            User::create([
                'name' => $s['nama'],
                'email' => $s['nis'], 
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'class' => 'XII RPL C',
            ]);
        }

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