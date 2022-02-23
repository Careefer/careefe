<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank_format extends Model
{
    protected $fillable = ['name'];

    protected $table = 'bank_formats';


    /**
     * Bank format countries
     */

    public function bank_format_countries_name()
    {
        return $this->belongsToMany('App\Models\Country','bank_format_countries','bank_format_id','country_id');
    }

    public function bank_format_countries()
    {
    	return $this->hasMany("App\Models\Bank_format_countries",'bank_format_id','id');
    }

    /**
     * Bank format fields
     */
    public function bank_format_fields()
    {
    	return $this->hasMany("App\Models\Bank_format_field",'bank_format_id','id');
    }


}
