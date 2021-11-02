<?php

namespace App\Http\Controllers\EditProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;
use Session;


class EditController extends Controller
{


    public function edituser()
    { 
        return view('Auth.EditUser');
    } 

    public function profileUpdate(Request $request){
       

        $request->validate([
            'firstname' =>'required',
            'lastname' =>'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id
            
        ]);
        
        $user =Auth::user();
        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->email = $request['email'];
        $user->save();
        return redirect('dashboard')->with('message','Profile Updated');
        
    }

    public function showChangePasswordForm() { 
       return view('Auth.changePassword');
     }

    public function submitChangePasswordForm(Request $request){
        //dd($request->all());
        
        $user = $request->validate([
            'currentPassword'=>'required',
            'newPassword' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|same:confirm_password',
            'confirm_password' =>'required',
        ]);

        $user = Auth::user();

        //dd($user);

        $user->password = Hash::make($request->newPassword);
        $user->save();

        auth()->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return redirect('login')->withSuccess('Your password has been changed!');

      }

}
