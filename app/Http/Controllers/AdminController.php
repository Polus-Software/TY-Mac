<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Filter;
use App\Models\UserType;
use Auth;


class AdminController extends Controller
{
    public function viewAllStudents(){
       
        $students =User::where('role_id', 2)->paginate(10);
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
        return view('Auth.Admin.AdminDashboard', [
            'students' => $students,
            'userType' => $userType]);
        
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

    public function adminSettings(Request $request) {
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
        $filters = Filter::all();
        return view('Auth.Admin.AdminSettings', [
            'userType' => $userType,
            'filters' => $filters ]);
    }

    public function changeFilterStatus(Request $request) {
        $filterId = $request->filter_id;
        $isEnabled = $request->is_enabled;

        $filter = Filter::find($filterId);
        if($isEnabled == "true") {
          $filter->is_enabled = true;
        } else {
          $filter->is_enabled = false;
        }
        $filter->save();
        return response()->json(['status' => 'success', 'message' => ' Changed status successfully']);
    }

    
}

