<?php

namespace Database\Seeders;

use App\Models\Publisher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Publisher::create(['name' => 'Gramedia Pusaka Utama', 'city' => 'Jakarta']);
        Publisher::create(['name' => "O'Reilly Media", 'city' => 'Sebastapol']);
        Publisher::create(['name' => "Penguin Random House", 'city' => 'New York']);
    }
}
