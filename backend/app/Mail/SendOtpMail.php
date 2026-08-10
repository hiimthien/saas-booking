<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Password Reset OTP',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '
            <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e5e7eb; border-radius: 12px; background-color: #ffffff;">
                <h2 style="color: #059669; text-align: center; margin-bottom: 24px;">ConsultFlow</h2>
                <h3 style="color: #1f2937; margin-bottom: 16px;">Password Reset Request</h3>
                <p style="color: #4b5563; line-height: 1.6; margin-bottom: 24px;">
                    We received a request to reset your password. Use the following 6-digit verification code to securely change your password.
                </p>
                <div style="background-color: #f3f4f6; padding: 16px; border-radius: 8px; text-align: center; margin-bottom: 24px;">
                    <strong style="font-size: 32px; letter-spacing: 8px; color: #111827;">' . $this->otp . '</strong>
                </div>
                <p style="color: #6b7280; font-size: 14px; margin-bottom: 8px;">
                    This code will expire in <strong>5 minutes</strong>.
                </p>
                <p style="color: #6b7280; font-size: 14px;">
                    If you did not request a password reset, please ignore this email.
                </p>
            </div>',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
