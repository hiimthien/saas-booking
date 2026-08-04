<?php

namespace Database\Seeders;

use App\Models\ConsultantProfile;
use App\Models\Tag;
use App\Models\User;
use App\Models\WorkingHour;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Tags
        $tags = [
            'IT & Software', 'Marketing', 'Legal', 'Finance', 'Startup', 
            'B2B SaaS', 'SEO', 'Leadership', 'Design', 'Data Science'
        ];
        
        $tagModels = [];
        foreach ($tags as $tagName) {
            $tagModels[] = Tag::create([
                'name' => $tagName,
                'slug' => \Illuminate\Support\Str::slug($tagName)
            ]);
        }

        // 2. Admin & Client
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Client User',
            'email' => 'client@example.com',
            'password' => Hash::make('password'),
            'role' => 'client',
        ]);

        // 3. Consultants
        $consultants = [];
        for ($i = 1; $i <= 15; $i++) {
            $consultants[] = User::create([
                'name' => "Expert $i",
                'email' => "expert$i@example.com",
                'password' => Hash::make('password'),
                'role' => 'consultant',
                'avatar_url' => "https://ui-avatars.com/api/?name=Expert+$i&background=random"
            ]);
        }

        $titles = ['Senior Architect', 'Growth Specialist', 'Tax Consultant', 'Startup Advisor', 'Design Lead'];

        foreach ($consultants as $consultant) {
            $randomTitle = $titles[array_rand($titles)];
            $profile = ConsultantProfile::create([
                'user_id' => $consultant->id,
                'slug' => \Illuminate\Support\Str::slug($consultant->name . '-' . $randomTitle),
                'title' => $randomTitle,
                'hourly_rate' => rand(50, 250),
                'bio' => 'Experienced professional with over 10 years of helping clients achieve their goals.',
                'rating' => rand(40, 50) / 10, // 4.0 to 5.0
                'reviews_count' => rand(10, 150),
                'is_active' => true,
            ]);

            // Attach 2-4 random tags
            $randomTags = collect($tagModels)->random(rand(2, 4))->pluck('id');
            $profile->tags()->attach($randomTags);

            // Working hours (Mon-Fri)
            for ($day = 1; $day <= 5; $day++) {
                WorkingHour::create([
                    'consultant_profile_id' => $profile->id,
                    'day_of_week' => $day,
                    'start_time' => '09:00:00',
                    'end_time' => '17:00:00',
                    'is_closed' => false,
                ]);
            }
        }
    }
}

