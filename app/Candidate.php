<?php

namespace App;

use App\Notifications\CandidateResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class Candidate extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                'candidate_id',
                'name',
                'first_name',
                'last_name',
                'email',
                'phone',
                'password',
                'image',
                'official_email',
                'profile_summary',
                'timezone',
                'currency',
                'skills',
                'location_str',
                'current_company',
                'recent_education',
                'resume',
                'cover_letter',
                'status',
                'social_id',
                'social_type',
                'term_and_condition',
    ];

    //protected $table = 'candidates';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CandidateResetPassword($token));
    }

    /*
     * get next candidate id
     * 
     * @return string
     */
    public static function getNextCandidateId()
    {
        $candidate_id = Candidate::orderBy('id','desc')->value('id');

        $candidate_id = ($candidate_id)?$candidate_id+1:1;

        return 'CN-'.str_pad($candidate_id,9,"0",STR_PAD_LEFT);
    }

    /**
     * Get the candidate for this model.
     *
     * @return App\Models\Candidate
     */
    public function candidate()
    {
        return $this->belongsTo('App\Models\Candidate','candidate_id');
    }

    /**
     * relation current location
     */
    public function current_location()
    {
        return $this->hasOne("App\Models\UserLocation",'user_id')->where(['location_type'=>'current','user_type'=>'candidate']);
    }

    /**
     * relation current location
     */
    public function permanent_location()
    {
        return $this->hasOne("App\Models\UserLocation",'user_id')->where(['location_type'=>'permanent','user_type'=>'candidate']);
    }

    /**
     * relation career history
     */
    public function career_history()
    {
        return $this->hasMany("App\Models\UserCareerHistory",'user_id')->where(['user_type'=>'candidate']);
    }

    /**
     * current company
     */
    public function current_company()
    {   
        return $this->hasOne("App\Models\UserCareerHistory",'user_id')->where(['user_type'=>'candidate','is_current_company'=>'yes'])->orderBy('id','desc');
    }


    public function lastest_company()
    {   
        return $this->hasOne("App\Models\UserCareerHistory",'user_id')->where(['user_type'=>'candidate','is_current_company'=>'yes'])->orderBy('id','desc');
    }


    /**
     * current company
     */
    public function recent_education()
    {   
        return $this->hasOne("App\Models\UserEducationHistory",'user_id')->where(['user_type'=>'candidate','currently_pursuing'=>'yes']);
    }

    /**
     * relation education history
     */
    public function education_history()
    {
        return $this->hasMany("App\Models\UserEducationHistory",'user_id')->where(['user_type'=>'candidate']);
    }

    /**
     *
     */
    public static function get_location_by_id($id)
    {
        $sql = \App\Models\WorldLocation::select('id','location')->where(['id'=>$id])->get();

        if($sql->count())
        {
            return $sql->first();
        }

        return null;
    }


    public function get_country_from_bank_detail(){
        return $this->hasMany('App\Models\CandidateBankDetail', 'candidate_id');
    }


}
