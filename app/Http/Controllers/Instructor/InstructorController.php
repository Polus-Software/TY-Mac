<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserType;
use Hash;
use Auth;

class InstructorController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->paginate(10);
        return view('Instructor.manage_instructors', [
            'instructors' => $instructors,
            'userType' => $userTypeLoggedIn
        ]);
    } 

    public function saveInstructor(Request $request) {
        $html = '';
        $slNo = 1;
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $instructorFirstName = $request->input('instructorFirstName');
        $instructorLastName = $request->input('instructorLastName');
        $instructorEmail = $request->input('instructorEmail');
        $instructorPassword = $request->input('instructorPassword');
        $instructor = new User;
        $instructor->firstname = $instructorFirstName;
        $instructor->lastname = $instructorLastName;
        $instructor->email = $instructorEmail;
        $instructor->password = Hash::make($instructorPassword);
        $instructor->role_id = $userType;
        $instructor->save();

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
        
        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'html' => $html]);
    }
    
    public function viewInstructor(Request $request) {
        $instructorId = $request->input('user_id');
        if ($instructorId) {
            $instructor = User::where('id', $instructorId);
            if ($instructor) {
                $data = ['instructor_name' => $instructor->value('firstname') . ' ' . $instructor->value('lastname'), 'instructor_email' => $instructor->value('email')];
                return response()->json(['status' => 'success', 'message' => '', 'instructorDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function editInstructor(Request $request) {
        $userId = $request->input('user_id');
        if ($userId) {
            $instructor = User::where('id', $userId);
            if ($instructor) {
                $data = ['firstname' => $instructor->value('firstname'), 'lastname' => $instructor->value('lastname'), 'email' => $instructor->value('email'), 'id' => $instructor->value('id')];
                return response()->json(['status' => 'success', 'message' => '', 'instructorDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function updateInstructor(Request $request) {
        $html = '';
        $slNo = 1;
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $userId = $request->input('user_id');
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $email = $request->input('email');
        if ($userId) {
            $intructor = User::find($userId);
            if ($intructor) {
                $intructor->firstname = $firstName;
                $intructor->lastname = $lastName;
                $intructor->email = $email;
                $intructor->save();
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
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
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
