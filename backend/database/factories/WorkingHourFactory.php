<?php

namespace Database\Factories;

use App\Models\WorkingHour;
use App\Models\ConsultantProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkingHourFactory extends Factory
{
    protected $model = WorkingHour::class;

    public function definition(): array
    {
        return [
            'consultant_profile_id' => ConsultantProfile::factory(),
            'day_of_week' => fake()->numberBetween(1, 7),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'is_closed' => false,
        ];
    }
}
