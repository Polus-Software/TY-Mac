<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Session;
use Hash;

class AuthController extends Controller
{

    public function signUp()
    {
        return view('Auth.SignUp');
    }

    
    public function signupProcess(Request $request)
    {  
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12',
            'privacy_policy' =>'accepted'
        ]);

        $data = $request->all();
        $user = $this->createUser($data);

        $user = Auth::user();
     
        return redirect('login')->withSuccess('Successfully registered!');
        
    }

    public function createUser(array $data)
    {
      return User::create([
        'firstname' => $data['firstname'],
        'lastname' => $data['lastname'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }    


    public function login()
    {
        return view('Auth.Login');
    }  

    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            
           $user = Auth::user();
           $token = $user->createToken('token')->plainTextToken;

           return redirect('dashboard')->withSuccess('Logged-in');
       
    
        }
        return redirect('login')->withSuccess('Credentials are wrong.');
    }


    
    public function dashboardView()
    {
        if(Auth::check()){
            return view('Auth.Dashboard');
        }
        return redirect('login')->withSuccess('Access is not permitted');
    }


    public function logout() {

        auth()->user()->tokens()->delete();
        Session::flush();
        return Redirect('login');
    }
    
}

