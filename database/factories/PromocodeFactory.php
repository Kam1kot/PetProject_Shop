<?php

namespace Database\Factories;

use App\Models\Promocode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Promocode>
 */
class PromocodeFactory extends Factory
{
    public function definition(): array
    {
        $startsAt = fake()->dateTimeBetween('-1 month', '+1 month');

        return [
            'code' => strtoupper(fake()->unique()->bothify('SALE-####')),
            'type' => fake()->randomElement(['fixed', 'percent']),
            'value' => fake()->randomFloat(2, 5, 5000),
            'min_order_amount' => fake()->randomFloat(2, 0, 50000),
            'usage_limit' => fake()->numberBetween(1, 1000),
            'usage_count' => fake()->numberBetween(0, 300),
            'starts_at' => $startsAt,
            'ends_at' => (clone $startsAt)->modify('+'.fake()->numberBetween(7, 60).' days'),
            'is_active' => fake()->boolean(80),
        ];
    }
}
