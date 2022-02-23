<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class specialistBankDetail extends Model
{
  protected $table = 'specialist_bank_details';

  protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
  protected $fillable = [
                  'bank_format_id',
                  'bank_format_field_id',
                  'name',
                  'label',
                  'value',
                  'specialist_id',
                  'country_id',
              ];

  public function get_country_name(){
        return $this->belongsTo('App\Models\Country', 'country_id');
  }

}
