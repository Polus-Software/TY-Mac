<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\Gmail;
use App\Models\User;
use App\Models\UserType;
use App\Models\EnrolledCourse;
use App\Models\LiveSession;
use App\Models\CohortBatch;
use App\Models\Topic;
use Session;
use Hash;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Render view for signup page
     */
    public function signUp() {
        return view('Auth.SignUp');
    }

    /**
     * Register a student user
     */
    public function signupProcess(Request $request) {

        try {
        $userType = UserType::where('user_role', 'Student')->value('id');
        
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation' =>'required',
            'privacy_policy' =>'accepted'
        ]);
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $userType;
        $user->save();
        
        $user = Auth::user();

        $email= $request->get('email');
        $details =[
            'title' => 'Thank you for registering',
            'body' => 'You have successfully registered'
        ];
        Mail::to($email)->send(new Gmail($details));
        return redirect('/')->withSuccess('Successfully registered!');

        } catch (Exception $exception) {
            return redirect('login')->withSuccess('Successfully registered!');
        }
        
        
    }

    /**
     * Render the login page
     */
    public function login() {
        return view('Auth.Login');
    }  

    /**
     * Student login action
     */
    public function loginProcess(Request $request) {
        $request->validate([
            'email' => 'required',
            'password' => 'required', 
        ]);
        
        $credentials = $request->only('email', 'password');
        $remember_me = ( !empty( $request->remember_me) ) ? TRUE :FALSE ;
        if (Auth::attempt($credentials)) {

           $user = Auth::user();
           $userType =  UserType::find($user->role_id)->user_role;
           $token = $user->createToken('token')->plainTextToken;
           Auth::login($user, $remember_me);
           if($userType == 'student' or $userType == 'instructor'){
            return redirect('/');
        }else{
            return redirect('dashboard');
           }
           return back()->with('Error','Credentials are wrong.');
        }
    }
    
    
    /**
     * Render dashboard after login
     */
    public function dashboardView() {

        $upComingSessionDetails = [];
        $recentSessionDetails = [];
        $user = Auth::user();
       
        if(Auth::check()) {
            $userType =  UserType::find($user->role_id)->user_role;

            $instructor_count = DB::table('users')->where('role_id', '=', 3)->count();
            $registered_course_count = DB::table('courses')->count();
            $students_registered = DB::table('users')->where('role_id', '=', 2)->count();

            $liveSessions = LiveSession::all();
            $current_date = Carbon::now()->format('Y-m-d');
            $date =  Carbon::now()->subDays(10)->format('Y-m-d');
           
            foreach($liveSessions as $session){
               
                $batchId = $session->batch_id;
                $batch = CohortBatch::where('id', $batchId);

                $currentBatchStartDate = $batch->value('start_date');

                if($currentBatchStartDate > $current_date) {
                    $session_title = $session->session_title;
                    $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                    $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();

                    $start_date = Carbon::createFromFormat('Y-m-d',$currentBatchStartDate)->format('M d');
                    $start_time = Carbon::createFromFormat('H:i:s',$batch->value('start_time'))->format('h A');
                    $end_time = Carbon::createFromFormat('H:i:s',$batch->value('end_time'))->format('h A');
                    
                    $date = $start_date . ', ' . $start_time . ' ' .$batch->value('time_zone') . ' - ' . $end_time . ' ' . $batch->value('time_zone');
                    array_push($upComingSessionDetails, array(
                        'session_title'=>  $session_title,
                        'instructor' => $instructor,
                        'enrolledCourses' => $enrolledCourses,
                        'date' => $date
                    ));
                }
                
               

            }


            return view('Auth.Dashboard', [
                'userType' => $userType,
                'instructor_count' => $instructor_count,
                'registered_course_count' => $registered_course_count,
                'students_registered' => $students_registered,
                'session_title' =>$session_title,
                'enrolledCourses'=> $enrolledCourses,
                'upComingSessionDetails' => $upComingSessionDetails,
                'recentSessionDetails' => $recentSessionDetails,
                'instructor' =>   $instructor
            ]);
        }
        
        return redirect('/403');
    }
    
    /**
     * Logout student user
     */
    public function logout() {
        auth()->user()->tokens()->delete();
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
    
}

