<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RateSetting extends Model
{
    protected $table = 'rate_setting';
    public $fillable = ['application_weight','job_fill_weight'];
    
}
