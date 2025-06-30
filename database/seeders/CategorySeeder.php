<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $categories = [
            ['name' => 'Teknologi', 'description'=>'Buku-buku tentang teknologi, pemrograman, dan inovasi.'],
            ['name' => 'Bisnis', 'description'=>'Buku-buku tentang manajemen, ekonomi, dan strategi bisnis.'],
            ['name' => 'Fiksi', 'description'=>'Novel dan cerita fiksi dari berbagai genre.'],
            ['name' => 'Sejarah','description'=>'Buku-buku tentang sejarah dunia dan lokal.'],
        ];

        foreach ($categories as $index => $category) {
            Category::create([
                'id'   => $index + 1, // agar cocok dengan ID yang digunakan di BookSeeder
                'name' => $category['name'],
                'description' => $category['description']
            ]);
        }
    }
}
