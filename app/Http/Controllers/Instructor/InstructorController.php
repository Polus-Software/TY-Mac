<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserType;
use Hash;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InstructorController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $user = Auth::user();

        if($user){

        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->paginate(10);
        return view('Instructor.manage_instructors', [
            'instructors' => $instructors,
            'userType' => $userTypeLoggedIn
        ]);
        }else{
            return redirect('/403');
        }
    }
    public function addInstructor() {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        return view('Auth.Admin.instructor.create_instructor', [
            'userType' => $userType
        ]);

    }

    public function saveInstructor(Request $request) {
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $instructor = new User;
        $instructor->firstname = $request->input('firstname');
        $instructor->lastname = $request->input('lastname');
        $instructor->email = $request->input('email');
        $instructor->password = Hash::make($request->input('password'));
        $instructor->role_id = $userType;
        $instructor->save();
        return redirect()->route('manage-instructors');
    }
        
    public function viewInstructor(Request $request) {
        $instructorId = $request->input('instructor_id');
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
        if ($instructorId) {
            $instructor = User::where('id', $instructorId);
            $assigned_courses = DB::table('assigned_courses')
                    ->join('courses', 'assigned_courses.course_id', '=', 'courses.id')
                    ->where('assigned_courses.user_id', $instructorId)
                    ->get();
            if ($instructor) {
                $data = [
                    'firstname' => $instructor->value('firstname') ,
                    'lastname' => $instructor->value('lastname'),
                    'instructor_email' => $instructor->value('email'),
                    'instructor_id' => $instructor->value('id')
                ];
                return view('Auth.Admin.instructor.view_instructor', [
                    'instructorDetails' => $data,
                    'userType' => $userType,
                    'assigned_courses' => $assigned_courses
                ]);
            }
            
        }
    }    

    public function editInstructor(Request $request) {
        try{
            $instructor_id = $request->input('instructor_id');
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($instructor_id) {
                $instructor = User::where('id', $instructor_id);
                $assigned_courses = DB::table('assigned_courses')
                ->join('courses', 'assigned_courses.course_id', '=', 'courses.id')
                ->where('assigned_courses.user_id', $instructor_id)
                ->get();
                if ($instructor) {
                    $data = [
                    'firstname' => $instructor->value('firstname') ,
                    'lastname' => $instructor->value('lastname'),
                    'instructor_email' => $instructor->value('email'),
                    'instructor_id' => $instructor->value('id')
                    ];
                    return view('Auth.Admin.instructor.create_instructor', [
                    'instructorDetails' => $data,
                    'userType' => $userType,
                    'assigned_courses' => $assigned_courses
                    ]);
                }
            }
        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }

    public function updateInstructor(Request $request) {
        try {
            $instructor_id = $request->input('instructor_id');
            $validatedData = $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => ['required', Rule::unique('users')->ignore($instructor_id)],
            ]);
            
            $firstName = $request->input('firstname');
            $lastName = $request->input('lastname');
            $email = $request->input('email');
            if ($instructor_id) {
                $instructor = User::findOrFail($instructor_id);
                if ($instructor) {
                    $instructor->firstname = $firstName;
                    $instructor->lastname = $lastName;
                    $instructor->email = $email;
                    $instructor->save();
                    return redirect()->route('view-instructor', ['instructor_id' => $instructor_id]);
                }
            }
        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }

    public function deleteInstructor(Request $request) {
        $html = '';
        $slNo = 1;
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $userId = $request->input('user_id');
        if ($userId) {
            $instructor = User::find($userId);
            if ($instructor) {
                $instructor->delete();
                $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
                foreach($instructors as $instructor) {
                    $html = $html . '<tr id="' . $instructor->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                    $html = $html . '<td class="align-middle" colspan="2">' . $instructor->firstname . ' ' . $instructor->lastname . '</td>';
                    $html = $html . '<th class="align-middle">' . $instructor->email . '</th>';
                    $html = $html . '<td class="align-middle">Dummy</td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary view_new_instructor_btn" data-bs-toggle="modal" data-bs-target="#view_instructor_modal" data-bs-id="' . $instructor->id . '">View</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-success add_new_instructor_btn" data-bs-toggle="modal" data-bs-target="#edit_instructor_modal" data-bs-id="' . $instructor->id . '">Edit</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger add_new_instructor_btn" data-bs-toggle="modal" data-bs-target="#delete_instructor_modal" data-bs-id="' . $instructor->id . '">Delete</button></td></tr>';
                    $slNo = $slNo + 1;
                }
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error', 'test' => $courseCategoryId]);
    }
}
