<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'amount' => fake()->randomFloat(2, 50, 500),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'payment_method' => fake()->randomElement(['stripe', 'paypal']),
            'transaction_id' => fake()->uuid(),
        ];
    }
}
