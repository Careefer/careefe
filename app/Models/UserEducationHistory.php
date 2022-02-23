<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class UserEducationHistory extends Model
{   
    use SoftDeletes;
    
    protected $table = 'user_education_history';
    protected $fillable = [
                'user_id',
                'user_type',
                'qualification',
                'course',
                'institute',
                'degree',
                'grade',
                'country_id',
                'state_id',
                'city_id',
                'start_date',
                'end_date',
                'specialization',
                'currently_pursuing'
                
    ];
}
