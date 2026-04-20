<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => fake()->boolean(60) ? User::factory() : null,
            'author_name' => fake()->name(),
            'author_email' => fake()->optional()->safeEmail(),
            'rating' => fake()->numberBetween(1, 5),
            'advantages' => fake()->optional()->sentence(),
            'disadvantages' => fake()->optional()->sentence(),
            'comment' => fake()->paragraph(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}
