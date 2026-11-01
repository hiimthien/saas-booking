<?php

namespace Tests\Feature;

use App\Models\ConsultantProfile;
use App\Models\Setting;
use App\Models\User;
use App\Services\BookingService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_check_endpoint(): void
    {
        $response = $this->getJson('/api/health');

        $response->assertStatus(200)
            ->assertJson(['status' => 'ok']);
    }

    public function test_consultant_cannot_book_themselves(): void
    {
        $user = User::factory()->create(['role' => 'consultant']);
        $profile = ConsultantProfile::create([
            'user_id' => $user->id,
            'slug' => 'test-consultant',
            'title' => 'Test Consultant',
            'hourly_rate' => 100,
            'is_active' => true,
        ]);

        $bookingService = app(BookingService::class);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Bạn không thể tự đặt lịch tư vấn với chính mình.');

        $bookingService->createBooking(
            $user->id,
            $profile,
            now()->addDay()->format('Y-m-d 10:00:00'),
            30
        );
    }

    public function test_setting_can_be_retrieved_and_saved(): void
    {
        Setting::set('platform_fee', 15.00);

        $this->assertEquals(15.00, Setting::get('platform_fee'));
    }
}

