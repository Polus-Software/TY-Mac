<?php

namespace App\Http\Controllers\EditProfile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\UserType;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Hash;
use Session;
use App\Mail\PersonalDetailsUpdatedMail;
use Redirect;


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
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'timezone' => 'required'
        ]);
        
        $detail = "";
        $flag = 0;
        $user =Auth::user();
        $oldFirstname = $user->firstname;
        $oldLastname = $user->lastname;
        $oldemail = $user->email;
        $oldTimezone = $user->timezone;
        $user->firstname = $request['firstname'];
        $user->lastname = $request['lastname'];
        $user->email = $request['email'];
        $user->timezone = $request['timezone'];
        $user->save();

        if($oldFirstname != $user->firstname) {
            $flag++;
            $detail = "first name";
        }
        if($oldLastname != $user->lastname) {
            $flag++;
            $detail = "last name";
        }
        if($oldemail != $user->email) {
            $flag++;
            $detail = "email";
        }
        if($oldTimezone != $user->timezone) {
            $flag++;
            $detail = "timezone";
        }
        if($flag > 1) {
            $detail = "personal detail";
        }

        $data = [
            'studentName' => $request['firstname'] . ' ' . $request['lastname'],
            'detail' => $detail
         ];

         Mail::mailer('smtp')->to($user->email)->send(new PersonalDetailsUpdatedMail($data));

         $notification = new Notification; 
         $notification->user = $user->id;
         $notification->notification = "Your ". $detail ." was changed successfully";
         $notification->is_read = false;
         $notification->save();
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
            'newPassword' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!-_:$#%]).*$/|same:confirm_password',
            'confirm_password' =>'required',
        ]);
        $user = Auth::user();
        if(!Hash::check($request->currentPassword, Auth::user()->password)) {
            return Redirect::back()->with('message','Current password is wrong!');
        }
        
        $user->password = Hash::make($request->newPassword);
        $user->save();

        $userName = $user->firstname.' '.$user->lastname;
        $StudentEmail = $user->email;
  
        $data= [
           'studentName' => $userName,
           'detail' => 'password'
        ];
  
        auth()->user()->tokens()->delete();
        Session::flush();
        Auth::logout();

        Mail::mailer('infosmtp')->to($StudentEmail)->send(new PersonalDetailsUpdatedMail($data));

         $notification = new Notification; 
         $notification->user = $user->id;
         $notification->notification = "You've successfully changed your ThinkLit password.";
         $notification->is_read = false;
         $notification->save();

         return redirect('/')->with('message', 'Your password has been changed! Please login again.');

    } catch (Exception $exception) {
        return redirect('/')->with('message', 'Your password has been changed! Please login again.');
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
