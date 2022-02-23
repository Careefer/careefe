<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserNotificationSetting;


class NotificationController extends Controller
{
    public function index()
    {
        $guard_name = Auth::getDefaultDriver();
        $id = my_id();
    	
        $all_setting_notifications = UserNotificationSetting::with(['notifications'])->where(['user_id'=>$id,'user_type'=>$guard_name])->get();

    	$all_notifications =  Auth::user()->notifications()->paginate(5);
    	return view('notifications.index', compact('all_notifications','all_setting_notifications'));
    }

    public function readNotification()
    {
    	$success =  Auth::user()->unreadNotifications->markAsRead();
    	
    	echo 'success';
    	
    }

    public function notification_status(Request $request)
    {
        $id = $request->id;

        $notification_status = UserNotificationSetting::findOrFail($id);

        if($notification_status->status=='1')
        {
            $notification_status->status='0';
        }
        else
        {
            $notification_status->status='1';
        }
        $save = $notification_status->save();
        if($save)
        {
            echo "Success";
        }

    }
}
