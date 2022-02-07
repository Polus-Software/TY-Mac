<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\User; 
use Illuminate\Support\Str;
use Carbon\Carbon; 
use Hash;
use App\Mail\ForgotPasswordMail;
use App\Mail\PersonalDetailsUpdatedMail;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
   
   public function showForgetPasswordForm()
   {
         return view('Auth.forgetPassword');
   }

   public function submitForgetPasswordForm(Request $request)
   {
        try{

      $request->validate([
         'email' => 'required|email|exists:users',
      ]);

      $token = Str::random(64);

      DB::table('password_resets')->insert([
         'email' => $request->email, 
         'token' => $token, 
         'created_at' => Carbon::now()
      ]);

      $details =[
         'token' => $token,
      ];
        Mail::to($request->email)->send(new ForgotPasswordMail($details));

        return redirect("/")->with('message', 'We have e-mailed your password reset link!');
      
      }catch(Exception $exception)
         {
            return redirect("/")->with('message', 'We have e-mailed your password reset link!');
         }
   }


   public function showResetPasswordForm($token) 
   { 
      return view('Auth.forgetPasswordLink', ['token' => $token]);
   }


   public function submitResetPasswordForm(Request $request)
   {
        try{

      $request->validate([
         'email' => 'required|email|exists:users',
         'password' => 'required|string|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
         'password_confirmation' => 'required'

      ]);
      
      $updatePassword = DB::table('password_resets')->where([
         'email' => $request->email, 
         'token' => $request->token
      ])->first();
         
      $user = User::where('email' , $request->email);
      $userName = $user->firstname.' '.$user->lastname;

      $data= [
         'userName' => $StudentName,
         'detail' => 'password'
      ];

       

      if(!$updatePassword)
      {
         return back()->withInput()->with('error', 'Invalid token!');
      }
        
      $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

      DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
      Mail::to($request->email)->send(new PersonalDetailsUpdatedMail($data));
         
      return redirect('/')->withSuccess('Your password has been changed!');

     
   } catch (Exception $exception){
      return redirect('/')->withSuccess('Your password has been changed!');
   }
}


public function resetPasswordApi(Request $request) {
   try{
      $request->validate([
         'email' => 'required|email|exists:users',
         'password' => 'required|string|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
         'password_confirmation' => 'required'
      ]);
         
      $user = User::where('email' , $request->email);
    
      $userName = $user->value('firstname').' '.$user->value('lastname');

      $data= [
         'userName' => $userName,
      ];
        
      $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

      DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
      Mail::to($request->email)->send(new PersonalDetailsUpdatedMail($data));
      
      
         
      return response()->json([
         'status' => 'success',
         'message' => 'Your password has been changed!'
     ]);

     
   } catch (Exception $exception){
      return response()->json([
         'status' => 'failed',
         'message' => $exception->getMessage()
     ]);
   }
}

}