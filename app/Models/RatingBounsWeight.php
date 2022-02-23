<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingBounsWeight extends Model
{
    protected $table = 'rating_bouns_weights';
    
    public $fillable = ['rating','bouns_rate'];
}
