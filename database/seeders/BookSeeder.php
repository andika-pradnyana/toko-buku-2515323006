<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pemrograman = Category::where('name', 'Pemrograman')->first();
        $novel = Category::where('name', 'Novel')->first();
        $bisnis = Category::where('name', 'Bisnis & Keuangan')->first();

        Book::create([
            'category_id' => $pemrograman->id,
            'title' => 'Belajar PHP dari Nol',
            'author_name' => 'Ni Made Ayu Kartika',
            'price' => 85000,
        ]);

        Book::create([
            'category_id' => $pemrograman->id,
            'title' => 'Dasar Pemrograman Berorientasi Objek',
            'author_name' => 'I Wayan Sudiarta',
            'price' => 72000,
        ]);

        Book::create([
            'category_id' => $novel->id,
            'title' => 'Senja di Pelabuhan Kecil',
            'author_name' => 'Made Dwijendra',
            'price' => 68000,
        ]);

        Book::create([
            'category_id' => $novel->id,
            'title' => 'Jalan Pulang ke Desa',
            'author_name' => 'Ni Luh Putu Sari',
            'price' => 64000,
        ]);

        Book::create([
            'category_id' => $bisnis->id,
            'title' => 'Strategi Keuangan untuk Pemula',
            'author_name' => 'Ida Bagus Mantra',
            'price' => 110000,
        ]);

        Book::create([
            'category_id' => $bisnis->id,
            'title' => 'Membaca Laporan Keuangan Sederhana',
            'author_name' => 'Putu Gede Ardika',
            'price' => 98000,
        ]);

    }
}
