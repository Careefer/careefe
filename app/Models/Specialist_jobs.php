<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Specialist_jobs extends Model
{
    use SoftDeletes;

    protected $table = 'specialist_jobs';

    protected $fillable = [
                  'job_id',
                  'primary_specialist_id',
                  'secondary_specialist_id',
                  'status',
                  'is_current_specialist'
              ];

	// relation job
    public function job()
    {   
        return $this->belongsTo('\App\Models\Employer_jobs','job_id');
    }             
}
