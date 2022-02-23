<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\EmailTrait;


class JobReferByEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels , EmailTrait;

    private $data = [];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->sendEmail('refer-job',$this->data);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //$this->sendEmail('refer-job',$this->data);
    }
}
