<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'slug' => fake()->unique()->slug(),
            'description' => fake()->optional()->paragraph(),
            'logo' => fake()->imageUrl(400, 400, 'business'),
            'is_active' => fake()->boolean(90),
        ];
    }
}
