<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Job_application,MessageConversation,MessageRoom};

class MessageController extends Controller
{
    
    protected $data;

    public function allThreads()
    {
        $my_id = my_id();

        $this->data['allThreads']  = MessageRoom::has('employer')->with(['job','specialist','admin'])->orderBy('id', 'DESC')->where(['can_id'=>$my_id,'deleted_by_can'=>null])->paginate(4);

        return view('candidateApp.messages.all-threads',$this->data);
    }


    public function chat($roomId)
    {   
        try
        {
            $obj = json_decode(base64_decode($roomId));
        
            $this->data['JobApplication'] = Job_application::with(['job'])->where(['id'=>$obj->appId])->first();

            $this->data['room'] = MessageRoom::with(['candidate', 'specialist', 'employer','admin'])->where(['room_id'=>$roomId])->first();

            $this->data['messageConversations'] = MessageConversation::orderBy('id','Desc')->where(['room_id'=>$roomId])->paginate(2);

            $this->data['roomId'] = $roomId;
            return view('candidateApp.messages.chat',$this->data);
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
        $specialistId = !empty($obj->spcId) ? $obj->spcId:'';
        $adminId = !empty($obj->adminId) ? $obj->adminId:'';
        $jobId = $obj->jobId;
        $applicationId = $obj->appId;

        $checkThread = MessageRoom::where(['room_id'=>$request->roomId])->first();

        if(!empty($checkThread))
        {

            MessageRoom::where(['room_id'=>$request->roomId])->update(['last_message'=>$request->message,'last_message_date_time'=>date("Y-m-d H:i:s")]);

            $messageConversation  = new MessageConversation();
            $messageConversation->room_id = $checkThread->room_id;
            $messageConversation->sender_id = $my_id;
            $messageConversation->sender_type = 'candidate';
            if(!empty($specialistId))
            {
                $messageConversation->receiver_id = $specialistId;
                $messageConversation->receiver_type = 'specialist';
            }
            if(!empty($adminId))
            {
                $messageConversation->receiver_id = $adminId;
                $messageConversation->receiver_type = 'admin';
            }
            $messageConversation->message = $request->message;
            $messageConversation->save();
        }
        else
        {
            $messageRoom = new MessageRoom();
            $messageRoom->room_id   = $request->roomId;
            $messageRoom->can_id    = $my_id;
            if(!empty($specialistId))
            {
                
                $messageRoom->spc_id    = $specialistId;
            }
            if(!empty($adminId))
            {
                 $messageRoom->admin_id    = $adminId;
            }
            $messageRoom->job_id    = $jobId;
            $messageRoom->application_id = $applicationId;
            $messageRoom->last_message = $request->message;
            $messageRoom->last_message_date_time = date("Y-m-d H:i:s");
            $save = $messageRoom->save();

            if($save)
            {
                $messageConversation  = new MessageConversation();
                $messageConversation->room_id = $request->roomId;
                $messageConversation->sender_id = $my_id;
                $messageConversation->sender_type = 'candidate';
                if(!empty($specialistId))
                {
                    $messageConversation->receiver_id = $specialistId;
                    $messageConversation->receiver_type = 'specialist';
                }
                if(!empty($adminId))
                {
                    $messageConversation->receiver_id = $adminId;
                    $messageConversation->receiver_type = 'admin';
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
            $messageRoom->deleted_by_can = date("Y-m-d");
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
