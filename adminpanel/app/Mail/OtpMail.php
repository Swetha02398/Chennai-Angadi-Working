<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $customerName;

    public function __construct($otp, $customerName = 'Customer')
    {
        $this->otp = $otp;
        $this->customerName = $customerName;
    }

    public function build()
    {
        $fromAddress = config('mail.from.address', 'care@chennaiangadi.com');
        $fromName = config('mail.from.name', 'Chennai Angadi');

        return $this->from($fromAddress, $fromName)
                    ->replyTo($fromAddress, $fromName)
                    ->subject('Password Reset OTP - Chennai Angadi')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'customerName' => $this->customerName,
                    ]);
    }
}
