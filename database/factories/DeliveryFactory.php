<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Delivery>
 */
class DeliveryFactory extends Factory
{
    public function definition(): array
    {
        $shippedAt = fake()->dateTimeBetween('-10 days', 'now');

        return [
            'order_id' => Order::factory(),
            'service_name' => fake()->randomElement(['CDEK', 'Boxberry', 'DHL', 'Pickup']),
            'tracking_number' => strtoupper(fake()->bothify('??##########')),
            'status' => fake()->randomElement(['pending', 'shipped', 'delivered']),
            'shipped_at' => $shippedAt,
            'delivered_at' => fake()->boolean(50) ? (clone $shippedAt)->modify('+'.fake()->numberBetween(1, 7).' days') : now(),
            'payload_json' => json_encode(['warehouse' => fake()->city(), 'note' => fake()->sentence()], JSON_UNESCAPED_UNICODE),
        ];
    }
}
