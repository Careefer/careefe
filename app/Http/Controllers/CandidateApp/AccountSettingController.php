<?php

namespace App\Http\Controllers\CandidateApp;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Candidate;


class AccountSettingController extends Controller
{
    
     /**
     * Show the application's account setting form.
     *
     * @return \Illuminate\Http\Response
     */
    public function account_setting()
    {
        return view('candidateApp.account_setting');
    }

    /**
     * Show the application's account change password form.
     *
     * @return \Illuminate\Http\Response
     */
    public function change_password(Request $request)
    {
        try
        {

            $request->validate([
                'existing_password'     => 'required',
                'new_password'          => 'required|min:6|max:30|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                'confirm_password'      => 'required|same:new_password'
            ],[
            'new_password.regex' =>  'Password must be between 6 to 30 character having one capital & small letters and one number',
            ]);

            $password = auth()->user()->password;

            $input           = $request->all();
            $current_pass    = $input['existing_password'];
            $new_pass        = bcrypt($input['new_password']); 
            $confirm_pass    = $input['confirm_password'];

            if (!(Hash::check($current_pass, $password))) {
                return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
            }

            if((Hash::check($input['new_password'], $password)) == true){
                return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
            }

            //Change Password
            $user = Auth::user();
            $user->password = $new_pass;
            $user->save(); 

            return redirect()->back()->with("success","Password has been changed Successfully.");
            
        }
        catch(Exception $e)
        {
            dd($e);
        }
    }

}
