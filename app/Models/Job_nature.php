<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job_nature extends Model
{
    protected $table = 'job_natures';

    protected $fillable = [
                  'title',
                  'icon'
              ];
}
