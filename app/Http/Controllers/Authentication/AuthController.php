<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignupMail;
use App\Mail\InstructorMailAfterStudentConcern;
use App\Mail\AdminMailAfterSignUp;
use App\Models\User;
use App\Models\UserType;
use App\Models\EnrolledCourse;
use App\Models\AssignedCourse;
use App\Models\LiveSession;
use App\Models\CohortBatch;
use App\Models\Topic;
use App\Models\Notification;
use Session;
use Hash;
use Carbon\Carbon;
use Config;

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
        $user_type = UserType::where('user_role', 'Admin')->value('id');
       
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!-_:$#%]).*$/|confirmed',
            'password_confirmation' =>'required',
            'privacy_policy' =>'accepted'
        ]);

        $admins = User::where('role_id', $user_type)->pluck('email');
    
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $userType;
        $user->timezone = "UTC";
        $user->save();
        
        //$user = Auth::user();
    
        $email= $request->email;
        
    
        $details =[
           'firstname'=> $request->firstname,
           'lastname'=> $request->lastname,
        ];

        // $data=[
        //     'firstname'=> $request->firstname,
        //     'lastname'=> $request->lastname,
        //     'email' => $request->email,
        //     'admin' => $admin
        //  ];
         
        Mail::to($email)->send(new SignupMail($details));
        // Mail::to($admins)->send(new AdminMailAfterSignUp($data));
        
        $notification = new Notification; 
        $notification->user = $user->id;
        $notification->notification = "We are excited to have you learn new skills in a personalized way!At ThinkLit, we make learning fun, interactive, & simple. Get started by exploring our courses";
        $notification->is_read = false;
        $notification->save();
        //return redirect('/')->withSuccess('Successfully registered!');
        //return redirect('/')->with('message', 'Successfully registered!');
        if($request->redirect_page != ''){
            return redirect($request->redirect_page)->with('message', 'Successfully registered!');
        }
        else{
            return redirect('/')->with('message', 'Successfully registered!');
        }
        } catch (Exception $exception) {
            return redirect('/')->with('message', 'Registration failed');
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
    public function loginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        $remember_me = (!empty($request->remember_me)) ? TRUE : FALSE;
        $redirectTo = '';
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            $token = $user->createToken('token')->plainTextToken;
            Auth::login($user, $remember_me);
            if ($userType == Config::get('common.ROLE_NAME_STUDENT')) {
                $redirectTo = '/';
            }
            if ($userType == Config::get('common.ROLE_NAME_INSTRUCTOR')) {
                $redirectTo = 'assigned-courses';
            }
            if ($userType == Config::get('common.ROLE_NAME_ADMIN') || $userType == Config::get('common.ROLE_NAME_CONTENT_CREATOR')) {
                $redirectTo = 'dashboard';
            }
            if($request->redirect != ''){
                $redirectTo = $request->redirect;
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Login success',
                'url' => $redirectTo
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'Invalid username/password',
            'url' => ''
        ]);
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

            $instructor_count = DB::table('users')->where('role_id', '=', 3)-> where('deleted_at' , '=', NULL)->count();
            $registered_course_count = DB::table('courses')->count();
            $students_registered = DB::table('users')->where('role_id', '=', 2)->count();

            $liveSessions = LiveSession::all();
            $current_date = Carbon::now()->format('Y-m-d');
            $backLimitDate =  Carbon::now()->subDays(10)->format('Y-m-d');
           
            foreach($liveSessions as $session) {
               
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
                } elseif ($currentBatchStartDate < $current_date && $currentBatchStartDate > $backLimitDate) {
                    $session_title = $session->session_title;
                    $course = AssignedCourse::where('course_id', $session->course_id);
                    $instructId = $course->value('user_id');
                    $instructor = User::find($instructId)->firstname .' '. User::find($instructId)->lastname;
                    $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();

                    $start_date = Carbon::createFromFormat('Y-m-d',$currentBatchStartDate)->format('M d');
                    $start_time = Carbon::createFromFormat('H:i:s',$batch->value('start_time'))->format('h A');
                    $end_time = Carbon::createFromFormat('H:i:s',$batch->value('end_time'))->format('h A');
                    
                    $date = $start_date . ', ' . $start_time . ' ' .$batch->value('time_zone') . ' - ' . $end_time . ' ' . $batch->value('time_zone');
                    array_push($recentSessionDetails, array(
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
                'upComingSessionDetails' => $upComingSessionDetails,
                'recentSessionDetails' => $recentSessionDetails
            ]);
        }
        
        return redirect('/403');
    }
    
    /**
     * Logout student user
     */
    public function logout() {
        if(auth()->user()) {
            auth()->user()->tokens()->delete();
            Session::flush();
            Auth::logout();
        }
        return Redirect('/');
    }

    public function contactUs(Request $request) {
        try {
            $name = $request->name;
            $phone = $request->phone;
            $message = $request->message;
            $email = $request->email;
            
    
            $details =[
                'title' => 'Hey there, you have a new query!',
                'body' => 'Query from ' . $name . '(' . $email . ')\n\n' . $message,
            ];
            
            //  Mail::to('anjali.krishna@polussoftware.com')->send(new InstructorMailAfterStudentConcern($details));
    
            return redirect('/')->with('message', 'Message sent successfully!');
        } catch (Exception $exception) {
            return redirect('/')->with('message', 'Message sent successfully!');
        }
        
    }

    public function getNotifications(Request $request) {
        $html = "";
        $user = Auth::user();

        if($user) {
            $userId = $user->id;
            $notifications = Notification::where('user', $userId)->get();

            foreach($notifications as $notification) {
                $html = $html . '<div class="col-md-3 col-sm-3 col-xs-3 mt-2"><div style="white-space:nowrap;" class="notify-img"><span><i class="far fa-square"></i> '. $notification->notification .'</span></div></div>';
            }
            return response()->json(['status' => 'success', 'msg' => '', 'html' => $html]);
        }
    }
    
}

