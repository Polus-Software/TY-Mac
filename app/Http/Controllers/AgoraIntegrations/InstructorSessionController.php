<?php

namespace App\Http\Controllers\AgoraIntegrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;

class InstructorSessionController extends Controller
{
    public function index(Request $request) {
        return view('Agora.instructor_session_view');
    }

    public function hostSession(Request $request) {
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
        if(Auth::check()) {
            return view('Agora.SessionScreen.session_screen', [
                'userType' => $userType
            ]);
        }
        return redirect('login')->withSuccess('Access is not permitted');
    }
}
