<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank_format_countries extends Model
{
    protected $table = 'bank_format_countries';
	
    protected $fillable = ['bank_format_id','country_id'];

    public $timestamps = false;

    public function getbankFormat($id)
    {
    	return $this->where('country_id', $id)->first();
    }

    public function bank_format()
    {
    	return $this->belongsTo('App\Models\Bank_format', 'bank_format_id');
    }

}
