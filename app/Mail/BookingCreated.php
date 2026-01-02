<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking; // rename here

    public function __construct(array $emailData)
    {
        $this->booking = $emailData; // assign it to $booking
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Your Booking is Confirmed!')
                    ->view('emails.booking_created'); // your email view
    }
}

