<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($newsletter)
    {
        $this->newsletter = $newsletter;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $newsletter = $this->newsletter;
        return $this->from('no-reply@thesst.com','admin')
        ->view('email_newsletters.newsletter_email', compact('newsletter'));
    }
}
