<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('-1 week', '+1 week');

        return [
            'title' => fake()->sentence(4),
            'image' => fake()->imageUrl(1600, 500, 'technics'),
            'link' => fake()->optional()->url(),
            'position' => fake()->randomElement(['home_top', 'home_middle', 'sidebar', 'footer']),
            'is_active' => fake()->boolean(80),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+'.fake()->numberBetween(3, 30).' days'),
        ];
    }
}
