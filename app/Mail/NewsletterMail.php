<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $body;
    public $unsubscribeLink;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $email)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->unsubscribeLink = url('/api/unsubscribe?email=' . urlencode($email));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.newsletter')
                    ->with([
                        'body' => $this->body,
                        'unsubscribeLink' => $this->unsubscribeLink,
                    ]);
    }
}
