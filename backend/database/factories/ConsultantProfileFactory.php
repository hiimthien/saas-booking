<?php

namespace Database\Factories;

use App\Models\ConsultantProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ConsultantProfileFactory extends Factory
{
    protected $model = ConsultantProfile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory()->consultant(),
            'slug' => fake()->unique()->slug(),
            'title' => fake()->jobTitle(),
            'hourly_rate' => fake()->randomFloat(2, 20, 200),
            'bio' => fake()->paragraphs(3, true),
            'rating' => fake()->randomFloat(2, 3, 5),
            'reviews_count' => fake()->numberBetween(0, 500),
            'is_active' => true,
        ];
    }
}
