<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

use App\Models\UserType;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Filter;
use App\Models\Notification;
use App\Models\LiveSession;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Models\EnrolledCourse;
use App\Models\AssignedCourse;
use App\Models\Assignment;
use App\Models\TopicAssignment;
use App\Models\GeneralCourseFeedback;
use App\Models\AchievementBadge;
use App\Models\StudentAchievement;
use App\Models\AttendanceTracker;

use App\Mail\SignupMail;
use App\Mail\AdminMailAfterSignUp;
use App\Mail\PersonalDetailsUpdatedMail;
use App\Mail\StudentMailAfterEnrolling;
use App\Mail\InstructorMailAfterEnrolling;
use App\Mail\InstructorMailAfterFeedback;
use App\Mail\MailAfterAssignmentSubmission;

use Carbon\Carbon;
use Config;
use Hash;
use Exception;
use Session;

/**
 * API actions
 */
class ApiController extends Controller
{
    /**
     *  
     */

    public function loginProcessApi(Request $request)
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
                'url' => $redirectTo,
                'token' => $token
            ]);
        }
        return response()->json([
            'status' => 'fail',
            'message' => 'Invalid username/password',
            'url' => ''
        ]);
    }


    public function signupProcessApi(Request $request) {
   

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
        
        $admins = User::where('role_id', $user_type)->get();
        $user = new User;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $userType;
        $user->timezone = "UTC";
        $user->save();
    
        $email= $request->email;
        
   
        $details =[
           'firstname'=> $request->firstname,
           'lastname'=> $request->lastname,
        ];

        
        Mail::to($email)->send(new SignupMail($details));
        foreach($admins as $admin) {
            $data=[
                'firstname'=> $request->firstname,
                'lastname'=> $request->lastname,
                'email' => $email,
                'adminEmail' => $admin->email,
                'adminFirstname' => $admin->firstname,
                'adminLastName' => $admin->lastname
             ];
            Mail::to($admin->email)->send(new AdminMailAfterSignUp($data));
        }
        
        
        $notification = new Notification; 
        $notification->user = $user->id;
        $notification->notification = "We are excited to have you learn new skills in a personalized way!At ThinkLit, we make learning fun, interactive, & simple. Get started by exploring our courses";
        $notification->is_read = false;
        $notification->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Signup success'
        ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'message' => $exception->getMessage()
            ]);
        }
        
        
    }

    public function logoutApi() {
        try {
            if(auth()->user()) {
                auth()->user()->tokens()->delete();
                Session::flush();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'logout successful'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failed',
                'message' => $exception->getMessage()
            ]);
        }
        
    }

    public function getNotificationsApi(Request $request) {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $notifications = Notification::where('user', $userId)->get();
            return response()->json(['status' => 'success', 'user_id' => $userId, 'notifications' => $notifications ]);
        } catch(Exception $exception) {
            return response()->json(['status' => 'error', 'message' => $exception->getMessage() ]);
        }
    }


    public function contactUsApi(Request $request) {
        try {
            $name = $request->name;
            $phone = $request->phone;
            $message = $request->message;
            $email = $request->email;
            
    
            $details =[
                'title' => 'Hey there, you have a new query!',
                'body' => 'Query from ' . $name . '(' . $email . ')\n\n' . $message,
            ];
            
            return response()->json([
                'status' => 'success',
                'message' => 'Submitted succesfully'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
        
    }

    public function resetPasswordApi(Request $request) {
        try{
           $request->validate([
              'email' => 'required|email|exists:users',
              'password' => 'required|string|min:5|max:12|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
              'password_confirmation' => 'required'
           ]);
              
           $user = User::where('email' , $request->email);
         
           $userName = $user->value('firstname').' '.$user->value('lastname');
     
           $data= [
              'userName' => $userName,
           ];
             
           $user = User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);
     
           DB::table('password_resets')->where(['email'=> $request->email])->delete();
       
           Mail::to($request->email)->send(new PersonalDetailsUpdatedMail($data));
           
           
              
           return response()->json([
              'status' => 'success',
              'message' => 'Your password has been changed!'
          ]);
     
          
        } catch (Exception $exception){
           return response()->json([
              'status' => 'failed',
              'message' => $exception->getMessage()
          ]);
        }
     }

     public function profileUpdateApi(Request $request){
       
        try {
            $request->validate([
                'firstname' =>'required',
                'lastname' =>'required',
                'email' => 'required|email|unique:users,email,'.Auth::user()->id,
                'timezone' => 'required'
            ]);
            
            $user = Auth::user();
            $user->firstname = $request['firstname'];
            $user->lastname = $request['lastname'];
            $user->email = $request['email'];
            $user->timezone = $request['timezone'];
            $user->save();
            
            return response()->json([
                'status' => 'success',
                'message' => 'update successful',
                'user_role' => Auth::user()->role_id
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'success',
                'message' => $exception->getMessage()
            ]);
        }
        
        
    }

    public function uploadImageApi(Request $request)
    {
    try {
        $request->validate([
            'image' => 'required | mimes:jpeg,jpg,png',
        ]);
   
        if($request->hasFile('image')){
            $file = $request->image;
            $filename = $file->getClientOriginalName();
            $destinationPath = public_path().'/storage/images' ;
            $file->move($destinationPath,$filename);
           
            $user = Auth::user();
            $user->image = $filename;
            $user->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Successfully changesd avatar']);
    } catch (Exception $exception) {
        return response()->json(['status' => 'error', 'message' => $exception->getMessage() ]);
    }
    
    }

    public function viewAllCoursesApi(Request $request) {
        $courseDetails = [];
        $allCourseCategory = CourseCategory::all();
        $courses = Course::where('is_published', true)->get();

        $filters = Filter::all();
        $userType =  UserType::where('user_role', Config::get('common.ROLE_NAME_INSTRUCTOR'))->value('id');

        $instructors = User::where('role_id', $userType)->get();

        foreach($courses as $course)
        {
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
            $duration = $course->course_duration;
            $hours = intval($duration);
            $minutesDecimal = $duration - $hours;
            $minutes = ($minutesDecimal/100) * 6000;
            $ratings = 0;
            $ratingsSum = 0;
            $ratingsCount = 0;

            if($course->use_custom_ratings) {
                $ratings = $course->course_rating;
            } else {
                $generalCourseFeedbacks = GeneralCourseFeedback::where('course_id', $course->id)->get();
                foreach($generalCourseFeedbacks as $generalCourseFeedback) {
                    $ratingsSum = $ratingsSum + $generalCourseFeedback->rating;
                    $ratingsCount++;
                }
                if($ratingsCount != 0) {
                    $ratings = intval($ratingsSum/$ratingsCount);
                }
            }
            
            $duration = $hours . 'h ' . $minutes . 'm';
            
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_thumbnail_image' => $course->course_thumbnail_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
                'rating' => $ratings,
                'use_custom_ratings' => $course->use_custom_ratings,
                'ratingsCount' => $ratingsCount,
                'duration' => $duration                
            );
            array_push($courseDetails, $courseData);
        }
        $courseDetailsObj = collect($courseDetails);
        return response()->json(['courseDatas' => $courseDetailsObj, 'allCourseCategory' => $allCourseCategory, 'filters' => $filters, 'instructors' => $instructors, 'searchTerm' => '']);
    }

    public function showCourseApi($id){
        $currentURL = url()->current();
        $singleCourseDetails =[];
        $sessions = [];
        $enrolledFlag = false;
        $singleCourseFeedbacks = [];
        $courseContents = [];
        $batchDetails = [];

        $course = Course::findOrFail($id);
        $duration = $course->course_duration;
        $hours = intval($duration);
        $minutesDecimal = $duration - $hours;
        $minutes = ($minutesDecimal/100) * 6000;
    
        $duration = $hours . 'h ' . $minutes . 'm';
    
        $short_description = explode(";",$course->short_description);
        $course_details_points = $course->course_details_points;

        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
        $profilePhoto = User::where('id', $assigned)->value('image');
        $instructorDesignation = User::where('id', $assigned)->value('designation');
        $instructorInstitute = User::where('id', $assigned)->value('institute');
        $instructorDescription = User::where('id', $assigned)->value('description');
        $instructorTwitter = User::where('id', $assigned)->value('twitter_social');
        $instructorLinkedin = User::where('id', $assigned)->value('linkedIn_social');
        $instructorYoutube = User::where('id', $assigned)->value('youtube_social');
       
        $current_date = Carbon::now()->format('Y-m-d');
        
        $batches = DB::table('cohort_batches')->where('course_id', $course->id)->get();
        foreach($batches as $batch){
            $batchname = $batch->batchname;
            $batch_start_date = $batch->start_date;
            $batch_start_time = $batch->start_time;
            $batch_end_time = $batch->end_time;
            $batch_end_date = $batch->end_date;
            $batch_time_zone = $batch->time_zone;
            
            $liveSession = LiveSession::where('batch_id', $batch->id)->where('start_date', '>', $current_date)->orderby('start_date', 'asc')->get();
            if(count($liveSession)) {
               $latest = $liveSession[0];
               
               array_push($batchDetails, array(
                    'batchname' => $batchname,
                    'batch_start_date' => Carbon::createFromFormat('Y-m-d',$batch_start_date)->format('M d'),
                    'batch_start_time' => Carbon::createFromFormat('H:i:s',$batch_start_time)->format('h A'),
                    'batch_end_time' => Carbon::createFromFormat('H:i:s',$batch_end_time)->format('h A'),
                    'batch_end_date' =>  Carbon::createFromFormat('Y-m-d',$batch_end_date)->format('m/d/Y'),
                    'batch_time_zone' => $batch_time_zone,
                    'latest' =>  $latest,
                    
                ));
            }
        }

           
    
        $topics = Topic::where('course_id', $id)->get();
        
         foreach($topics as $topic){
 
             $courseId =  $topic->course_id;
             $topicId = $topic->topic_id;
             $topic_title =  $topic->topic_title;
             $topicContentArray= TopicContent::where('topic_id', array($topicId))->get();
             $contentsData = $topicContentArray->toArray();
 
             array_push($courseContents, array(
                 'topic_id' => $topicId,
                 'topic_title' =>$topic_title,
                 'contentsData' => $contentsData
             ));
         }

         
        $user = Auth::user();
        $userType = "";
        if($user){
        $userType =  UserType::find($user->role_id)->user_role;
        }
        if($userType == "student") {
            $userId = $user->id;
            $enrollment = EnrolledCourse::where('user_id', $userId)->where('course_id', $id)->get();
            if(count($enrollment) != 0) {
                $enrolledFlag = true;
            } else {
                $enrolledFlag = false;
            }
        }

        $generalCourseFeedbacks = DB::table('general_course_feedback')->where([['course_id',$course->id],['is_moderated',1]])->get();
        foreach($generalCourseFeedbacks as $generalCourseFeedback){
            $studentFirstname = User::where('id', $generalCourseFeedback->user_id )->value('firstname');
            $studentLastname = User::where('id',  $generalCourseFeedback->user_id)->value('lastname');
            $studentProfilePhoto = User::where('id', $generalCourseFeedback->user_id)->value('image');
        array_push($singleCourseFeedbacks, array(
            'user_id' => $generalCourseFeedback->user_id,
            'rating' => $generalCourseFeedback->rating,
            'comment' => $generalCourseFeedback->comment,
            'created_at' => Carbon::parse($generalCourseFeedback->created_at)->diffForHumans(),
            'studentFirstname' => $studentFirstname,
            'studentLastname' => $studentLastname,
            'studentProfilePhoto' => $studentProfilePhoto,
            ));   
        }
        

        $singleCourseData =  array (
            'id' => $course->id,
            'course_title' => $course->course_title,
            'course_category' => $courseCategory,
            'description' => $course->description,
            'course_difficulty' => $course->course_difficulty,
            'course_details' => $course->course_details,
            'course_image' => $course->course_image,
            'instructorId' => $assigned,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'profile_photo' => $profilePhoto,
            'designation' => $instructorDesignation,
            'institute' => $instructorInstitute,
            'instructorDescription' => $instructorDescription,
            'instructorTwitter' => $instructorTwitter,
            'instructorLinkedin' => $instructorLinkedin,
            'instructorYoutube' => $instructorYoutube,
            'duration' => $duration

        );
        array_push($singleCourseDetails, $singleCourseData);
        $batches = DB::table('cohort_batches')->where('course_id', $id)->get();
        $cohort_full = true;
        foreach($batches as $batch){
            $available_count = $batch->students_count;
            $booked_slotes = DB::table('enrolled_courses')
                ->where([['course_id','=',$id],['batch_id','=',$batch->id]])
                ->get();
            $booked_slotes_count = count($booked_slotes);
            $available_count = $available_count-$booked_slotes_count;
            if($available_count > 0){
                $cohort_full = false;
            }
        }
        return response()->json([
            'singleCourseDetails' => $singleCourseDetails,
            'singleCourseFeedbacks' => $singleCourseFeedbacks,
            'courseContents' => $courseContents,
            'batchDetails' => $batchDetails,
            'short_description' => $short_description,
            'course_details_points' => $course_details_points,
            'userType' => $userType,
            'enrolledFlag' => $enrolledFlag,
            'currenturl' => $currentURL,
            'cohort_full_status' => $cohort_full
        ]);

    }


    public function registerCourseApi(Request $request) {

        $singleCourseDetails =[];
        $course = Course::findOrFail($request->id);
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
       
        $batches = DB::table('cohort_batches')->where('course_id', $course->id)->get();
        foreach($batches as $batch){
            $available_count = $batch->students_count;
                $booked_slotes = DB::table('enrolled_courses')
                                    ->where([['course_id','=',$course->id],['batch_id','=',$batch->id]])
                                    ->get();
                $booked_slotes_count = count($booked_slotes);
                $available_count = $available_count-$booked_slotes_count;
            $singleCourseData =  array (
                'batch_id' => $batch->id,
                'batchname' => $batch->batchname,
                'title' => $batch->title,
                'start_date' => Carbon::createFromFormat('Y-m-d',$batch->start_date)->format('M d'),
                'start_time'=> Carbon::createFromFormat('H:i:s',$batch->start_time)->format('h A'),
                'end_time' => Carbon::createFromFormat('H:i:s',$batch->end_time)->format('h A'),
                'time_zone' => $batch->time_zone,
                'available_count' => $available_count
            );
        
        array_push($singleCourseDetails, $singleCourseData);
      }
      $courseDetails = array (
        'course_id' => $course->id,
        'course_title' => $course->course_title,
        'course_category' => $courseCategory,
        'description' => $course->description,
        'course_difficulty' => $course->course_difficulty,
        'instructor_firstname' => $instructorfirstname,
        'instructor_lastname' => $instructorlastname,
        'course_thumbnail_image' => $course->course_thumbnail_image,
        'duration' => $course->course_duration
      );
     
        return response()->json([
            'singleCourseDetails' => $singleCourseDetails,
            'courseDetails' => $courseDetails
        ]);

    }
/*

*/ 
    public function registerCourseProcessApi(Request $request){
      
    try {
       $courseId = $request->course_id;
       $course_title = Course::where('id',  $courseId)->value('course_title');
       $batchId = $request->batch_id;
       $user = Auth::user();
       $userId = $user->id;
       $userType = UserType::all();
       $studentEmail= $user->email;
       $assigned = DB::table('assigned_courses')->where('course_id',  $courseId)->value('user_id');
       $instructor = User::where('id', $assigned);
       $instructorEmail =  $instructor->value('email');
       $instructorName =  $instructor->value('firstname') .' '.$instructor->value('lastname');
       
       $enrolledCourse = new EnrolledCourse;
       $enrolledCourse->user_id = $userId;
       $enrolledCourse->batch_id = $batchId;
       $enrolledCourse->course_id = $courseId;
       $enrolledCourse->progress = 0;
       $enrolledCourse->save();

       $badgeId = AchievementBadge::where('title', 'Joinee')->value('id');

       $badgeAlreadyExists = StudentAchievement::where('student_id', $userId)->where('badge_id', $badgeId)->get();
       
       if(count($badgeAlreadyExists)) {
            $student_achievement = new StudentAchievement;
            $student_achievement->student_id = $userId;
            $student_achievement->badge_id =  $badgeId;
            $student_achievement->is_achieved = true;
            $student_achievement->save();
       }

       $mailDetails =[
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'instructor_name' => $instructorName,
            'course' => $course_title
        ];
        Mail::to($studentEmail)->send(new StudentMailAfterEnrolling($mailDetails));

        $data =[
            'instructor_name' => $instructorName,
            'course_title' => $course_title
        ];
        Mail::to($instructorEmail)->send(new InstructorMailAfterEnrolling($data));
    
        return response()->json([
            'status' => 'success', 
            'message' => 'Enrolled successfully'
            ]);
            
       } catch(Exception $exception){
        return response()->json([
            'status' => 'success', 
            'message' => 'Enrolled successfully'
         ]);
        }
    }

    public function courseReviewApi(Request $request){
        
        try{
        $courseId = $request->course_id;
        $userId = Auth::user()->id;
        $comment = $request->input('comment');
        $rating = $request->input('rating');

        $assigned = DB::table('assigned_courses')->where('course_id', $courseId)->value('user_id');
        $instructorName = User::find($assigned)->firstname.' '.User::find($assigned)->lastname;
        $instructorEmail = User::find($assigned)->email;
        $studentName = User::find($userId)->firstname.' '.User::find($userId)->lastname;
        $courseTitle = Course::find($courseId)->course_title;

        $generalCourseFeedback = new GeneralCourseFeedback;
        $generalCourseFeedback->user_id = $userId;
        $generalCourseFeedback->course_id = $courseId;
        $generalCourseFeedback->comment = $comment;
        $generalCourseFeedback->rating = $rating;
        $generalCourseFeedback->save();

        $details= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];

         Mail::to($instructorEmail)->send(new InstructorMailAfterFeedback($details));

        return response()->json([
            'status' => 'success', 
            'message' => 'Review submitted successfully'
         ]);

        }catch (Exception $exception) {
            return response()->json([
                'status' => 'error', 
                'message' => $exception->getMessage()
             ]);
        }
        
    }

    public function getCourseProgressApi($id) {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $userName = $user->firstname . ' ' . $user->lastname;
            $enrolledCourse = EnrolledCourse::where('course_id', $id)->where('user_id', $userId);
            $courseName = Course::where('id', $id)->value('course_title');
            $progress = $enrolledCourse->value('progress');
    
            return response()->json([
                'status' => 'success',
                'user_id' => $userId,
                'username' => $userName,
                'course_name' => $courseName,
                'progress' => $progress
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
        
    }


    public function afterEnrollViewApi($courseId) {
        try {
    
        $courseDetails =[];
        $topicDetails = [];
        $liveIdArr = [];
        $achievedBadgeDetails = [];
        $badgesDetails = [];
        $allBadges = [];
        $badgeComparisonArray = [];
        $upcoming = [];
        $singleRec = [];
        $finalRec = [];
        $qaArray = [];
        $next_live_cohort = '';
        $course = Course::findOrFail($courseId);
        $user =Auth::user();
        $userType = "";
        $attendedTopics = 0;
        $progress = 0;
        
        if($user){
        $attendanceRecs = AttendanceTracker::where('student', $user->id)->get();
        $topics = Topic::where('course_id', $courseId)->get();
        $totalTopics = count($topics);
        foreach($attendanceRecs as $attendanceRec) {
            $liveSessionId = $attendanceRec->value('live_session_id');

            $sessionCourse = LiveSession::where('live_session_id', $liveSessionId);

            if($sessionCourse == $courseId) {
                $attendedTopics = $attendedTopics + 1;
            }
        }

        
       
        
        $currentUserRoleId = User::where('id', $user->id)->value('role_id');
        $userType = UserType::where('id', $currentUserRoleId)->value('user_role');
        $student_firstname = $user->firstname;
        $student_lastname = $user->lastname;
       
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructor = User::where('id', $assigned);
        $instructorfirstname = $instructor->value('firstname');
        $instructorlastname = $instructor->value('lastname');
        $profilePhoto = $instructor->value('image');
        $instructorDesignation = $instructor->value('designation');
        $instructorInstitute = $instructor->value('institute');
        $instructorDescription = $instructor->value('description');
        $instructorTwitter = $instructor->value('twitter_social');
        $instructorLinkedin =$instructor->value('linkedIn_social');
        $instructorYoutube = $instructor->value('youtube_social');
        $instructorSignature = $instructor->value('signature');
        $date_of_issue = Carbon::now();
        $current_date = Carbon::now()->format('Y-m-d');
        $next_live_cohort = "No sessions scheduled";
        $course_completion = '';
        $topics = Topic::where('course_id',  $courseId)->get();
        $enrolledCourseObj = EnrolledCourse::where('user_id', $user->id)->where('course_id', $courseId);
        $studentBatch = $enrolledCourseObj->value('batch_id');
        
            foreach($topics as $topic){
                $nextCohort = "";
                $scheduled = false;
                $liveId = "";
                $courseId =  $topic->course_id;
                $topicId = $topic->topic_id;
                $topic_title =  $topic->topic_title;
                $topicContents = TopicContent::where('topic_id', $topicId)->get();
                $assignmentsArray = TopicAssignment::where('topic_id', array($topicId))->get();
                $assignmentList = $assignmentsArray->toArray();
                $isAssignmentSubmitted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->where('is_submitted', true)->count() ? true : false;
                $isAssignmentCompleted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->where('is_submitted', true)->where('is_completed', true)->count() ? true : false;
                $isAssignmentStarted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->count() ? true : false;

                array_push($topicDetails, array(

                    'topic_id' => $topicId,
                    'topic_title' =>$topic_title,
                    'topic_content' => $topicContents,
                    'assignmentList'=> $assignmentList,
                    'isAssignmentSubmitted' => $isAssignmentSubmitted,
                    'isAssignmentCompleted' => $isAssignmentCompleted,
                    'isAssignmentStarted' => $isAssignmentStarted
                ));
            }
      return response()->json([
          'status' => 'success',
          'course_id' => $courseId,
          'user_id' => $user->id,
          'assignment_details' => $topicDetails
      ]);
    }
}catch(Exception $exeption) {
    return response()->json([
        'status' => 'error',
        'message' => $exception->getMessage()
    ]);
}
    }



    public function submitAssignmentApi(Request $request){
        try{

        $user = Auth::user();
        $userId = $user->id;
        $studentName = $user->firstname.' '.$user->lastname;
        $topic_assignment_id = $request->assignment_id;
        $comment = $request->input('assignment_comment');
        
        $file = $request->assignment_upload;
        
        $assignementFile = $file->getClientOriginalName();
        $file->storeAs('assignmentAnswers', $assignementFile,'public');

        $topicAssignment = TopicAssignment::where('id', $topic_assignment_id);
        $courseId = $topicAssignment->value('course_id');
        $instructorId = $topicAssignment->value('instructor_id');
        $course_title = Course::where('id', $courseId)->value('course_title');
        $instructorName = User::find($instructorId)->firstname.' '.User::find($instructorId)->lastname;
        $instructorEmail = User::find($instructorId)->email;

        $assignment = Assignment::where('topic_assignment_id', $topic_assignment_id);
       
        $assignment->update(['assignment_answer' => $assignementFile, 'comment' => $comment, 'is_submitted' => true]);

        $badgeId = AchievementBadge::where('title', 'Assignment')->value('id');

        $student_achievement = new StudentAchievement;
        $student_achievement->student_id = $userId;
        $student_achievement->badge_id =  $badgeId;
        $student_achievement->is_achieved = true;
        $student_achievement->save();

        $data= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];

         Mail::to($instructorEmail)->send(new MailAfterAssignmentSubmission($data));

        return respone()->json([
            'status' => 'success',
            'message' => 'Assignment submitted'
        ]);

        }catch (Exception $exception){
            return respone()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
    
    
    }

    public function getBadgesApi() {

        try {
            $badgesDetails = [];
            $allBadges = [];
            $upcoming = [];
            $badgeComparisonArray = [];
            $achievedBadgeDetails = [];

            $user = Auth::user();

            $achievements = StudentAchievement::where('student_id', $user->id)->get();
            
            foreach($achievements as $achievement) {
    
                $achievementBadge = AchievementBadge::where('id' , $achievement->badge_id);
                $badge_name = $achievementBadge->value('title');
                $badge_image = $achievementBadge->value('image');
                $badge_created_at =  StudentAchievement::where('badge_id', $achievement->badge_id)->value('created_at');
       
                array_push($badgeComparisonArray, $achievement->badge_id);
    
                array_push($achievedBadgeDetails, array(
                    'id'=> $achievement->badge_id,
                    'badge_name' =>  $badge_name,
                    'badge_image' => $badge_image,
                    'badge_created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $badge_created_at)->format('F d, Y'),
                ));
            }
    
            $achievementBadges = AchievementBadge::all(); 
    
            foreach($achievementBadges as $badge){
                $badge_id = $badge->id;
                $badge_name = $badge->title;
                $badge_description = $badge->description;
                $badge_image = $badge->image;
    
                array_push($allBadges, $badge_id);
    
                array_push($badgesDetails, array(
                    'id' => $badge_id,
                    'badge_name' => $badge_name,
                    'badge_description' => $badge_description,
                    'badge_image' => $badge_image
                ));
            }
    
            $upcomingBadges = array_diff($allBadges, $badgeComparisonArray);
    
            foreach($upcomingBadges as $badges) {
    
                $achievementBadge = AchievementBadge::where('id' , $badges);
                $badge_name = $achievementBadge->value('title');
                $badge_image = $achievementBadge->value('image');
               
                array_push($upcoming, array(
                    'id'=> $badges,
                    'badge_name' =>  $badge_name,
                    'badge_image' => $badge_image,
                    
                ));
            }
            return response()->json([
                'status' => 'success',
                'achieved_badges' => $achievedBadgeDetails,
                'upcoming_badges' => $upcoming,
                'user_id' => $user->id
            ]);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 'error',
                'message' => $exception->getMessage()
            ]);
        }
        
    }
}
