<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendEmailNewsletter;
use Illuminate\Support\Facades\Mail;


class SendEmailNewsletterJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $emails = null;
    public $newsletter = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($emails,$newsletter)
    {
        $this->emails = $emails;
        $this->newsletter = $newsletter;
               

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
        Mail::to($this->emails)->send(new SendEmailNewsletter($this->newsletter));
    }
}
