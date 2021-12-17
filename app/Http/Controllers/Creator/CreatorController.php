<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserType;
use Hash;
use Auth;

class CreatorController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->paginate(10);
        return view('Creator.manage_creators', [
            'creators' => $creators,
            'userType' => $userTypeLoggedIn
        ]);
    } 

    public function saveCreator(Request $request) {
        $html = '';
        $slNo = 1;
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $creatorFirstName = $request->input('creatorFirstName');
        $creatorLastName = $request->input('creatorLastName');
        $creatorEmail = $request->input('creatorEmail');
        $creatorPassword = $request->input('creatorPassword');
        $creator = new User;
        $creator->firstname = $creatorFirstName;
        $creator->lastname = $creatorLastName;
        $creator->email = $creatorEmail;
        $creator->password = Hash::make($creatorPassword);
        $creator->role_id = $userType;
        $creator->save();

        $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
        
        foreach($creators as $creator) {
            $html = $html . '<tr id="' . $creator->id .'">';
            $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
            $html = $html . '<td class="align-middle" colspan="2">' . $creator->firstname . ' ' . $creator->lastname . '</td>';
            $html = $html . '<th class="align-middle">' . $creator->email . '</th>';
            $html = $html . '<td class="align-middle">Dummy</td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary view_new_creator_btn" data-bs-toggle="modal" data-bs-target="#view_creator_modal" data-bs-id="' . $creator->id . '">View</button></td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-success add_new_creator_btn" data-bs-toggle="modal" data-bs-target="#edit_creator_modal" data-bs-id="' . $creator->id . '">Edit</button></td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger add_new_creator_btn" data-bs-toggle="modal" data-bs-target="#delete_creator_modal" data-bs-id="' . $creator->id . '">Delete</button></td></tr>';
            $slNo = $slNo + 1;
        }
        
        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'html' => $html]);
    }
    
    public function viewCreator(Request $request) {
        $creatorId = $request->input('user_id');
        if ($creatorId) {
            $creator = User::where('id', $creatorId);
            if ($creator) {
                $data = ['creator_name' => $creator->value('firstname') . ' ' . $creator->value('lastname'), 'creator_email' => $creator->value('email')];
                return response()->json(['status' => 'success', 'message' => '', 'creatorDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function editCreator(Request $request) {
        $userId = $request->input('user_id');
        if ($userId) {
            $creator = User::where('id', $userId);
            if ($creator) {
                $data = ['firstname' => $creator->value('firstname'), 'lastname' => $creator->value('lastname'), 'email' => $creator->value('email'), 'id' => $creator->value('id')];
                return response()->json(['status' => 'success', 'message' => '', 'creatorDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function updateCreator(Request $request) {
        $html = '';
        $slNo = 1;
        $userType = UserType::where('user_role', 'content_creator')->value('id');
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
                $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
                foreach($creators as $creator) {
                    $html = $html . '<tr id="' . $creator->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                    $html = $html . '<td class="align-middle" colspan="2">' . $creator->firstname . ' ' . $creator->lastname . '</td>';
                    $html = $html . '<th class="align-middle">' . $creator->email . '</th>';
                    $html = $html . '<td class="align-middle">Dummy</td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary view_new_creator_btn" data-bs-toggle="modal" data-bs-target="#view_creator_modal" data-bs-id="' . $creator->id . '">View</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-success add_new_creator_btn" data-bs-toggle="modal" data-bs-target="#edit_creator_modal" data-bs-id="' . $creator->id . '">Edit</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger add_new_creator_btn" data-bs-toggle="modal" data-bs-target="#delete_creator_modal" data-bs-id="' . $creator->id . '">Delete</button></td></tr>';
                    $slNo = $slNo + 1;
                }
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function deleteCreator(Request $request) {
        $html = '';
        $slNo = 1;
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $userId = $request->input('user_id');
        if ($userId) {
            $creator = User::find($userId);
            if ($creator) {
                $creator->delete();
                $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
                foreach($creators as $creator) {
                    $html = $html . '<tr id="' . $creator->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                    $html = $html . '<td class="align-middle" colspan="2">' . $creator->firstname . ' ' . $creator->lastname . '</td>';
                    $html = $html . '<th class="align-middle">' . $creator->email . '</th>';
                    $html = $html . '<td class="align-middle">Dummy</td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary view_new_creator_btn" data-bs-toggle="modal" data-bs-target="#view_creator_modal" data-bs-id="' . $creator->id . '">View</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-success add_new_creator_btn" data-bs-toggle="modal" data-bs-target="#edit_creator_modal" data-bs-id="' . $creator->id . '">Edit</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger add_new_creator_btn" data-bs-toggle="modal" data-bs-target="#delete_creator_modal" data-bs-id="' . $creator->id . '">Delete</button></td></tr>';
                    $slNo = $slNo + 1;
                }
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error', 'test' => $courseCategoryId]);
    }
}
