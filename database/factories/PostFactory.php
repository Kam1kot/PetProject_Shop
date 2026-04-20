<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\PostCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => User::factory(),
            'category_id' => PostCategory::factory(),
            'title' => fake()->sentence(6),
            'slug' => fake()->unique()->slug(),
            'content' => fake()->paragraphs(4, true),
            'cover_image' => fake()->optional()->imageUrl(1200, 800, 'technics'),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'views_count' => fake()->numberBetween(0, 50000),
        ];
    }
}
