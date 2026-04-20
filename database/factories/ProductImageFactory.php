<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductImage>
 */
class ProductImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'path' => fake()->imageUrl(1200, 1200, 'technics'),
            'alt' => fake()->sentence(3),
            'is_main' => fake()->boolean(),
        ];
    }
}
