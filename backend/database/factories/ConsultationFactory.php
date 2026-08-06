<?php

namespace Database\Factories;

use App\Models\Consultation;
use App\Models\ConsultantProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConsultationFactory extends Factory
{
    protected $model = Consultation::class;

    public function definition(): array
    {
        $start = fake()->dateTimeBetween('-1 month', '+1 month');
        $end = (clone $start)->modify('+1 hour');

        return [
            'ulid' => Str::ulid(),
            'consultant_profile_id' => ConsultantProfile::factory(),
            'customer_id' => User::factory()->customer(),
            'start_time' => $start,
            'end_time' => $end,
            'total_price' => fake()->randomFloat(2, 20, 200),
            'status' => fake()->randomElement(['pending', 'confirmed', 'completed', 'cancelled']),
            'meeting_link' => 'https://meet.google.com/' . fake()->lexify('???-????-???'),
            'notes' => fake()->sentence(),
        ];
    }
}
