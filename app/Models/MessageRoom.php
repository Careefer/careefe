<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageRoom extends Model
{
    protected $table = 'message_rooms';

    protected $fillable = [
                  'room_id',
                  'can_id',
                  'spc_id',
                  'emp_id',
                  'admin_id',
                  'job_id',
                  'application_id',
                  'last_message',
                  'last_message_date_time'
              ];

    public function job()
    {   
        return $this->belongsTo('\App\Models\Employer_jobs','job_id', 'id');
    } 

     // relation candidate
    public function candidate()
    {   
        return $this->belongsTo('\App\Candidate','can_id');
    }

    public function specialist()
    {
        return $this->belongsTo("App\Specialist",'spc_id');
    }

    public function employer()
    {
        return $this->belongsTo("App\Employer",'emp_id');
    }

    public function admin()
    {
        return $this->belongsTo("App\Admin",'admin_id');
    }

    public function application()
    {   
        return $this->belongsTo('\App\Models\Job_application','application_id', 'id');
    } 

  
}
