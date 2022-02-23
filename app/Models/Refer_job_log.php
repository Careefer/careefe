<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refer_job_log extends Model
{
    protected $table = 'refer_job_log';

    public $fillable = [
    					'refer_by_id',
    					'job_id',
    					'friend_email',
    					'job_url',
    				];
}
