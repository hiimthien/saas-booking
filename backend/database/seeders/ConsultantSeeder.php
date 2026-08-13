<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ConsultantProfile;
use App\Models\WorkingHour;
use App\Models\Tag;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ConsultantSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('123456');

        // Lấy tất cả ID của Tag đã tạo từ TagSeeder trước đó
        $tagIds = Tag::pluck('id')->toArray();

        // ==========================================
        // 1. TẠO CHUYÊN GIA TĨNH
        // ==========================================
        $staticConsultant = User::factory()->consultant()->create([
            'name' => 'Demo Consultant',
            'email' => 'clt121221@gmail.com',
            'password' => $defaultPassword,
        ]);

        $staticHourlyRate = rand(5, 30) * 10;
        $staticProfile = ConsultantProfile::factory()->create([
            'user_id' => $staticConsultant->id,
            'hourly_rate' => $staticHourlyRate,
        ]);

        // Gắn vài tag ngẫu nhiên cho chuyên gia tĩnh (nếu có tag)
        if (!empty($tagIds)) {
            $staticProfile->tags()->attach(array_rand(array_flip($tagIds), rand(2, 5)));
        }

        // Tạo giờ làm việc tĩnh (7 ngày)
        for ($day = 1; $day <= 7; $day++) {
            WorkingHour::create([
                'consultant_profile_id' => $staticProfile->id,
                'day_of_week' => $day,
                'start_time' => '08:00:00',
                'end_time' => '17:00:00',
                'is_closed' => false,
            ]);
        }

        // ==========================================
        // 2. TẠO CHUYÊN GIA HÀNG LOẠT (LOAD TESTING)
        // ==========================================
        $batchSize = 100;
        $totalConsultants = 1000;

        for ($i = 0; $i < $totalConsultants / $batchSize; $i++) {
            DB::transaction(function () use ($batchSize, $defaultPassword, $tagIds) {
                $consultants = User::factory()->consultant()->count($batchSize)->create([
                    'password' => $defaultPassword
                ]);

                foreach ($consultants as $consultant) {
                    $profile = ConsultantProfile::factory()->create([
                        'user_id' => $consultant->id,
                        'hourly_rate' => rand(5, 30) * 10,
                    ]);

                    // Attach Random Tags
                    if (!empty($tagIds)) {
                        $profile->tags()->attach(array_rand(array_flip($tagIds), rand(2, 5)));
                    }

                    // Generate Working Hours
                    for ($day = 1; $day <= 7; $day++) {
                        $isClosed = in_array($day, [6, 7]); // Đóng cửa T7, CN
                        WorkingHour::factory()->create([
                            'consultant_profile_id' => $profile->id,
                            'day_of_week' => $day,
                            'start_time' => $isClosed ? null : '08:00:00',
                            'end_time' => $isClosed ? null : '17:00:00',
                            'is_closed' => $isClosed,
                        ]);
                    }
                }
            });
        }
    }
}
