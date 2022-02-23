<?php

namespace App;

use App\Notifications\SpecialistResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialist extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		  'specialist_id',
		  'name',
		  'first_name',
		  'last_name',
		  'email',
          'location',
		  'password',
          'image',
		  'functional_area_ids',
          'resume',
		  'status',
          'term_and_condition',
          'last_login'
	  ];

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
        $this->notify(new SpecialistResetPassword($token));
    }
	
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
               'deleted_at'
           ];
    
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    /**
     * Get the functionalArea for this model.
     *
     * @return App\Models\FunctionalArea
     */
    /*public function functionalArea()
    {
        return $this->belongsTo('App\Models\FunctionalArea','functional_area_id');
    }*/
	
	/*
     * get next candidate id
     * 
     * @return string
     */
    public static function getNextId()
    {
        $id = self::orderBy('id','desc')->value('id');

        $id = ($id)?$id+1:1;

        return 'SP-'.str_pad($id,9,"0",STR_PAD_LEFT);
    }

    /**
     * relation current location
     */
    public function current_location()
    {
        return $this->hasOne("App\Models\UserLocation",'user_id')->where(['location_type'=>'current','user_type'=>'specialist']);
    }

    /**
     * relation current location
     */
    public function permanent_location()
    {
        return $this->hasOne("App\Models\UserLocation",'user_id')->where(['location_type'=>'permanent','user_type'=>'specialist']);
    }

    /**
     * relation career history
     */
    public function career_history()
    {
        return $this->hasMany("App\Models\UserCareerHistory",'user_id')->where(['user_type'=>'specialist']);
    }

    public function current_company()
    {   
        return $this->hasOne("App\Models\UserCareerHistory",'user_id')->where(['user_type'=>'specialist','is_current_company'=>'yes'])->orderBy('id','desc');
    }
    /**
     * relation education history
     */
    public function education_history()
    {
        return $this->hasMany("App\Models\UserEducationHistory",'user_id')->where(['user_type'=>'specialist']);
    }

    /**
     * functional functional_area
     */
    public function functional_area()
    {   
        $functional_area_ids    = $this->functional_area_ids;

        $data       = [];
        if($functional_area_ids)
        {
            $id_arr = explode(',', $functional_area_ids);
            $sql = \App\Models\FunctionalArea::whereIn('id',$id_arr)->where(['status'=>'active'])->pluck('name','id');
            if($sql)
            {
                $data = $sql->toarray();
            }
        }
        return $data;
    }

    /**
     * my location by id
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
        return $this->hasMany('App\Models\specialistBankDetail', 'specialist_id');
    }      
}
