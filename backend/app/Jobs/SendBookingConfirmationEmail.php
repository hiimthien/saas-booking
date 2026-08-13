<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Consultation;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmedMail;

class SendBookingConfirmationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Consultation $consultation;

    /**
     * Tự động retry tối đa 3 lần nếu Job thất bại (VD: lỗi mạng SMTP).
     */
    public $tries = 3;

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
        // Load relationships để tránh N+1 bên trong email template
        $this->consultation->loadMissing(['client', 'provider.user']);

        // Gửi email cho Khách hàng
        Mail::to($this->consultation->client->email)
            ->send(new BookingConfirmedMail($this->consultation, 'client'));
            
        // Gửi email cho Chuyên gia
        Mail::to($this->consultation->provider->user->email)
            ->send(new BookingConfirmedMail($this->consultation, 'provider'));
    }
}
