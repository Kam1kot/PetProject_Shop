<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserAddress>
 */
class UserAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'label' => fake()->randomElement(['home', 'work', 'pickup']),
            'recipient_name' => fake()->name(),
            'recipient_phone' => fake()->numerify('79#########'),
            'country' => fake()->country(),
            'city' => fake()->city(),
            'street' => fake()->streetName(),
            'house' => fake()->buildingNumber(),
            'apartment' => (string) fake()->numberBetween(1, 300),
            'postal_code' => fake()->numberBetween(100000, 999999),
            'comment' => fake()->numberBetween(0, 9999),
        ];
    }
}
