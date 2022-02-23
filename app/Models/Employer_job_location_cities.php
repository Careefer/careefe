<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer_job_location_cities extends Model
{
    protected $table = 'employer_job_location_cities';

    protected $fillable = [
    						'employer_job_location_id',
    						'employer_job_id',
    						'city_id'
    					];
	public $timestamps = false;
}
