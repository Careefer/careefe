<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotificationSetting extends Model
{
    protected $fillable = [
                  'user_id',
                  'notification_setting_id',
                  'user_type',
              ];

    public function notifications(){
        return $this->belongsTo('App\Models\NotificationSetting','notification_setting_id','id');
    }
}
