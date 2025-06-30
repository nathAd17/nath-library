<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'          => $this->faker->sentence(3),
            'author'         => $this->faker->name(),
            'publisher'      => $this->faker->company(),
            'year'           => $this->faker->year(),
            'isbn'           => $this->faker->isbn13(),
            'description'    => $this->faker->paragraph(),
            'category_id'    => rand(1, 4), // Pastikan kategori dengan ID 1-4 tersedia
            'cover_image'    => 'https://placehold.co/200x300/000000/FFFFFF/png',
            'stock'          => rand(1, 100),
            'total_borrowed' => rand(0, 200),
            'qr_code'        => Str::uuid()->toString(),
        ];
    }
}
