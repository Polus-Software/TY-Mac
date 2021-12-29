<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;
use App\Models\User;
use App\Models\UserType;
use Session;
use Hash;

class AuthController extends Controller
{
    /**
     * Render view for signup page
     */
    public function signUp() {
        return view('Auth.SignUp');
    }

    /**
     * Register a student user
     */
    public function signupProcess(Request $request) {

        try {
        $userType = UserType::where('user_role', 'Student')->value('id');
        
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation' =>'required',
            'privacy_policy' =>'accepted'
        ]);
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $userType;
        $user->save();
        
        $user = Auth::user();

        $email= $request->get('email');
        $details =[
            'title' => 'Thank you for registering',
            'body' => 'You have successfully registered'
        ];
        Mail::to($email)->send(new Gmail($details));
        return redirect('login')->withSuccess('Successfully registered!');

        } catch (Exception $exception) {
            return redirect('login')->withSuccess('Successfully registered!');
        }
        
        
    }

    /**
     * Render the login page
     */
    public function login() {
        return view('Auth.Login');
    }  

    /**
     * Student login action
     */
    public function loginProcess(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required', 
        ]);
        
        $credentials = $request->only('email', 'password');
        $remember_me = ( !empty( $request->remember_me) ) ? TRUE :FALSE ;
        if (Auth::attempt($credentials)) {

           $user = Auth::user();
           $userType =  UserType::find($user->role_id)->user_role;
           $token = $user->createToken('token')->plainTextToken;
           Auth::login($user, $remember_me);
           if($userType == 'student' or $userType == 'instructor'){
               return redirect('/');
           }else{
            return redirect('dashboard');
           }
           
        }
        return redirect('login')->withErrors('Credentials are wrong.');
    }
    
    /**
     * Render dashboard after login
     */
    public function dashboardView() {
        $user = Auth::user();
       
        if(Auth::check()) {
            $userType =  UserType::find($user->role_id)->user_role;
            return view('Auth.Dashboard', [
                'userType' => $userType
            ]);
        }
        //return redirect('login')->withErrors('Access is not permitted');
        return redirect('/403');
    }
    
    /**
     * Logout student user
     */
    public function logout() {
        auth()->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
    
}

