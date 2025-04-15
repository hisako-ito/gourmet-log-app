<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subjectText;
    public $bodyText;
    public $recipient;

    public function __construct($subjectText, $bodyText, $recipient)
    {
        $this->subjectText = $subjectText;
        $this->bodyText = $bodyText;
        $this->recipient = $recipient;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectText)
            ->view('emails.notice')
            ->with([
                'subjectText' => $this->subjectText,
                'bodyText' => $this->bodyText,
                'recipient' => $this->recipient,
            ]);
    }
}
