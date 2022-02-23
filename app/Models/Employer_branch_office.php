<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer_branch_office extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'employer_branch_offices';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    public $timestamps = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'employer_id',
                  'location_id',
                  'country_id',
                  'state_id',
                  'city_id',
                  'total_active_jobs'
              ];

}
