<?php

namespace App\Http\Controllers\AdminApp;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingFormRequest;
use Illuminate\Http\Request;
use App\Models\Setting;
use Exception;
use Image;

class SettingController extends Controller
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
        try
        { 
            $settings = Setting::all();
            $data = [];
            foreach ($settings as $setting) 
            {
                $data[$setting->name] = $setting->value;
            }
            $this->data['active_sub_menue'] = 'site-setting';
            $this->data['active_menue'] = 'settings';
            return view('settings.index', $this->data,compact('data'));
        }
        catch (Exception $exception) 
        {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }   
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
    public function store(SettingFormRequest $request)
    {
        try
        {
            $input  = $request->except('_token');

            foreach($input as $inputName => $inputValue)
            {
                Setting::where([
                    'name'  =>  $inputName
                ])->update([
                    'value' =>  $inputValue
                ]);
            }
            return redirect()->route('site_setting.setting.index')
                    ->with('success', 'Record has been updated successfully.');
        }
        catch (Exception $exception) 
        {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }  
                
    }

    public function updateSiteLogo(Request $request)
    {   
        request()->validate([
            'site_logo'  => 'required|mimes:png,jpg,svg,jpeg|dimensions:max_width=221,max_height=47|max:2048',
        ]);

        try
        {
            $input  = $request->except('_token');

            if($request->hasFile('site_logo')) 
            {
                $image = $request->file('site_logo');
                $site_logo = time().'.'.$image->extension();

                $destinationPath = public_path('storage/site_logo');
                $image->move($destinationPath, $site_logo);
            }
           
            foreach($input as $inputName => $inputValue){
                Setting::where([
                    'name'  =>  $inputName
                ])->update([
                    'value' =>  $site_logo
                ]);
            }
            return redirect()->route('site_setting.setting.index')
                    ->with('success', 'Record has been updated successfully.');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
