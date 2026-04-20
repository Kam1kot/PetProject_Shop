<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 1000, 150000);
        $discount = fake()->randomFloat(2, 0, min(15000, $subtotal / 2));
        $delivery = fake()->randomFloat(2, 0, 2000);

        return [
            'user_id' => fake()->boolean(70) ? User::factory() : null,
            'order_number' => fake()->unique()->numberBetween(100000, 999999),
            'status' => fake()->randomElement(['new', 'processing', 'completed', 'cancelled']),
            'payment_status' => fake()->randomElement(['pending', 'paid', 'failed']),
            'delivery_status' => fake()->randomElement(['pending', 'packed', 'shipped', 'delivered']),
            'customer_name' => fake()->name(),
            'customer_email' => fake()->safeEmail(),
            'customer_phone' => fake()->numerify('79#########'),
            'delivery_method' => fake()->randomElement(['courier', 'pickup', 'post']),
            'payment_method' => fake()->randomElement(['card', 'cash', 'sbp']),
            'delivery_city' => fake()->city(),
            'delivery_address' => fake()->streetAddress(),
            'delivery_postal_code' => (string) fake()->numberBetween(100000, 999999),
            'comment' => fake()->optional()->sentence(),
            'subtotal' => $subtotal,
            'discount_amount' => $discount,
            'delivery_amount' => $delivery,
            'total_amount' => round($subtotal - $discount + $delivery, 2),
        ];
    }
}
