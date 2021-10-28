<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
//use app\Models\UserType;

class AdminController extends Controller
{
    public function viewAllStudents(){
       
        $students =User::where('role_id', 2)->orderBy('id', 'asc')->get();
        return view('Auth.Admin.AdminDashboard', compact('students'));
    }

   
}

