<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tag;
use App\Models\ConsultantProfile;
use App\Models\WorkingHour;
use App\Models\Consultation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Admin User
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Create Tags (generate about 30 tags)
        $tags = Tag::factory()->count(30)->create();

        // 3. Create 400 Customers
        $customers = User::factory()->customer()->count(400)->create();

        // 4. Create 100 Consultants with Profiles, Tags, and Working Hours
        $consultants = User::factory()->consultant()->count(100)->create();

        foreach ($consultants as $consultant) {
            $profile = ConsultantProfile::factory()->create([
                'user_id' => $consultant->id,
            ]);

            // Assign 2-5 random tags to this consultant
            $profile->tags()->attach(
                $tags->random(rand(2, 5))->pluck('id')->toArray()
            );

            // Create working hours for 7 days
            for ($day = 1; $day <= 7; $day++) {
                $isClosed = in_array($day, [6, 7]); // Closed on weekends typically, but sometimes open
                WorkingHour::factory()->create([
                    'consultant_profile_id' => $profile->id,
                    'day_of_week' => $day,
                    'start_time' => $isClosed ? null : '08:00:00',
                    'end_time' => $isClosed ? null : '17:00:00',
                    'is_closed' => $isClosed,
                ]);
            }

            // 5. Generate 5-15 Consultations for each profile
            $numberOfConsultations = rand(5, 15);
            for ($i = 0; $i < $numberOfConsultations; $i++) {
                $consultation = Consultation::factory()->create([
                    'consultant_profile_id' => $profile->id,
                    'customer_id' => $customers->random()->id,
                ]);

                // 6. Generate Payment for each consultation
                \App\Models\Payment::factory()->create([
                    'consultation_id' => $consultation->id,
                    'amount' => $consultation->total_price,
                    'status' => $consultation->status === 'cancelled' ? 'refunded' : ($consultation->status === 'pending' ? 'pending' : 'completed'),
                ]);

                // 7. Generate Review if consultation is completed (80% chance)
                if ($consultation->status === 'completed' && rand(1, 100) <= 80) {
                    \App\Models\Review::factory()->create([
                        'consultation_id' => $consultation->id,
                        'customer_id' => $consultation->customer_id,
                        'consultant_profile_id' => $profile->id,
                    ]);
                }
            }

            // Update profile rating and review count based on reviews
            $reviews = \App\Models\Review::where('consultant_profile_id', $profile->id)->get();
            if ($reviews->count() > 0) {
                $profile->update([
                    'rating' => $reviews->avg('rating'),
                    'reviews_count' => $reviews->count(),
                ]);
            }
        }
    }
}
