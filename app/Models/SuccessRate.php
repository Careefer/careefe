<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuccessRate extends Model
{
    protected $table = 'success_rate';
    public $fillable = ['rating','rate'];
}
