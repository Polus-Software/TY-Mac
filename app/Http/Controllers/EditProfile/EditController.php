<?php

namespace App\Http\Controllers\EditProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Auth;


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
}
