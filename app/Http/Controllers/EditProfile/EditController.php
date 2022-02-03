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
        if (Auth::user()->role_id == 2 || Auth::user()->role_id == 3){
            return redirect('/')->with('message','Profile Updated');
        }else{
            return redirect('/dashboard')->with('message','Profile Updated');
        }
    }

    public function showChangePasswordForm(){ 
        
    if(Auth::check()){
        return view('Auth.changePassword');
    }else{
        return redirect('/403');
    }
       
    }

    public function submitChangePasswordForm(Request $request)
    {
        try{

        
        $user = $request->validate([
            'currentPassword'=>'required',
            'newPassword' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|same:confirm_password',
            'confirm_password' =>'required',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->newPassword);
        $user->save();

        $StudentName = $user->firstname.' '.$user->lastname;
        $StudentEmail = $user->email;
  
        $data= [
           'StudentName' => $StudentName,
        ];
  
        auth()->user()->tokens()->delete();
        Session::flush();
        Auth::logout();

        Mail::to($StudentEmail)
                ->subject('Your password was changed successfully')
                ->send(new PersonalDetailsUpdated($data));

        return redirect('/')->withSuccess('Your password has been changed!');

    } catch (Exception $exception) {
        return redirect('/')->withSuccess('Your password has been changed!');
    }

    }

    public function uploadImage(Request $request)
    {
   
    $request->validate([
        'image' => 'required | mimes:jpeg,jpg,png',
    ]);
   
        if($request->hasFile('image')){
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path().'/storage/images' ;
            $file->move($destinationPath,$filename);
            // $request->image->storeAs('images', $filename, 'public');
           
            $user = Auth::user();
            $user->image = $filename;
            $user->save();
        }

        return redirect()->back();
    }

}
