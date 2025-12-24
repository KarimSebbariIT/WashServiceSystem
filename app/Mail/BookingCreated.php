<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct($booking)
    {
        $this->booking = $booking; // object sent from React
    }

    public function build()
    {
        return $this->subject('Your Booking is Confirmed')
                    ->view('emails.booking_created'); 
    }
}
