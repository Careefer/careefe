<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillsFormRequest;
use App\Transformers\SkillTransformer;
use App\Models\skill;
use Exception;


class SkillsController extends Controller
{

    
    private $data = [];
    /**
     * Display a listing of the skills.
     *
     * @return Illuminate\View\View
     */
    public function index()
    {

        if(request()->ajax())
        {   
            $model = skill::query();

            return datatables()->eloquent($model)
                    ->filter(function($query){

                        if(request()->has('name') && !empty(request('name')))
                        {   
                            $query->where("name","like","%".request('name')."%");
                        }

                        if(request()->has('status') && !empty(request('status')))
                        {       
                            $query->where("status",request('status'));
                        }

                        if(request()->has('date') && !empty(request()->get('date')))
                        {       
                            $date = get_date_db_format(request()->get('date'));
                            $query->where("created_at","like","%".$date."%");
                        }
                    })
                    ->setTransformer(new SkillTransformer(new skill))
                    ->toJson();
        }
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'skill';
        return view('skills.index',$this->data);
    }

    /**
     * Show the form for creating a new skill.
     *
     * @return Illuminate\View\View
     */
    public function create()
    {
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'skill';
        return view('skills.create', $this->data);
    }

    /**
     * Store a new skill in the storage.
     *
     * @param App\Http\Requests\SkillsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function store(SkillsFormRequest $request)
    {
        try 
        {
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            
            skill::create($data);
            
            request()->session()->flash('success_notify','Record created successfully.');

            return redirect()->route('skills.skill.index');
        } 
        catch (Exception $exception) 
        {

            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }

    /**
     * Display the specified skill.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function show($id)
    {
        $skill = skill::findOrFail($id);
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'skill';
        $this->data['skill']     = $skill;
        return view('skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified skill.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit($id)
    {
        $skill = skill::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-job-attribute';
        $this->data['active_sub_menue'] = 'skill';
        $this->data['skill']            = $skill;
        return view('skills.edit', $this->data);
    }

    /**
     * Update the specified skill in the storage.
     *
     * @param int $id
     * @param App\Http\Requests\SkillsFormRequest $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update($id, SkillsFormRequest $request)
    {
        try
        {
            
            $data = $request->getData();
            $data['slug'] = slug_url($data['name']);
            $skill = skill::findOrFail($id);
            $skill->update($data);

            request()->session()->flash('success_notify','Record updated successfully.');
            
            return redirect()->route('skills.skill.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }        
    }

    /**
     * Remove the specified skill from the storage.
     *
     * @param int $id
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        try
        {
            $skill = skill::findOrFail($id);
            $skill->delete();

            request()->session()->flash('success_notify','Record deleted successfully.');

            return redirect()->route('skills.skill.index');

        }
        catch (Exception $exception)
        {
            request()->session()->flash('error','Unexpected error occurred while trying to process your request.');

            return back()->withInput();
        }
    }
}
