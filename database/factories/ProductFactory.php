<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 1000, 200000);
        $sku = fake()->optional()->bothify('SKU-####-??');

        return [
            'category_id' => Category::factory(),
            'brand_id' => Brand::factory(),
            'name' => fake()->words(3, true),
            'slug' => fake()->unique()->slug(),
            'sku' => $sku ? strtoupper($sku) : null,
            'description' => fake()->paragraphs(3, true),
            'price' => $price,
            'old_price' => fake()->boolean(40) ? round($price + fake()->randomFloat(2, 500, 15000), 2) : null,
            'quantity' => fake()->numberBetween(0, 250),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'is_new' => fake()->boolean(30),
            'is_hit' => fake()->boolean(20),
            'reviews_count' => $reviewCount = fake()->numberBetween(0, 500),
            'rating_avg' => $reviewCount > 0 ? fake()->randomFloat(1, 1, 5) : 0,
            'published_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
