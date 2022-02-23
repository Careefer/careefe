<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Job_alert;

class AlertController extends Controller
{
    public function index()
    {
        $id = my_id();	
        $jobAlerts = Job_alert::where(['candidate_id'=>$id])->paginate(5);
    	return view('candidateApp.alerts.index', compact('jobAlerts'));
    }

    public function deleteAlert($id)
    {
         $id = decrypt($id);
         $jobAlert = Job_alert::FindOrFail($id);
         if($jobAlert)
         {
            $jobAlert->delete();
            request()->session()->flash('success','Alert deleted successfully');
            return redirect()->back();
         }
        
    }
}
