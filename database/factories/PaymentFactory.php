<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'provider' => fake()->randomElement(['tbank', 'yookassa', 'stripe']),
            'method' => fake()->randomElement(['card', 'sbp', 'wallet']),
            'status' => fake()->randomElement(['pending', 'paid', 'failed', 'refunded']),
            'transaction_id' => strtoupper(fake()->bothify('TRX-########')),
            'amount' => fake()->randomFloat(2, 500, 150000),
            'paid_at' => fake()->dateTimeBetween('-30 days', 'now'),
            'payload_json' => json_encode(['ip' => fake()->ipv4(), 'meta' => fake()->word()], JSON_UNESCAPED_UNICODE),
        ];
    }
}
