<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Jobs\ProcessConsultantPayoutsJob;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Chạy mỗi phút: Nhắc nhở lịch hẹn sắp tới (trước 1 tiếng)
Schedule::command('booking:remind')->everyMinute();

// Chạy mỗi 15 phút: Tự động hoàn thành các cuộc hẹn đã kết thúc
Schedule::command('booking:complete')->everyFifteenMinutes();

// Chạy định kỳ vào 00:00 ngày 1 hàng tháng: Chốt lương cho chuyên gia
Schedule::job(new ProcessConsultantPayoutsJob)->monthlyOn(1, '00:00');
