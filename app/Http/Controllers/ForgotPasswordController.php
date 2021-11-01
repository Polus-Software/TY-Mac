<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 

class ForgotPasswordController extends Controller
{

    public function showForgetPasswordForm()
      {
         return view('Auth.forgetPassword');
      }
    
}
