<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank_format_field extends Model
{
    protected $table = 'bank_format_fields';

    public function value()
    {	$my_id = my_id();
    	return $this->hasOne('App\Models\CandidateBankDetail', 'bank_format_field_id')->where('candidate_id', $my_id);
    }

    public function specialist_value()
    {	$my_id = my_id();
    	return $this->hasOne('App\Models\specialistBankDetail', 'bank_format_field_id')->where('specialist_id', $my_id);
    }


}
