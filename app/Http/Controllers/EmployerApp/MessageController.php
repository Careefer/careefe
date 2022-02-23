<?php

namespace App\Http\Controllers\EmployerApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employer_jobs,Job_application,MessageConversation,MessageRoom};

class MessageController extends Controller
{
    protected $data;

    public function allThreads()
    {
        $my_id = my_id();

        $this->data['allThreads']  = MessageRoom::with(['job','candidate','specialist','admin'])->orderBy('id', 'DESC')->where(['emp_id'=>$my_id,'deleted_by_emp'=>null])->paginate(4);

        return view('employerApp.messages.all-threads',$this->data);
    }

   public function chat($roomId)
    {   
        try
        {
            $obj = json_decode(base64_decode($roomId));

            $applicationId = !empty($obj->appId)?$obj->appId:'';
            $jobId = !empty($obj->jobId)?$obj->jobId:'';


            $this->data['job'] = Employer_jobs::where(['id'=>$jobId])->first();
        
            $this->data['JobApplication'] = Job_application::with(['job'])->where(['id'=>$applicationId])->first();

            $this->data['room'] = MessageRoom::with(['candidate', 'specialist', 'employer','admin'])->where(['room_id'=>$roomId])->first();

            $this->data['messageConversations'] = MessageConversation::orderBy('id','Desc')->where(['room_id'=>$roomId])->paginate(2);

            $this->data['roomId'] = $roomId;
            return view('employerApp.messages.chat',$this->data);
        } 
        catch (\Exception $e) 
        {
           dd($e->getMessage());
        }
        
    }

    public function sendMessage(Request $request)
    { 
        $my_id = my_id();
        $obj = json_decode(base64_decode($request->roomId));
        $adminId        = !empty($obj->adminId) ? $obj->adminId:'';
        $jobId          = !empty($obj->jobId) ? $obj->jobId:'';
        $applicationId  = !empty($obj->appId) ? $obj->appId:'';
        $employerId     = !empty($obj->empId) ? $obj->empId:'';
        $specialistId   = !empty($obj->spcId) ? $obj->spcId:'';
        $candidateId    = !empty($obj->canId) ? $obj->canId:'';

        $checkThread = MessageRoom::where(['room_id'=>$request->roomId])->first();

        if(!empty($checkThread))
        {

            MessageRoom::where(['room_id'=>$request->roomId])->update(['last_message'=>$request->message,'last_message_date_time'=>date("Y-m-d H:i:s")]);

            $messageConversation  = new MessageConversation();
            $messageConversation->room_id = $checkThread->room_id;
            $messageConversation->sender_id = $my_id;
            $messageConversation->sender_type = 'employer';
            if(!empty($adminId))
            {
                $messageConversation->receiver_id = $adminId;
                $messageConversation->receiver_type = 'admin';
            }
            if(!empty($candidateId))
            {
                $messageConversation->receiver_id = $candidateId;
                $messageConversation->receiver_type = 'candidate';
            }
            if(!empty($specialistId))
            {
                $messageConversation->receiver_id = $specialistId;
                $messageConversation->receiver_type = 'specialist';
            }
            $messageConversation->message = $request->message;
            $messageConversation->save();
        }
        else
        {
            $messageRoom = new MessageRoom();
            $messageRoom->room_id   = $request->roomId;
            $messageRoom->emp_id    = $my_id;
            
            if(!empty($adminId))
            {
                 $messageRoom->admin_id    = $adminId;
            }

            if(!empty($specialistId))
            {
                 $messageRoom->spc_id    = $specialistId;
            }
            $messageRoom->job_id    = !empty($jobId) ? $jobId : null;
            $messageRoom->application_id = !empty($applicationId) ? $applicationId : null;
            $messageRoom->last_message = $request->message;
            $messageRoom->last_message_date_time = date("Y-m-d H:i:s");
            $save = $messageRoom->save();

            if($save)
            {
                $messageConversation  = new MessageConversation();
                $messageConversation->room_id = $request->roomId;
                $messageConversation->sender_id = $my_id;
                $messageConversation->sender_type = 'employer';
                if(!empty($adminId))
                {
                    $messageConversation->receiver_id = $adminId;
                    $messageConversation->receiver_type = 'admin';
                }
                if(!empty($specialistId))
                {
                    $messageConversation->receiver_id = $specialistId;
                    $messageConversation->receiver_type = 'specialist';
                }
                $messageConversation->message = $request->message;
                $messageConversation->save();
            }
        }
        return redirect()->back();
    }
    
    public function deleteThread($id)
    {
         $id = decrypt($id);
         $messageRoom = MessageRoom::FindOrFail($id);
         if($messageRoom){
            $messageRoom->deleted_by_emp = date("Y-m-d");
            if($messageRoom->save())
            {
                request()->session()->flash('success','Thread deleted successfully');
            }
            else
            {
                request()->session()->flash('error',SERVER_ERR_MSG);
            }
            return redirect()->back();
         }
    }
}
