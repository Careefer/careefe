<?php

namespace App;

use App\Notifications\EmployerResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;



class Employer extends Authenticatable
{
    use Notifiable,SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employers';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
                            'company_id',
                            'name',
                            'email',
                            'mobile',
                            'status',
                            'password',
                            'location_id',
                            'time_zone_id',
                            'currency_id',
                            'last_login',
                            'term_and_condition',
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
        $this->notify(new EmployerResetPassword($token));
    }

    /*
     * get next candidate id
     * 
     * @return string
     */
    public static function getNextEmployerId()
    {
        $employer_id = Employer::orderBy('id','desc')->value('id');

        $employer_id = ($employer_id)?$employer_id+1:1;

        return 'EMP-'.str_pad($employer_id,4,"0",STR_PAD_LEFT);
    }

    /**
     * Get industry Id
     */
    public function industry()
    {
        return $this->belongsTo('App\Models\Industry','industry_id');
    }


    // Deleted
    /*public function branch_offices()
    {
        return $this->hasMany('App\Models\Employer_branch_office');
    }*/

    /**
     * relation for itmezone
     */
    public function timezone()
    {   
        return $this->belongsTo('App\Models\TimeZones','time_zone_id');
    }

    /**
     * relation for currency
     */
    public function currency()
    {   
        return $this->belongsTo('App\Models\Currency','currency_id');
    }

    /**
     * relation for itmezone
     */
    public function company_detail()
    {   
        return $this->belongsTo('App\Models\EmployerDetail','company_id');
    }

    /**
     * relation to get location
     */
    public function my_location()
    {
        return $this->belongsTo("App\Models\WorldLocation","location_id")->where(['status'=>'active']);
    }
}
