<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $reservation;
    public $qrImage;

    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
        $url = route('reservation.qr', ['token' => $reservation->qr_token]);
        $this->qrImage = 'data:image/png;base64,' . base64_encode(QrCode::format('png')->size(200)->generate($url));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('【予約変更のお知らせ】')
            ->view('emails.reservation.updated');
    }
}
