<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Transformers\MessageTransformer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Employer_jobs,Job_application,MessageConversation,MessageRoom};
use Exception;



class MessageController extends Controller
{   
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-messages';
    }

    /**
     * Display a listing of the blogs.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $adminId = Auth::user()->id;

            $allThreads  = MessageRoom::with(['job','application','specialist','admin'])->orderBy('id', 'DESC')->where(['admin_id'=>$adminId]);

             return Datatables::eloquent($allThreads)
                        ->setTransformer(new MessageTransformer(new MessageRoom))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'messages';
        return view('messages.all-threads',$this->data);
    }
    /**
     * Display the specified blog.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($roomId)
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
             $this->data['active_sub_menue'] = 'messages';
            return view('messages.chat',$this->data);
        } 
        catch (\Exception $e) 
        {
           dd($e->getMessage());
        }
    }
   
    /**
     * Store a new blog in the storage.
     *
     * @param App\Http\Requests\BlogsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $adminId = Auth::user()->id;
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
            $messageConversation->sender_id = $adminId;
            $messageConversation->sender_type = 'admin';
            if(!empty($specialistId))
            {
                $messageConversation->receiver_id = $specialistId;
                $messageConversation->receiver_type = 'specialist';
            }
            if(!empty($candidateId))
            {
                $messageConversation->receiver_id = $candidateId;
                $messageConversation->receiver_type = 'candidate';
            }
            if(!empty($employerId))
            {
                $messageConversation->receiver_id = $employerId;
                $messageConversation->receiver_type = 'employer';
            }
            $messageConversation->message = $request->message;
            $messageConversation->save();
        }
        else
        {
            $messageRoom = new MessageRoom();
            $messageRoom->room_id   = $request->roomId;
            $messageRoom->admin_id    = $adminId;
            
            if(!empty($specialistId))
            {
                 $messageRoom->spc_id    = $specialistId;
            }

            if(!empty($candidateId))
            {
                 $messageRoom->can_id    = $candidateId;
            }

            if(!empty($employerId))
            {
                 $messageRoom->emp_id    = $employerId;
            }
            $messageRoom->job_id    = $jobId;
            //$messageRoom->application_id = $applicationId;
            $messageRoom->last_message = $request->message;
            $messageRoom->last_message_date_time = date("Y-m-d H:i:s");
            $save = $messageRoom->save();

            if($save)
            {
                $messageConversation  = new MessageConversation();
                $messageConversation->room_id = $request->roomId;
                $messageConversation->sender_id = $adminId;
                $messageConversation->sender_type = 'admin';
                if(!empty($specialistId))
                {
                    $messageConversation->receiver_id = $specialistId;
                    $messageConversation->receiver_type = 'specialist';
                }
                if(!empty($candidateId))
                {
                    $messageConversation->receiver_id = $candidateId;
                    $messageConversation->receiver_type = 'candidate';
                }
                if(!empty($employerId))
                {
                    $messageConversation->receiver_id = $employerId;
                    $messageConversation->receiver_type = 'employer';
                }
                $messageConversation->message = $request->message;
                $messageConversation->save();
            }
        }
        return redirect()->back();       
    }



    /**
     * Remove the specified blog from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $blog->delete();
            return redirect()->route('blogs.blog.index')
                ->with('success', 'Blog has been deleted successfully.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }



}
