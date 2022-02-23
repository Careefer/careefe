<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecialistAssignmentLog extends Model
{
    protected $table = 'specialist_assignment_log';

  	protected $primaryKey = 'id';

  	protected $fillable = [
                  'specialist_id',
                  'user_type',
                  'job_id',
                  'status',
                  'is_current',
              ];

}
