<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Consultation;
use App\Mail\ConsultationReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'booking:remind';

    /**
     * The console command description.
     */
    protected $description = 'Gửi email nhắc nhở cho các lịch hẹn sắp diễn ra trong 1 tiếng tới';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $targetTimeStart = $now->copy()->addMinutes(55);
        $targetTimeEnd = $now->copy()->addMinutes(65);

        $consultations = Consultation::with(['client', 'provider.user'])
            ->where('status', 'confirmed')
            ->whereBetween('start_time', [$targetTimeStart, $targetTimeEnd])
            ->get();

        $count = 0;
        foreach ($consultations as $consultation) {
            Mail::to($consultation->client->email)->queue(new ConsultationReminderMail($consultation, 'client'));
            Mail::to($consultation->provider->user->email)->queue(new ConsultationReminderMail($consultation, 'provider'));
            $count++;
        }

        $this->info("Đã gửi nhắc nhở cho {$count} lịch hẹn.");
        Log::info("SendRemindersCommand executed: Reminded {$count} bookings.");
    }
}
