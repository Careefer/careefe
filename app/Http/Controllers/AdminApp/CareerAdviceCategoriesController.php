<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerAdviceCategoriesFormRequest;
use App\Transformers\CareerAdviceCategoriesTransformer;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CareerAdviceCategory;
use Exception;

class CareerAdviceCategoriesController extends Controller
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
            $model = CareerAdviceCategory::query();

             $obj = datatables()->eloquent($model)
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
                        ->setTransformer(new CareerAdviceCategoriesTransformer(new CareerAdviceCategory))
                        ->toJson();

             return $obj;           
        }
        $this->data['active_menue']     = 'manage-career-advice';
        $this->data['active_sub_menue'] = 'career-advice-category';
        return view('career_advice_categories.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['active_menue']     = 'manage-career-advice';
        $this->data['active_sub_menue'] = 'career-advice-category';
        return view('career_advice_categories.create',$this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CareerAdviceCategoriesFormRequest $request)
    {
        try
        {    
            $data = $request->getData();
            
            CareerAdviceCategory::create($data);

            return redirect()->route('career_advice_categories.career_advices.index')
                ->with('success', 'Blog Career Advice Category has been added successfully.');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $adviceCategory = CareerAdviceCategory::findOrFail($id);
        
        $this->data['active_menue']     = 'manage-career-advice';
        $this->data['active_sub_menue'] = 'career-advice-category';
        $this->data['adviceCategory']     = $adviceCategory;
        
        return view('career_advice_categories.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, CareerAdviceCategoriesFormRequest $request)
    {
        try 
        {
            $data = $request->getData();
            $adviceCategory = CareerAdviceCategory::findOrFail($id);
            $adviceCategory->update($data);
            return redirect()->route('career_advice_categories.career_advices.index')
                ->with('success', 'Career Advice Category has been updated successfully.');
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
            $adviceCategory = CareerAdviceCategory::findOrFail($id);
            $adviceCategory->delete();
            return redirect()->route('career_advice_categories.career_advices.index')
                ->with('success', 'Career Advice Category has been deleted successfully.');
        } 
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
