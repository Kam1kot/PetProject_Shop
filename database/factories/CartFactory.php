<?php

namespace Database\Factories;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cart>
 */
class CartFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => fake()->boolean(70) ? User::factory() : null,
            'session_id' => fake()->unique()->regexify('[A-Za-z0-9]{32}'),
        ];
    }
}
