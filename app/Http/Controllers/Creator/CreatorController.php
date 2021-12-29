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

class CreatorController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $user = Auth::user();
        if($user){
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $creators = DB::table('users')
                ->where('role_id', '=', $userType)
                ->paginate(10);
        return view('Creator.manage_creators', [
            'creators' => $creators,
            'userType' => $userTypeLoggedIn
        ]);
        }else{
            return redirect('/403');
        }
    }

    public function addInstructor() {
        $userType = UserType::where('user_role', 'content_creator')->value('id');
        return view('Auth.Admin.creator.create_creator', [
            'userType' => $userType
        ]);

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
        ]);
        $userType = UserType::where('user_role', 'content_creator')->value('id');        
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $email = $request->input('email');
        if ($creatorId) {
            $intructor = User::find($creatorId);
            if ($intructor) {
                $intructor->firstname = $firstName;
                $intructor->lastname = $lastName;
                $intructor->email = $email;
                $intructor->save();
                return redirect()->route('view-creator', ['creator_id' => $creatorId]);
            }
        }
    }

    public function deleteCreator(Request $request) {
        $userId = $request->input('user_id');
        if ($userId) {
            $creator = User::find($userId);die($creator);
            if ($creator) {
                $creator->delete();
                return response()->json(['status' => 'success', 'message' => 'Updated successfully']);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }
}
