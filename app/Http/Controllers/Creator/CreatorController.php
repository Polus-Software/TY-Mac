<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserType;
use Hash;
use Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class CreatorController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $user = Auth::user();
        if($user){
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->where('deleted_at', '=', NULL)
                ->paginate(10);
        return view('Creator.manage_creators', [
            'creators' => $creators,
            'userType' => $userTypeLoggedIn
        ]);
        }else{
            return redirect('/403');
        }
    }

    public function addCreator() {
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $user = Auth::user();
        if($user){
            $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
            return view('Auth.Admin.creator.create_creator', [
                'userType' => $userTypeLoggedIn
            ]);
        }
        else{
            return redirect('/403');
        }

    }

    public function saveCreator(Request $request) {
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $creator = new User;
        $creator->firstname = $request->input('firstname');
        $creator->lastname = $request->input('lastname');
        $creator->email = $request->input('email');
        $creator->password = Hash::make($request->input('password'));
        $creator->role_id = $userType;
        $creator->save();
        return redirect()->route('manage-creators');
    }

    public function viewCreator(Request $request) {
        $creatorId = $request->input('creator_id');
        if ($creatorId) {
            $creator = User::where('id', $creatorId);
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($creator) {
                $data = [
                    'creator_id' => $creator->value('id') ,
                    'firstname' => $creator->value('firstname') ,
                    'lastname' => $creator->value('lastname'),
                    'email' => $creator->value('email')];
                return view('Auth.Admin.creator.view_creator', [
                    'creatorDetails' => $data,
                    'userType' => $userType
                ]);
            }
        }
    }

    public function editCreator(Request $request) {
        $creatorId = $request->input('creator_id');
        if ($creatorId) {
            $creator = User::where('id', $creatorId);
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($creator) {
                $data = [
                    'creator_id' => $creator->value('id') ,
                    'firstname' => $creator->value('firstname') ,
                    'lastname' => $creator->value('lastname'),
                    'email' => $creator->value('email')];
                return view('Auth.Admin.creator.create_creator', [
                    'creatorDetails' => $data,
                    'userType' => $userType
                ]);
            }
        }
    }

    public function updateCreator(Request $request) {
        $creatorId = $request->input('creator_id');
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($creatorId)],
            //'password' => 'required'
        ]);
        $userType = UserType::where('user_role', 'content_creator')->value('id');        
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $email = $request->input('email');
        
            if ($creatorId) {
            $creator = User::find($creatorId);
            if ($creator) {
                $creator->firstname = $firstName;
                $creator->lastname = $lastName;
                $creator->email = $email;
                if($request->input('password') != ''){
                    $creator->password = Hash::make($request->input('password'));
                }
                $creator->save();
                return redirect()->route('view-creator', ['creator_id' => $creatorId]);
            }
        }
    }

    public function deleteCreator(Request $request) {
        $html = '';
        $slNo = 1;
        $userId = $request->input('user_id');
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        if ($userId) {
            $creator = User::find($userId);
            if ($creator) {
                $creator->delete();

                $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->where('deleted_at', '=', NULL)
                ->get();

                foreach($creators as $creator) {
                    $html = $html . '<tr id="' . $creator->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                    $html = $html . '<td class="align-middle" colspan="2">' . $creator->firstname . ' ' . $creator->lastname . '</td>';
                    $html = $html . '<td class="align-middle">' . $creator->email . '</th>';
                    $html = $html . '<td class="align-middle">' . Carbon::createFromFormat("Y-m-d H:i:s", $creator->created_at)->format("F d, Y") . '</td>';
                    $html = $html . '<td class="text-center align-middle"><a href="" title="View instructor"><i class="fas fa-eye"></i></a>';
                    $html = $html . '<a  href="" title="Edit instructor"><i class="fas fa-pen"></i></a>';
                    $html = $html . '<a data-bs-toggle="modal" data-bs-target="#delete_instructor_modal" data-bs-id="' . $creator->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
                    $slNo = $slNo + 1;
                }
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error', 'html' => '']);
    }
}
