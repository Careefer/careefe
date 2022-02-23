<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailForPaymentStatusChange extends Mailable
{
    use Queueable, SerializesModels;

    public $data = null;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if($this->data['type'] == 'employer')
        {
          return $this->from('no-reply@thesst.com','admin')
                      ->subject($this->data['subject'])->markdown('email.email_to_employer_payment_status')->with(['content'=>$this->data]);

        }elseif($this->data['type'] == 'referee')
        {
          return $this->from('no-reply@thesst.com','admin')
                      ->subject($this->data['subject'])->markdown('email.email_to_referee_payment_status')->with(['content'=>$this->data]);
        }elseif($this->data['type'] == 'specialist')
        {
          return $this->from('no-reply@thesst.com','admin')
                      ->subject($this->data['subject'])->markdown('email.email_to_specialist_payment_status')->with(['content'=>$this->data]);
        }        
    }
}
