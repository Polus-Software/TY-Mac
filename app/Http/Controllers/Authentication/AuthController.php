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
use App\Mail\MailAfterContactUsSubmission;
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
use App\Models\CustomTimezone;
use DateTime;
use DateTimeZone;

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
        try{
            $userType = UserType::where('user_role', 'Student')->value('id');
            $user_type = UserType::where('user_role', 'Admin')->value('id');
            
            $request->validate([
                'firstname' => 'required',
                'lastname' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!-_:$#%]).*$/|confirmed',
                'password_confirmation' =>'required',
                'privacy_policy' =>'accepted',
                'cohortbatch_timezone' => 'required'
            ]);

            
            $admins = User::where('role_id', $user_type)->get();
            $user = new User;
            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role_id = $userType;
            $user->timezone = $request->cohortbatch_timezone;
            $user->save();

            $email= $request->email;
            $details =[
            'firstname'=> $request->firstname,
            'lastname'=> $request->lastname,
            ];

            Mail::mailer('infosmtp')->to($email)->send(new SignupMail($details));
            foreach($admins as $admin) {
                $data=[
                    'firstname'=> $request->firstname,
                    'lastname'=> $request->lastname,
                    'email' => $email,
                    'adminEmail' => $admin->email,
                    'adminFirstName' => $admin->firstname,
                    'adminLastName' => $admin->lastname
                ];
                Mail::to($admin->email)->send(new AdminMailAfterSignUp($data));
                $notification = new Notification; 
                $notification->user = $admin->id;
                $notification->notification = "Hello  ".$admin->firstname." ". $admin->lastname." , You have got a new student registration on ThinkLit. Details: Student Name : ".$request->firstname." ".$request->lastname .",". "Email Id : ".$email;
                $notification->is_read = false;
                $notification->save();
            }
            
            $notification = new Notification; 
            $notification->user = $user->id;
            $notification->notification = "We are excited to have you learn new skills in a personalized way!At ThinkLit, we make learning fun, interactive, & simple. Get started by exploring our courses";
            $notification->is_read = false;
            $notification->save();
            if($request->redirect_page != '') {

            } else if($request->redirect_page != ''){
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
            if($request->redirect == 'session') {
                $redirectTo = url('/') . '/session-view/' . $request->session_id;
            } else if($request->redirect != ''){
                $redirectTo = $request->redirect;
            }  
            if ($userType == Config::get('common.ROLE_NAME_INSTRUCTOR')) {
                $redirectTo = '/assigned-courses';
            }
            if ($userType == Config::get('common.ROLE_NAME_ADMIN') || $userType == Config::get('common.ROLE_NAME_CONTENT_CREATOR')) {
                $redirectTo = '/dashboard';
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
            //$students_registered = User::where('role_id', 2)->count();
            $liveSessions = LiveSession::all();
             
			$backLimitDate =  Carbon::now()->subDays(10)->format('Y-m-d');
			$total_live_hours = 0;
            foreach($liveSessions as $session) {
                $batchId = $session->batch_id;
                $batch = CohortBatch::where('id', $batchId);
                $current_date = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'), 'UTC')->setTimezone($batch->value('time_zone'))->format('Y-m-d');
                //Timezone change 
                $offset = CustomTimezone::where('name', $batch->value('time_zone'))->value('offset');
                        
                $offsetHours = intval($offset[1] . $offset[2]);
                $offsetMinutes = intval($offset[4] . $offset[5]);
                    
                if($offset[0] == "+") {
                    $sTime = strtotime($session->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                    $eTime = strtotime($session->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                } else {
                    $sTime = strtotime($session->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                    $eTime = strtotime($session->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                }
                    
                $start_time = date("h:i A", $sTime);
                $end_time = date("h:i A", $eTime);
                                    
                $currentBatchStartDate = $session->start_date;
				if($currentBatchStartDate < $current_date){
					$total_live_hours = $total_live_hours+$batch->value('duration');
				}
                if ($currentBatchStartDate < $current_date && $currentBatchStartDate > $backLimitDate) {
                        $session_title = $session->session_title;
                        $course = AssignedCourse::where('course_id', $session->course_id);
                        $instructId = $course->value('user_id');
                        $instructor = User::find($instructId)->firstname .' '. User::find($instructId)->lastname;
                        $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
    
                        $start_date = Carbon::createFromFormat('Y-m-d', $currentBatchStartDate)->format('m/d/Y');
                        $date = new DateTime("now");
                        $time_zone = $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T') . ")": $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T'); 
                        $date = $start_date . ', ' . $start_time . ' ' . $time_zone . ' - ' . $end_time . ' ' . $time_zone;
                        array_push($recentSessionDetails, array (
                            'session_title'=>  $session_title,
                            'instructor' => $instructor,
                            'enrolledCourses' => $enrolledCourses,
                            'date' => $date
                        ));
                    
                } elseif($currentBatchStartDate > $current_date) {
                    $session_title = $session->session_title;
                    $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                  
                    $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
                    $start_date = Carbon::createFromFormat('Y-m-d', $currentBatchStartDate)->format('m/d/Y');
                    $date = new DateTime("now");
                    $time_zone = $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T') . ")": $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T'); 
                    $date = $start_date . ', ' . $start_time . ' ' . $time_zone . ' - ' . $end_time . ' ' . $time_zone;
                    array_push($upComingSessionDetails, array(
                        'session_title'=>  $session_title,
                        'instructor' => $instructor,
                        'enrolledCourses' => $enrolledCourses,
                        'date' => $date
                    ));
                } elseif($currentBatchStartDate == $current_date) {
                    if($session->end_time < Carbon::now()->format('H:i:s')) {
                        $session_title = $session->session_title;
                        $course = AssignedCourse::where('course_id', $session->course_id);
                        $instructId = $course->value('user_id');
                        $instructor = User::find($instructId)->firstname .' '. User::find($instructId)->lastname;
                        $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
    
                        $start_date = Carbon::createFromFormat('Y-m-d', $currentBatchStartDate)->format('m/d/Y');
                        $date = new DateTime("now");
                        $time_zone = $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T') . ")": $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T'); 
                        $date = $start_date . ', ' . $start_time . ' ' . $time_zone . ' - ' . $end_time . ' ' . $time_zone;
                        array_push($recentSessionDetails, array (
                            'session_title'=>  $session_title,
                            'instructor' => $instructor,
                            'enrolledCourses' => $enrolledCourses,
                            'date' => $date
                        ));
                    } else {
                        $session_title = $session->session_title;
                    $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                  
                    $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
                    $start_date = Carbon::createFromFormat('Y-m-d', $currentBatchStartDate)->format('m/d/Y');
                    $date = new DateTime("now");
                    $time_zone = $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T') . ")": $date->setTimeZone(new DateTimeZone($batch->value('time_zone')))->format('T'); 
                    $date = $start_date . ', ' . $start_time . ' ' . $time_zone . ' - ' . $end_time . ' ' . $time_zone;
                    array_push($upComingSessionDetails, array(
                        'session_title'=>  $session_title,
                        'instructor' => $instructor,
                        'enrolledCourses' => $enrolledCourses,
                        'date' => $date
                    ));
                    }
                }
            }
            return view('Auth.Dashboard', [
                'userType' => $userType,
                'instructor_count' => $instructor_count,
                'registered_course_count' => $registered_course_count,
                'students_registered' => $students_registered,
				'total_live_hours' => $total_live_hours,
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
            
            $user_type = UserType::where('user_role', 'Admin')->value('id');
            $admins = User::where('role_id', $user_type)->get();
          
            
            foreach($admins as $admin) {
                $details=[
                    'name'=> $name,
                    'message' => $message,
                    'adminEmail' => $admin->email,
                    'adminFirstName' => $admin->firstname,
                    'adminLastName' => $admin->lastname,
                    'email' => $email
                 ];
                Mail::mailer('smtp')->to($admin->email)->send(new MailAfterContactUsSubmission($details));
                $notification = new Notification; 
                $notification->user = $admin->id;
                $notification->notification = "Hi ".$admin->firstname." ". $admin->lastname." ,You have got a new query from the student ".$name;
                $notification->is_read = false;
                $notification->save();
            }
            
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
    
    public function readNotifications(Request $request) {
        $user = Auth::user();

        if($user) {
            $userId = $user->id;
            $notifications = Notification::where('user', $userId)->update(['is_read' => true]);

            $newNotifications = Notification::where('user', $userId)->where('is_read', false)->get();
            $notificationCount = count($newNotifications);
        }

        return response()->json(['status' => 'success', 'count' => $notificationCount]);
    }
}

