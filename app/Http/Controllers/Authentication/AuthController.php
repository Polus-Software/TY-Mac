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
use App\Models\AssignedCourse;
use App\Models\LiveSession;
use App\Models\CohortBatch;
use App\Models\Topic;
use App\Models\Notification;
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
            'password' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!-_:$#%]).*$/|confirmed',
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

        $email= $request->get('email');
        $details =[
            'title' => 'Thank you for registering',
            'body' => 'You have successfully registered'
        ];
        Mail::to($email)->send(new Gmail($details));
        
        $notification = new Notification; 
        $notification->user = $user->id;
        $notification->notification = "We are excited to have you learn new skills in a personalized way!At ThinkLit, we make learning fun, interactive, & simple. Get started by exploring our courses";
        $notification->is_read = false;
        $notification->save();
        return redirect('/')->withSuccess('Successfully registered!');

        } catch (Exception $exception) {
            return redirect('/')->withSuccess('Successfully registered!');
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
        } else {
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
                    $course = AssignedCourse::where('course_id', $session->course_id);
                    $instructId = $course->value('user_id');
                    $instructor = User::find($instructId)->firstname .' '. User::find($instructId)->lastname;
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
                'body' => 'Query from ' . $name . '(' . $email . ')\n\n' . $message
            ];
    
            Mail::to('support@thinklit.com')->send(new Gmail($details));
    
            return redirect('/')->withSuccess('Sent successfully!');
        } catch (Exception $exception) {
            return redirect('/');
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

