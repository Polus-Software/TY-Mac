<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\EnrolledCourse;
use App\Models\Filter;
use App\Models\UserType;
use Auth;


class AdminController extends Controller
{
    public function viewAllStudents(){
       
        $students =User::where('role_id', 2)->paginate(10);
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
foreach($students as $student){
    $enrolledCourses = EnrolledCourse::where('user_id', $student->id)->get();
    $enrolledCourseCount = count($enrolledCourses);
//dd($enrolledCourseCount);
}

       
        
        return view('Auth.Admin.AdminDashboard', [
            'students' => $students,
            'enrolledCourseCount' => $enrolledCourseCount,
            'userType' => $userType]);
        
    }

    public function showStudent($id){
        $students =User::findOrFail($id);
        return view ('Auth.Admin.ShowStudent', compact('students'));
        
    }

    public function viewStudent(Request $request) {
        try {
            $studentId = $request->input('student_id');
           
            if ($studentId) {
                $student = User::where('id', $studentId);
                if ($student) {
                    $data = [
                        'id' => $student->value('id'),
                        'firstname' => $student->value('firstname'),
                        'lastname' => $student->value('lastname'),
                        'email' => $student->value('email')
                    ];
                    return response()->json(['status' => 'success', 'message' => '', 'studentDetails' => $data]);
                }
            }
            return response()->json(['status' => 'failed', 'message' => 'Some error']);
        } catch (Exception $exception) {
            return($exception->getMessage());
        }
        
    }

    public function editStudent($id){
        
       $students = User::findOrFail($id);
       return view ('Auth.Admin.EditStudents', compact('students'));

    }

    public function updateStudent(Request $request){   
       
        $updateData = $request->validate([
            'firstname' =>'required',
            'lastname' =>'required',
            'email' => 'required|email|'
        ]);
        $studentId = $request->input('student_id');
   $student = User::findOrFail($studentId);
   
    $student->firstname = $request['firstname'];
    $student->lastname = $request['lastname'];
    $student->email = $request['email'];
    $student->save();
    $html = '';
    return response()->json(['status' => 'success', 'message' => 'Added successfully', 'html' => $html]);
    
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

