<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerFormRequest;
use App\Transformers\BannerTransformer;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Banner;
use Exception;

class BannerController extends Controller
{
    private $data = [];

    public function __construct()
    {   
        $this->data['active_menue'] = 'content-management';
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
            $model = Banner::query();

            return datatables()->eloquent($model)
                        ->filter(function($query){
                             if(request()->has('status') && !empty(request('status')))
                                {       
                                    $query->where("status",request('status'));
                                }
                        })    
                        ->setTransformer(new BannerTransformer(new Banner))
                        ->toJson();
        }

        $this->data['active_sub_menue'] = 'manage-banners';
        $this->data['active_menue'] = 'content-management';
        return view('banners.index',$this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        
        $this->data['active_sub_menue'] = 'manage-banners';
        $this->data['banner']       = $banner;
        return view('banners.show',  $this->data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner = Banner::findOrFail($id);

        $this->data['active_sub_menue']   = 'manage-banners';
        $this->data['banner']             = $banner;
        return view('banners.edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, BannerFormRequest $request)
    {
        try
        { 
            $data = $request->getData();
            
            $banner = Banner::findOrFail($id);

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
                    $path = public_path().'/storage/banner_images';
                    $file->move($path, $data['image']);
                    
                    $data['type'] = "video";
                   
                  }
                 else
                  {
                    $image = $request->file('image');
                    $data['image'] = time().'.'.$image->extension();
                    
                    $destinationPath = public_path('storage/banner_images');
                    $image->move($destinationPath, $data['image']);

                    $data['type'] = "image";
                 
                  }
            }

            $banner->update($data);
            return redirect()->route('manage_banners.manage_banner.index')
                ->with('success', 'Banner has been updated successfully.');
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
        //
    }
}
