<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CmsFormRequest;
use App\Transformers\CmsTransformer;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Cms;
use Exception;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {   
            $model = Cms::query()->orderBy('id','desc');

            return datatables()->eloquent($model)
                        ->filter(function($query){

                            if(request()->has('title') && !empty(request('title')))
                            {   
                                $query->where("title","like","%".request('title')."%");
                            }

                            if(request()->has('slug') && !empty(request('slug')))
                            {   
                                $query->where("slug","like","%".request('slug')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {       
                                $query->where("status",request('status'));
                            }

                        })
                        ->setTransformer(new CmsTransformer(new Cms))
                        ->toJson();
        }
        $this->data['active_menue']     = 'content-management';
        $this->data['active_sub_menue'] = 'manage-cms-pages';
        return view('cms_pages.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['active_menue']     = 'content-management';
        $this->data['active_sub_menue'] = 'manage-cms-pages';
        return view('cms_pages.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CmsFormRequest $request)
    {
        try
        {    
            $data = $request->getData();
            
            Cms::create($data);

            request()->session()->flash('success','Record created successfully.');

            return redirect()->route('manage_cms_pages.manage_cms_page.index')
                ->with('success_message', 'Cms page was successfully added.');
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
        $cms = Cms::findOrFail($id);

        $this->data['active_menue']     = 'content-management';
        $this->data['active_sub_menue'] = 'manage-cms-pages';
        $this->data['cms']     = $cms;
        return view('cms_pages.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cms = Cms::findOrFail($id);

        $this->data['active_menue']     = 'content-management';
        $this->data['active_sub_menue'] = 'manage-cms-pages';
        $this->data['cms']     = $cms;

        return view('cms_pages.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, CmsFormRequest $request)
    {
        try {
                $data = $request->getData();
                $cms = Cms::findOrFail($id);
                $cms->update($data);
                request()->session()->flash('success','Record updated successfully.');
                return redirect()->route('manage_cms_pages.manage_cms_page.index')
                    ->with('success_message', 'Cms page was successfully updated.');
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
            $cms = Cms::findOrFail($id);
            $cms->delete();

            request()->session()->flash('success','Record deleted successfully.');
            return redirect()->route('manage_cms_pages.manage_cms_page.index')
                ->with('success_message', 'Cms was successfully deleted.');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
