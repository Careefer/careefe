<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFavoriteJob extends Model
{
    protected $table = 'user_favorite_job';

    public $fillable = ['candidate_id','job_id'];

    public function job()
    {   
        return $this->belongsTo('\App\Models\Employer_jobs','job_id');
    }  

}
