<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Consultation;
use Illuminate\Support\Facades\Log;

class CancelUnpaidBookingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Consultation $consultation;

    /**
     * Create a new job instance.
     */
    public function __construct(Consultation $consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Refresh data from DB
        $this->consultation->refresh();

        if ($this->consultation->status === 'pending') {
            $this->consultation->update(['status' => 'cancelled']);
            
            // Cập nhật trạng thái Payment nếu có
            if ($this->consultation->payment) {
                $this->consultation->payment->update(['status' => 'cancelled']);
            }
            
            Log::info("Booking {$this->consultation->ulid} has been auto-cancelled due to unpaid status.");
        }
    }
}
