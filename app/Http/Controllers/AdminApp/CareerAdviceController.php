<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\CareerAdviceFormRequest;
use App\Transformers\CareerAdviceTransformer;
use Yajra\DataTables\Facades\DataTables;
use App\Models\CareerAdviceCategory;
use App\Models\CareerAdvice;
use Exception;
use Image;

class CareerAdviceController extends Controller
{
    private $data = [];

    public function __construct()
    {   
        $this->data['active_menue'] = 'manage-career-advice';
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
            $model = CareerAdvice::with(['category']);

            if(request()->has('category') && !empty(request('category')))
            {   
                $model = $model->whereHas('category',function($query){
                    $query->where("title","like","%".request()->get('category')."%");
                });
            }
            //->orderBy('id','desc');

            return datatables()->eloquent($model)
                        ->filter(function($query){

                            if(request()->has('title') && !empty(request()->get('title')))
                            {   
                                $query->where("title","like","%".request()->get('title')."%");
                            }

                            if(request()->has('status') && !empty(request('status')))
                            {   
                                $query->where("status",request('status'));
                            }

                        })
                        ->setTransformer(new CareerAdviceTransformer(new CareerAdvice))
                        ->toJson();
        }
        $this->data['active_sub_menue'] = 'career-advices';
        $this->data['active_menue'] = 'manage-career-advice';

        return view('career_advices.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = CareerAdviceCategory::pluck('title','id')->all();
        $this->data['active_sub_menue'] = 'career-advices';
        $this->data['categories']       = $categories;
        
        return view('career_advices.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CareerAdviceFormRequest $request)
    {
        try{
                $data = $request->getData();

                if($request->hasFile('image')) 
                {
                
                $file_extension = $request->file('image')->extension();
                $image = $request->file('image');
                $data['image'] = time().'.'.$image->extension();
                $video_extension = array("mp4", "3gp", "avi", "mov" , "webm" , "ogg" , "flv");
                if(in_array($file_extension, $video_extension))
                  {
                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $path = public_path().'/storage/career_advice_images';
                    $file->move($path, $data['image']);

                    $data['type'] = "video";
                  }
                else
                  {
                    $image = $request->file('image');
                    $data['image'] = time().'.'.$image->extension();
                    
                    $destinationPath = public_path('storage/career_advice_images/thumbnail_image');
                    $img = Image::make($image->path());
                    $img->resize(100, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$data['image']);
                    
                    $destinationPath = public_path('/storage/career_advice_images');
                    $image->move($destinationPath, $data['image']);

                    $data['type'] = "image";
                 
                  }
             
                }

                CareerAdvice::create($data);

                return redirect()->route('career_advices.career_advice.index')
                    ->with('success', 'Career Advice has been added successfully.');
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
        $careerAdvice = CareerAdvice::with('category')->findOrFail($id);

        $this->data['active_sub_menue']   = 'career-advices';
        $this->data['careerAdvice']       = $careerAdvice;
        return view('career_advices.show', $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $careerAdvice = CareerAdvice::findOrFail($id);

        $categories = CareerAdviceCategory::pluck('title','id')->all();

        $this->data['active_sub_menue'] = 'career-advices';
        $this->data['careerAdvice']     = $careerAdvice;
        $this->data['categories']       = $categories;

        return view('career_advices.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, CareerAdviceFormRequest $request)
    {
        try
        { 
            $data = $request->getData();
            
            $careerAdvice = CareerAdvice::findOrFail($id);

           if($request->hasFile('image')) 
            {
                $file_extension = $request->file('image')->extension();
                $image = $request->file('image');
                $data['image'] = time().'.'.$image->extension();

                $video_extension = array("mp4", "3gp", "avi", "mov" , "webm" , "ogg" , "flv");
                if(in_array($file_extension, $video_extension))
                  {
                    $file = $request->file('image');
                    $filename = $file->getClientOriginalName();
                    $path = public_path().'/storage/career_advice_images';
                    $file->move($path, $data['image']);
                    
                    $data['type'] = "video";
                   
                  }
                 else
                  {
                    $image = $request->file('image');
                    $data['image'] = time().'.'.$image->extension();
                    
                    $destinationPath = public_path('storage/career_advice_images/thumbnail_image');
                    $img = Image::make($image->path());
                    $img->resize(100, 100, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save($destinationPath.'/'.$data['image']);
                    
                    $destinationPath = public_path('/storage/career_advice_images');
                    $image->move($destinationPath, $data['image']);

                    $data['type'] = "image";
                 
                  }
            }

            $careerAdvice->update($data);
            return redirect()->route('career_advices.career_advice.index')
                ->with('success', 'Career Advice has been updated successfully.');
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
            $careerAdvice = CareerAdvice::findOrFail($id);
            $careerAdvice->delete();
            return redirect()->route('career_advices.career_advice.index')
                ->with('success', 'Career Advice has been deleted successfully.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }
}
