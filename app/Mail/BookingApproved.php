<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $adminContact;

    public function __construct(Booking $booking, $adminContact)
    {
        $this->booking = $booking;
        $this->adminContact = $adminContact;
    }

    public function build()
    {
        return $this->subject('Booking Approved - AC Repair Service')
                    ->view('emails.booking-approved')
                    ->with([
                        'booking' => $this->booking,
                        'adminContact' => $this->adminContact
                    ]);
    }
}