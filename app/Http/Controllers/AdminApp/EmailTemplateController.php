<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmailTemplateFormRequest;
use App\Transformers\EmailTemplateTransformer;
use Yajra\DataTables\Facades\DataTables;
use App\Models\EmailTemplate;
use Exception;

class EmailTemplateController extends Controller
{
    
    private $data = [];

    public function __construct()
    {   
        $this->data['active_menue'] = 'settings';
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
            $model = EmailTemplate::query();

            return datatables()->eloquent($model)
                            ->filter(function($query){

                            if(request()->has('title') && !empty(request('title')))
                            {   
                                $query->where("title","like","%".request('title')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $query->where("status",request('status'));
                            }

                        })
                        ->setTransformer(new EmailTemplateTransformer(new EmailTemplate))
                        ->toJson();
        }
        $this->data['active_sub_menue'] = 'email-templates';
        return view('email_templates.index', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['active_sub_menue'] = 'email-templates';
        return view('email_templates.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailTemplateFormRequest $request)
    {
        try
        {    
            $data = $request->getData();
            $data['name'] = slug_url($data['title']);
            EmailTemplate::create($data);

            return redirect()->route('email_templates.email_template.index')
                ->with('success', 'Email Template has been added successfully.');
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
        $emailTemplate = EmailTemplate::findOrFail($id);
        $this->data['active_sub_menue']   = 'email-templates';
        $this->data['emailTemplate']      = $emailTemplate;
        return view('email_templates.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $emailTemplate = EmailTemplate::findOrFail($id);

        $this->data['active_sub_menue'] = 'email-templates';
        $this->data['emailTemplate']     = $emailTemplate;
        return view('email_templates.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, EmailTemplateFormRequest $request)
    {
        try 
        {
            
            $data = $request->getData();
            
            $emailTemplate = EmailTemplate::findOrFail($id);
            $emailTemplate->update($data);
            return redirect()->route('email_templates.email_template.index')
                ->with('success', 'Email Template has been updated successfully.');
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
        try 
        {
            $emailTemplate = EmailTemplate::findOrFail($id);
            $emailTemplate->delete();
            return redirect()->route('email_templates.email_template.index')
                ->with('success', 'Email Template has been deleted successfully.');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
