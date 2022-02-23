<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLocation extends Model
{
    protected $table = 'user_locations';
    protected $fillable = [
                'user_id',
                'user_type',
                'location_type',
                'location_id',
                'zip_code',
                'address' 
    ];

    // relation candidate
    public function world_location()
    {   
        return $this->belongsTo('\App\Models\WorldLocation','location_id');
    } 
}
