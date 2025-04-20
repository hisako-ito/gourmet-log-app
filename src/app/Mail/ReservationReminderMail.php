<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $reservation;

    public function __construct($reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $dateFormatted = \Carbon\Carbon::parse($this->reservation->date)->format('Y年m月d日');
        $timeFormatted = \Carbon\Carbon::parse($this->reservation->time)->format('H:i');

        return $this->subject('【ご予約のご案内】本日のご来店予定')->view('emails.reservation.reservation_reminder')->with([
            'reservation' => $this->reservation,
            'dateFormatted' => $dateFormatted,
            'timeFormatted' => $timeFormatted,
        ]);
    }
}
