<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailNewsletterJob;
use App\Http\Requests\NewsletterFormRequest;
use App\Transformers\NewsletterTransformer;
use App\Http\Controllers\SendNotificationController;
use App\Models\Newsletter;
use App\Candidate;
use App\Employer;
use App\Specialist;

use Exception;

class NewsletterController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'newsletters';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = Newsletter::query();

            $obj = datatables()->eloquent($model)
                        ->filter(function($query){

                        if(request()->has('title') && !empty(request('title')))
                        {   
                            $query->where("title","like","%".request('title')."%");
                        }

                        if(request()->has('user_group') && !empty(request('user_group')))
                        {       
                            $query->where("user_group",request('user_group'));
                        }

                        if(request()->has('subject') && !empty(request('subject')))
                        {       
                            $query->where("subject",request('subject'));
                        }
                        if(request()->has('created_at') && !empty(request('created_at')))
                        {       
                            $created_at = get_date_db_format(request('created_at'));

                            $query->where("created_at","like","%$created_at%");
                        }

                    })->setTransformer(new NewsletterTransformer(new Newsletter))->toJson();

             return $obj;           
        }

        return view('newsletters.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('newsletters.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NewsletterFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();

            if($request->hasFile('attachments')) 
            {
        
                $attachment = $request->file('attachments');
                $data['attachments'] = time().'.'.$attachment->extension();
                 
                $destinationPath = public_path('/storage/newsletters');
                $attachment->move($destinationPath, $data['attachments']);
         
            }

            Newsletter::create($data);
            return redirect()->route('newsletters.newsletter.index')
                ->with('success', 'Newsletter has been added successfully .');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function send($id)
    {
        try
        {
            $newsletter = Newsletter::findOrFail($id);

            if($newsletter->user_group == 'all')
            {
                  // sent candidate
                  $candidates = Candidate::all();
                  foreach ($candidates as  $candidate) 
                  {
                        $emails = $candidate->email;
                        SendEmailNewsletterJob::dispatch($emails,$newsletter)->delay(now());

                  }
                  $user_type = 'candidate';
                  (new SendNotificationController)->NewsletterNotification($user_type);

                  // sent employer
                  $employers = Employer::all();
                  foreach ($employers as  $employer) 
                  {
                        $emails=$employer->email;
                        SendEmailNewsletterJob::dispatch($emails,$newsletter)->delay(now());
                  }

                   $user_type = 'employer';
                  (new SendNotificationController)->NewsletterNotification($user_type);

                  //sent specialist
                  $specialists = Specialist::all();
                  foreach ($specialists as  $specialist) 
                  {
                        $emails=$specialist->email;
                        SendEmailNewsletterJob::dispatch($emails,$newsletter)->delay(now());
                  }
                  
                   $user_type = 'specialist';
                  (new SendNotificationController)->NewsletterNotification($user_type);
            }

            elseif($newsletter->user_group == 'candidate')
            {
                  $candidates = Candidate::all();
                  foreach ($candidates as  $candidate) 
                  {
                        $emails = $candidate->email;
                        $candidate_id = $candidate->id;
                        SendEmailNewsletterJob::dispatch($emails,$newsletter)->delay(now());

                  }
                  $user_type = 'candidate';
                  (new SendNotificationController)->NewsletterNotification($user_type);
            }

            elseif($newsletter->user_group == 'employer')
            {
                  $employers = Employer::all();
                  foreach ($employers as  $employer) 
                  {
                        $emails=$employer->email;
                        SendEmailNewsletterJob::dispatch($emails,$newsletter)->delay(now());
                  }
                   $user_type = 'employer';
                  (new SendNotificationController)->NewsletterNotification($user_type);
            }

            elseif($newsletter->user_group == 'specialist')
            {
                  $specialists = Specialist::all();
                  foreach ($specialists as  $specialist) 
                  {
                        $emails=$specialist->email;
                        SendEmailNewsletterJob::dispatch($emails,$newsletter)->delay(now());
                  } 
                   $user_type = 'specialist';
                  (new SendNotificationController)->NewsletterNotification($user_type);
            }

            else
            {
                return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
            }
             
             return redirect()->route('newsletters.newsletter.index')
                    ->with('success', 'Newsletter has been sent successfully .'); 
        }
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $newsletter = Newsletter::findOrFail($id);
        $this->data['newsletter'] = $newsletter;
        return view('newsletters.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, NewsletterFormRequest $request)
    {
        try
        { 
            $data = $request->getData();
            
            $newsletter = Newsletter::findOrFail($id);

           if($request->hasFile('attachments')) 
            {
               
                $attachment = $request->file('attachments');
                $data['attachments'] = time().'.'.$attachment->extension();
                $destinationPath = public_path('/storage/newsletters');
                $attachment->move($destinationPath, $data['attachments']);

            }

            $newsletter->update($data);
            return redirect()->route('newsletters.newsletter.index')
                ->with('success', 'Newsletter has been updated successfully .');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try {
            $newsletter = Newsletter::findOrFail($id);
            $newsletter->delete();
            return redirect()->route('newsletters.newsletter.index')
                ->with('success', 'Newsletter has been deleted successfully.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
