<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CandidatesFormRequest;
use App\Candidate;
use Exception;
use App\Transformers\CandidateTransformer;


class CandidatesController extends Controller
{
    private $data = [];

    public function __construct()
    {
        $this->data['active_menue'] = 'manage-users';
    }
    /**
     * Display a listing of the candidates.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {
        if(request()->ajax())
        {   
            
            $model = candidate::with('current_location.world_location');

            // filter application location
            if(request()->has('location') && !empty(request()->get('location')))
            {  
                $model = $model->whereHas('current_location',function($q)
                {
                    $q->whereHas('world_location',function($q2)
                    {   
                        $q2->where("location","like","%".request()->get('location')."%");
                    });
                });
                
            }

            return datatables()->eloquent($model->latest())
                        ->filter(function($q){

                            if(request()->has('candidate_id') && !empty(request('candidate_id')))
                            {   
                                $q->where("candidate_id","like","%".request('candidate_id')."%");
                            }

                            if(request()->has('name') && !empty(request('name')))
                            {   
                                $q->where("name","like","%".request('name')."%");
                            }

                            if(request()->has('email') && !empty(request('email')))
                            {   
                                $q->where("email","like","%".request('email')."%");
                            }

                            if(request()->has('phone') && !empty(request('phone')))
                            {   
                                $q->where("phone","like","%".request('phone')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $q->where("status",request('status'));
                            }
                        })
                        ->setTransformer(new CandidateTransformer(new candidate))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'candidate';
        return view('candidates.index',$this->data);
    }

    /**
     * Show the form for creating a new candidate.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {   
        $this->data['candidate_id'] = Candidate::getNextCandidateId();
        $this->data['active_sub_menue'] = 'candidate';
        return view('candidates.create',$this->data);
    }

    /**
     * Store a new candidate in the storage.
     *
     * @param App\Http\Requests\CandidatesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(CandidatesFormRequest $request)
    {  
        try
        {   
            $data = $request->getData();

            $data['name'] = $data['first_name'].' '.$data['last_name'];

            $password = $data['password'];

            $data['password'] = bcrypt($data['password']);

            $dta = Candidate::create($data);

            if($dta->id)
            {
                $details['first_name'] = $data['first_name'];
                $details['last_name'] = $data['last_name'];
                $details['email'] = $data['email'];
                $details['name'] = $data['name'];
                $details['candidate_id'] = $data['candidate_id'];
                $details['password'] = $password;
                dispatch(new \App\Jobs\CandidateSignupEmailJob($details));
            }

            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('candidates.candidate.index');
        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified candidate.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {   
        $this->data['candidate']        = Candidate::findOrFail($id);
        $this->data['active_sub_menue'] = 'candidate';
        return view('candidates.show', $this->data);
    }

    /**
     * Show the form for editing the specified candidate.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {   
        $this->data['candidate'] = Candidate::findOrFail($id);

        return view('candidates.edit', $this->data);
    }

    /**
     * Update the specified candidate in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\CandidatesFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, CandidatesFormRequest $request)
    {   
        try
        {
            $data = $request->getData();

            $data['name'] = $data['first_name'].' '.$data['last_name'];

            if(request()->get('password'))
            {
               $data['password'] =bcrypt($data['password']); 
            }
            else
            {
                unset($data['password']);
            }
            
            $candidate = Candidate::findOrFail($id);
            $candidate->update($data);

            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('candidates.candidate.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified candidate from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $candidate = Candidate::findOrFail($id);
            $candidate->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');
            return redirect()->route('candidates.candidate.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }
}
