<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer_job_location extends Model
{
    protected $table = 'employer_job_locations';
    protected $fillable = [
    						'employer_job_id',
    						'country_id',
    						'state_id'	
    					];
	public $timestamps = false;    					
}
