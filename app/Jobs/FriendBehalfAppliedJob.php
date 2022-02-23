<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Traits\EmailTrait;

class FriendBehalfAppliedJob implements ShouldQueue
{
    use EmailTrait, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sendEmail('candidate-friend-apply-job',$this->data);
    }
}
