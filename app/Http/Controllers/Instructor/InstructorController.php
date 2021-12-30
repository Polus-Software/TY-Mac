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
use Carbon\Carbon;

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
            'institute' => 'required',
            'designation' => 'required',
            'twitter_social' => 'required',
            'linkedin_social' => 'required',
            'youtube_social' => 'required',
            'description' => 'required'
        ]);
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $instructor = new User;
        $instructor->firstname = $request->input('firstname');
        $instructor->lastname = $request->input('lastname');
        $instructor->email = $request->input('email');
        $instructor->password = Hash::make($request->input('password'));
        $instructor->institute = $request->input('institute');
        $instructor->designation = $request->input('designation');
        $instructor->twitter_social = $request->input('twitter_social');
        $instructor->linkedin_social = $request->input('linkedin_social');
        $instructor->youtube_social = $request->input('youtube_social');
        $instructor->description = $request->input('description');
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
                    'instructor_image' => $instructor->value('image'),
                    'instructor_institute' => $instructor->value('institute'),
                    'instructor_designation' => $instructor->value('designation'), 
                    'instructor_twitter_social' => $instructor->value('twitter_social'),
                    'instructor_linkedin_social' => $instructor->value('linkedin_social'),
                    'instructor_youtube_social' => $instructor->value('youtube_social'),
                    'instructor_description' => $instructor->value('description'),
                    'instructor_id' => $instructor->value('id'),
                  
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
                    'instructor_institute' => $instructor->value('institute'),
                    'instructor_designation' => $instructor->value('designation'), 
                    'instructor_twitter_social' => $instructor->value('twitter_social'),
                    'instructor_linkedin_social' => $instructor->value('linkedin_social'),
                    'instructor_youtube_social' => $instructor->value('youtube_social'),
                    'instructor_description' => $instructor->value('description'),
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
                'institute' => 'required',
                'designation' => 'required',
                'twitter_social' => 'required',
                'linkedin_social' => 'required',
                'youtube_social' => 'required',
                'description' => 'required'
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
                    $instructor->institute = $request->input('institute');
                    $instructor->designation = $request->input('designation');
                    $instructor->twitter_social = $request->input('twitter_social');
                    $instructor->linkedin_social = $request->input('linkedin_social');
                    $instructor->youtube_social = $request->input('youtube_social');
                    $instructor->description = $request->input('description');
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
                    $html = $html . '<td class="align-middle">' . $instructor->email . '</th>';
                    $html = $html . '<td class="align-middle">Carbon::createFromFormat("Y-m-d H:i:s", $instructor->created_at)->format("F d, Y")</td>';
                    $html = $html . '<td class="text-center align-middle"><a href="" title="View instructor"><i class="fas fa-eye"></i>>View</a>';
                    $html = $html . '<a  href="" title="Edit instructor"><i class="fas fa-pen"></i></a>';
                    $html = $html . '<a data-bs-toggle="modal" data-bs-target="#delete_instructor_modal" data-bs-id="' . $instructor->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
                    $slNo = $slNo + 1;
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
            
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }
        
}
}

