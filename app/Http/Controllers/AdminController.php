<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Auth;


class AdminController extends Controller
{
    public function viewAllStudents(){
       
        $students =User::where('role_id', 2)->paginate(10);
        return view('Auth.Admin.AdminDashboard', compact('students'));
    }

    public function showStudent($id){
        $students =User::findOrFail($id);
        return view ('Auth.Admin.ShowStudent', compact('students'));

    }

    public function editStudent($id){
        
       $students = User::findOrFail($id);
       return view ('Auth.Admin.EditStudents', compact('students'));

    }

    public function updateStudent(Request $request, $id){   
       
        $updateData = $request->validate([
            'firstname' =>'required',
            'lastname' =>'required',
            'email' => 'required|email|'
        ]);
  
   $student = User::findOrFail($id);
   
    $student->firstname = $request['firstname'];
    $student->lastname = $request['lastname'];
    $student->email = $request['email'];
    $student->save();
    return redirect()->route('admin.viewall')->with('message','Profile Updated');
    
    }  
   
     
    public function destroyStudent(Request $request){
       
        $studentId = $request->studentId;
        $students = user::find( $studentId);
        $students->delete();
      
        return response()->json(['status' => 'success', 'message' => ' Record Deleted successfully']);
        
        
    }

    
}

