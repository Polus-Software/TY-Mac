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
use App\Models\StudentFeedbackCount;
use App\Models\CourseQA;

use App\Mail\SignupMail;
use App\Mail\AdminMailAfterSignUp;
use App\Mail\PersonalDetailsUpdatedMail;
use App\Mail\StudentMailAfterEnrolling;
use App\Mail\InstructorMailAfterEnrolling;
use App\Mail\InstructorMailAfterFeedback;
use App\Mail\MailAfterAssignmentSubmission;
use App\Mail\mailAfterAssignmentReview;
use App\Mail\MailAfterQuestion;
use App\Mail\MailAfterReplay;
use App\Models\CustomTimezone;
use App\Models\CohortBatch;
use DateTime;
use DateTimeZone;

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
     *  Api function for login
     *  $request variables : email, password
     *  returns a token which is to be used as bearer token
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
                'status' => 200,
                'message' => 'Login success',
                'url' => $redirectTo,
                'token' => $token
            ]);
        }
        return response()->json([
            'status' => 503,
            'message' => 'Invalid username/password',
            'url' => ''
        ]);
    }

    /**
     * Api function for student sign up
     * request variables : firstname, lastname, email, password, password_confirmation, privacy_policy
     */
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
                'adminFirstName' => $admin->firstname,
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
            'status' => 200,
            'message' => 'Signup success'
        ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
        
        
    }
    /**
     * Api function for student logout
     */
    public function logoutApi() {
        try {
            if(auth()->user()) {
                auth()->user()->tokens()->delete();
                Session::flush();
            }
            return response()->json([
                'status' => 200,
                'message' => 'logout successful'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
        
    }

    /**
     * Api function for retrieving all notifications of logged in user
     */
    public function getNotificationsApi(Request $request) {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $notifications = Notification::where('user', $userId)->get();
            return response()->json(['status' => 200, 'user_id' => $userId, 'notifications' => $notifications ]);
        } catch(Exception $exception) {
            return response()->json(['status' => 503, 'message' => $exception->getMessage() ]);
        }
    }

    /**
     * Api function for student feedback
     * request variables : name, phone, message, email
     */
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
                'status' => 200,
                'message' => 'Submitted succesfully'
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
        
    }
    
    /**
     * Api function for password reset
     * request variables : email, password, password_confirmation
     */
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
              'status' => 200,
              'message' => 'Your password has been changed!'
          ]);
     
          
        } catch (Exception $exception){
           return response()->json([
              'status' => 503,
              'message' => $exception->getMessage()
          ]);
        }
     }

     /**
      * Api function to edit the students profile
      * request variables: firstname, lastname, email, timezone
      */
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
                'status' => 200,
                'message' => 'update successful',
                'user_role' => Auth::user()->role_id
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
        
        
    }

    /**
      * Api function to upload student user avatar
      * request variables: image
      */
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

        return response()->json(['status' => 200, 'message' => 'Successfully changed avatar']);
    } catch (Exception $exception) {
        return response()->json(['status' => 503, 'message' => $exception->getMessage() ]);
    }
    
    }

    /**
      * Api function to retrieve all courses
      */
    public function viewAllCoursesApi(Request $request) {
        try {
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
            return response()->json(['status' => 200, 'courseDatas' => $courseDetailsObj, 'allCourseCategory' => $allCourseCategory, 'filters' => $filters, 'instructors' => $instructors, 'searchTerm' => '']);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
    * Api function to retrieve a single course
    * @param $id
    */
    public function showCourseApi($id){
        try {
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
            foreach($batches as $batch) {
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
                'status' => 200,
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
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
    * Api function to retrieve batches for student to select before enrolling
    * request: id (course id)
    */
    public function registerCourseApi(Request $request) {
        try {
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
                'status' => 200,
                'singleCourseDetails' => $singleCourseDetails,
                'courseDetails' => $courseDetails
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
    * Api function to select batch and enrollstudent to a course
    * request: course_id, batch_id
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

       $badgeAlreadyExists = StudentAchievement::where('student_id', $userId)->where('course_id', $courseId)->where('badge_id', $badgeId)->get();
       
       if(count($badgeAlreadyExists)) {
            $student_achievement = new StudentAchievement;
            $student_achievement->student_id = $userId;
            $student_achievement->badge_id =  $badgeId;
            $student_achievement->is_achieved = true;
            $student_achievement->course_id = $courseId;
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
            'status' => 200, 
            'message' => 'Enrolled successfully'
            ]);
            
       } catch(Exception $exception){
        return response()->json([
            'status' => 503, 
            'message' => $exception->getMessage()
         ]);
        }
    }

    /**
    * Api function to submit course review for a course
    * request: course_id, comment, rating
    */
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
            'status' => 200, 
            'message' => 'Review submitted successfully'
         ]);

        }catch (Exception $exception) {
            return response()->json([
                'status' => 503, 
                'message' => $exception->getMessage()
             ]);
        }
        
    }

    /**
    * Api function to retrieve course progress
    * @param $id (course id)
    */
    public function getCourseProgressApi($id) {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $userName = $user->firstname . ' ' . $user->lastname;
            $enrolledCourse = EnrolledCourse::where('course_id', $id)->where('user_id', $userId);
            $courseName = Course::where('id', $id)->value('course_title');
            $progress = $enrolledCourse->value('progress');
    
            return response()->json([
                'status' => 200,
                'user_id' => $userId,
                'username' => $userName,
                'course_name' => $courseName,
                'progress' => $progress
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
        
    }

    /**
    * Api function to retrieve enrolled course details
    * @param $course_id
    */
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
                    'status' => 200,
                    'course_id' => $courseId,
                    'user_id' => $user->id,
                    'assignment_details' => $topicDetails
                ]);
            }
        } catch(Exception $exeption) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
    * Api function to submit an assignment by a student
    * request: assignment_id, assignment_comment, assignment_upload
    */
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
        $badgeAlreadyExists = StudentAchievement::where('student_id', $userId)->where('course_id', $courseId)->where('badge_id', $badgeId)->get();
        if(count($badgeAlreadyExists) == 0) {
            $student_achievement = new StudentAchievement;
            $student_achievement->student_id = $userId;
            $student_achievement->badge_id =  $badgeId;
            $student_achievement->course_id =  $courseId;
            $student_achievement->is_achieved = true;
            $student_achievement->save();
        }
        

        $data= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];

         Mail::to($instructorEmail)->send(new MailAfterAssignmentSubmission($data));

        return respone()->json([
            'status' => 200,
            'message' => 'Assignment submitted'
        ]);

        }catch (Exception $exception){
            return respone()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
    * Api function to retrieve badges for a student
    */
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
                'status' => 200,
                'achieved_badges' => $achievedBadgeDetails,
                'upcoming_badges' => $upcoming,
                'user_id' => $user->id
            ]);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
        
    }

    /**
    * Api function to retrieve all enrolled courses
    */
    public function showMyCoursesApi(Request $request){
        try {
            $singleEnrolledCourseData = [];
            $liveSessionDetails = [];
            $upComingSessionDetails = [];
            $user = Auth::user();
            $current_date = Carbon::now()->format('Y-m-d');
    
            $enrolledCourses = EnrolledCourse::where('user_id', $user->id)->get();
             foreach($enrolledCourses as $enrolledCourse){
               $courseId = $enrolledCourse->course_id;
               $course = Course::where('id', $enrolledCourse->course_id);
               $course_title = $course->value('course_title');
               $description = $course->value('description');
               $category_id = $course->value('category');
               $course_image = $course->value('course_image');
               $course_difficulty = $course->value('course_difficulty');
               $courseCategory = CourseCategory::where('id', $category_id)->value('category_name');
     
               $cohort_batches = DB::table('live_sessions')->where('batch_id', $enrolledCourse->batch_id)->where('start_date', '>=', $current_date)->get();
               if(count($cohort_batches)) {
                     $cohort_batches = $cohort_batches[0];
                     // Time setting
                     $offset = CustomTimezone::where('name', $user->timezone)->value('offset');
                           
                     $offsetHours = intval($offset[1] . $offset[2]);
                     $offsetMinutes = intval($offset[4] . $offset[5]);
     
                     if($offset[0] == "+") {
                         $sTime = strtotime($cohort_batches->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                         $eTime = strtotime($cohort_batches->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                     } else {
                         $sTime = strtotime($cohort_batches->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                         $eTime = strtotime($cohort_batches->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                     }
     
                     $startTime = date("H:i:s", $sTime);
                     $endTime = date("H:i:s", $eTime);
                     $date = new DateTime("now");
     
                     $start_date =  $cohort_batches->start_date;
                     $start_time =  $startTime;
                     $end_time =  $endTime;
                     $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');
                     $nextCohort = Carbon::parse($start_date)->format('m/d/Y') . "-" . Carbon::createFromFormat('H:i:s',$start_time)->format('h:i A') . " " . $time_zone . " - " . Carbon::createFromFormat('H:i:s',$end_time)->format('h:i A') . " " . $time_zone;
                 
                     
                   } else {
                     $nextCohort = "No live sessions scheduled";
                   }
               
               $assigned = DB::table('assigned_courses')->where('course_id', $enrolledCourse->course_id)->value('user_id');
               $instructorfirstname = User::where('id', $assigned)->value('firstname');
               $instructorlastname = User::where('id', $assigned)->value('lastname');
               $progress = EnrolledCourse::where('course_id', $enrolledCourse->course_id)->where('user_id', $user->id)->value('progress');
               
                                                    
                                                    
               $enrolledCourseData = array(
                 'course_id' => $courseId,
                 'course_title' =>  $course_title,
                 'description' => $description,
                 'category_name' => $courseCategory,
                 'course_difficulty' => $course_difficulty,
                 'course_image' => $course_image,
                 'next_cohort' =>  $nextCohort,
                 'instructor_firstname' => $instructorfirstname,
                 'instructor_lastname' => $instructorlastname,
                 'progress' => (!is_null($progress)) ? $progress : 0
               );
             array_push($singleEnrolledCourseData, $enrolledCourseData);
     
                 $liveSessions = LiveSession::where('course_id', $courseId)->where('batch_id', $enrolledCourse->batch_id)->get();
                 $current_date = Carbon::now()->format('Y-m-d');
                
                 foreach($liveSessions as $session) {
                     $batchId = $session->batch_id;
                     $batch = CohortBatch::where('id', $batchId);
     
                     $currentBatchStartDate = $session->start_date;
                     if($currentBatchStartDate > $current_date) {
                         $session_title = $session->session_title;
                         $course = Course::where('id', $session->course_id);
                         $courseDesc = $course->value('description');
                         $courseDiff = $course->value('course_difficulty');
                         $courseThumbnailImage = $course->value('course_thumbnail_image');
                         $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                         $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
     
                         $start_date = Carbon::createFromFormat('Y-m-d',$currentBatchStartDate)->format('M d');
                         $start_time = Carbon::createFromFormat('H:i:s',$batch->value('start_time'))->format('h A');
                         $end_time = Carbon::createFromFormat('H:i:s',$batch->value('end_time'))->format('h A');
                         
                         $date = $start_date . ', ' . $start_time . ' ' .$batch->value('time_zone') . ' - ' . $end_time . ' ' . $batch->value('time_zone');
                         array_push($upComingSessionDetails, array(
                             'session_title'=>  $session_title,
                             'instructor' => $instructor,
                             'course_desc' => $courseDesc,
                             'course_diff' => $courseDiff,
                             'course_thumbnail_image' => $courseThumbnailImage,
                             'enrolledCourses' => $enrolledCourses,
                             'date' => $date,
                             'course_id' => $session->course_id,
                             'batchId' => $session->batch_id
                         ));
                       
                         
                     } elseif ($currentBatchStartDate == $current_date) {
                       if($session->start_time <= Carbon::now()->addMinutes(10)->format('H:i:s') && $session->end_time >= Carbon::now()->format('H:i:s')) {
                         if($session->is_instructor_present) {
                           $session_title = $session->session_title;
                           $course = Course::where('id', $session->course_id);
                           $courseDesc = $course->value('description');
                           $courseDiff = $course->value('course_difficulty');
                           $courseThumbnailImage = $course->value('course_thumbnail_image');
                           $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                           $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
       
                           $start_date = Carbon::createFromFormat('Y-m-d',$currentBatchStartDate)->format('M d');
                           $start_time = Carbon::createFromFormat('H:i:s',$batch->value('start_time'))->format('h A');
                           $end_time = Carbon::createFromFormat('H:i:s',$batch->value('end_time'))->format('h A');
                           
                           $date = $start_date . ', ' . $start_time . ' ' .$batch->value('time_zone') . ' - ' . $end_time . ' ' . $batch->value('time_zone');
                           array_push($liveSessionDetails, array(
                               'session_title'=>  $session_title,
                               'course_desc' => $courseDesc,
                               'course_diff' => $courseDiff,
                               'course_thumbnail_image' => $courseThumbnailImage,
                               'instructor' => $instructor,
                               'enrolledCourses' => $enrolledCourses,
                               'date' => $date,
                               'id' => $session->live_session_id,
                               'batchId' => $session->batch_id
                           ));
                         }
                       }
                       
                     }
                 }
     
           }
     
           return response()->json([
            'status' => 200,
            'singleEnrolledCourseData' => $singleEnrolledCourseData,
            'upComingSessionDetails' => $upComingSessionDetails,
            'liveSessionDetails' => $liveSessionDetails
           ]);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
   }


   /**
    * Api function to retrieve all assigned courses for an instructor
    */
   public function viewAssignedCoursesApi(){
    try {
        $singleEnrolledCourseData = [];
        $liveSessionDetails = [];
        $upComingSessionDetails = [];
        $current_date = Carbon::now()->format('Y-m-d');
        $user = Auth::user();
        if($user){
         $enrolledCourses = AssignedCourse::where('user_id', $user->id)->get();
         foreach($enrolledCourses as $enrolledCourse){
           $nextCohort = "";
           $bName = "";
           $courseId = $enrolledCourse->course_id;
           $course_title = Course::where('id', $enrolledCourse->course_id)->value('course_title');
           $description = Course::where('id', $enrolledCourse->course_id)->value('description');
           $category_id = Course::where('id', $enrolledCourse->course_id)->value('category');
           $course_image = Course::where('id', $enrolledCourse->course_id)->value('course_image');
           $course_difficulty = Course::where('id', $enrolledCourse->course_id)->value('course_difficulty');
           $courseCategory = CourseCategory::where('id', $category_id)->value('category_name');
           $start_date = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_date');
        //    $start_time = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_time');
        //    $end_time = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('end_time');
           $assigned = DB::table('assigned_courses')->where('course_id', $enrolledCourse->course_id)->value('user_id');
           $instructorfirstname = User::where('id', $assigned)->value('firstname');
           $instructorlastname = User::where('id', $assigned)->value('lastname');
    
        //    Timing setup
    
        $cohort_batches = DB::table('live_sessions')->where('course_id', $enrolledCourse->course_id)->where('start_date', '>=', $current_date)->get();
          if(count($cohort_batches)) {
            $cohort_batches = $cohort_batches[0];
                // Time setting
                $offset = CustomTimezone::where('name', $user->timezone)->value('offset');
                      
                $offsetHours = intval($offset[1] . $offset[2]);
                $offsetMinutes = intval($offset[4] . $offset[5]);
    
                if($offset[0] == "+") {
                    $sTime = strtotime($cohort_batches->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                    $eTime = strtotime($cohort_batches->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                } else {
                    $sTime = strtotime($cohort_batches->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                    $eTime = strtotime($cohort_batches->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                }
    
                $startTime = date("H:i:s", $sTime);
                $endTime = date("H:i:s", $eTime);
                $date = new DateTime("now");
    
                $start_date =  $cohort_batches->start_date;
                $start_time =  $startTime;
                $end_time =  $endTime;
    
                $batch = CohortBatch::where('id', $cohort_batches->batch_id);
                
                $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');
                $nextCohort = Carbon::parse($start_date)->format('m/d/Y') . "-" . Carbon::createFromFormat('H:i:s',$start_time)->format('h:i A') . " " . $time_zone . " - " . Carbon::createFromFormat('H:i:s',$end_time)->format('h:i A') . " " . $time_zone;
                $bName = '(' . $batch->value("batchname") . ' [' . $batch->value("title") . '])';
              } else {
                $nextCohort = "No live sessions scheduled";
              }
              $current_date = Carbon::now()->format('Y-m-d');
              $progress = 0;
              $totalSessions = LiveSession::where('course_id', $enrolledCourse->course_id)->count();
              if($totalSessions != 0) {
                $progressTracker = LiveSession::where('start_date', '<', $current_date)->count();
                $progress = round($progressTracker * 100 / $totalSessions, 0); 
              }
              
           $enrolledCourseData = array(
             'course_id' => $courseId,
             'course_title' =>  $course_title,
             'description' => $description,
             'category_name' => $courseCategory,
             'course_difficulty' => $course_difficulty,
             'course_image' => $course_image,
             'start_date' => Carbon::parse($start_date)->format('m/d/Y'),
             'nextCohort' => $nextCohort,
             'batchName' => $bName,
             'progress' => $progress,
             'instructor_firstname' => $instructorfirstname,
             'instructor_lastname' => $instructorlastname,
           );
          
         array_push($singleEnrolledCourseData, $enrolledCourseData);
       }
    
      
             $liveSessions = LiveSession::all();
             $current_date = Carbon::now()->format('Y-m-d');
            
             foreach($liveSessions as $session) {
                
                 $batchId = $session->batch_id;
                 $batch = CohortBatch::where('id', $batchId);
    
                //  $currentBatchStartDate = $batch->value('start_date');
                 $currentBatchStartDate = $session->start_date;
    
                 if($currentBatchStartDate > $current_date) {
                        $session_title = $session->session_title;
                        $course = Course::where('id', $session->course_id);
                        $courseDesc = $course->value('description');
                        $courseDiff = $course->value('course_difficulty');
                        $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                        $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
    
                        $start_date = Carbon::createFromFormat('Y-m-d',$currentBatchStartDate)->format('M d');
                        $start_time = Carbon::createFromFormat('H:i:s',$batch->value('start_time'))->format('h A');
                        $end_time = Carbon::createFromFormat('H:i:s',$batch->value('end_time'))->format('h A');
                        
                        $date = $start_date . ', ' . $start_time . ' ' .$batch->value('time_zone') . ' - ' . $end_time . ' ' . $batch->value('time_zone');
                        array_push($upComingSessionDetails, array(
                            'session_title'=>  $session_title,
                            'instructor' => $instructor,
                            'course_desc' => $courseDesc,
                            'course_diff' => $courseDiff,
                            'course_id' => $session->course_id,
                            'enrolledCourses' => $enrolledCourses,
                            'image' => $course->value('course_thumbnail_image'),
                            'date' => $date,
                            'session_id' => $session->live_session_id,
                            'batchId' => $session->batch_id
                        ));
                 } elseif ($currentBatchStartDate == $current_date) {
                    //  ->where('start_time', '<=', Carbon::now()->addMinutes(30)->format('H:i:s'))
                    if($session->start_time <= Carbon::now()->addMinutes(30)->format('H:i:s') && $session->end_time >= Carbon::now()->format('H:i:s')) {
                        $session_title = $session->session_title;
    
                        $course = Course::where('id', $session->course_id);
                        $courseDesc = $course->value('description');
                        $courseDiff = $course->value('course_difficulty');
                        $instructor = User::find($session->instructor)->firstname .' '. User::find($session->instructor)->lastname;
                        $enrolledCourses = EnrolledCourse::where('course_id', $session->course_id)->get()->count();
    
                        $start_date = Carbon::createFromFormat('Y-m-d',$currentBatchStartDate)->format('M d');
                        $start_time = Carbon::createFromFormat('H:i:s',$batch->value('start_time'))->format('h A');
                        $end_time = Carbon::createFromFormat('H:i:s',$batch->value('end_time'))->format('h A');
                        
                        $date = $start_date . ', ' . $start_time . ' ' .$batch->value('time_zone') . ' - ' . $end_time . ' ' . $batch->value('time_zone');
                        array_push($liveSessionDetails, array(
                            'session_title'=>  $session_title,
                            'course_desc' => $courseDesc,
                            'course_diff' => $courseDiff,
                            'instructor' => $instructor,
                            'image' => $course->value('course_thumbnail_image'),
                            'enrolledCourses' => $enrolledCourses,
                            'date' => $date,
                            'session_id' => $session->live_session_id,
                            'id' => $session->live_session_id,
                            'batchId' => $session->batch_id
                        ));
                    }
                 }
             }
       return response()->json([
         'status' => 200,
         'singleEnrolledCourseData' => $singleEnrolledCourseData,
         'upComingSessionDetails' => $upComingSessionDetails,
         'liveSessionDetails' => $liveSessionDetails,
       ]);
     } else {
       return redirect('/student-courses');
     }
    } catch(Exception $exception) {
        return response()->json([
            'status' => 503,
            'message' => $exception->getMessage()
        ]);
    }
}


/**
* Api function to retrieve recommendations for a student
*/
 public function getStudentRecommendationsApi($courseId) {
    try {
        $user = Auth::user();
        $finalRec = [];
        if($user) {
            $studentFeedbackCounts = StudentFeedbackCount::where('course_id', $courseId)->where('student', $user->id)->get();
            $total_review_count = count($studentFeedbackCounts);
        
            foreach($studentFeedbackCounts as $feedback) {
                if($feedback->negative == 1) {
                    $topicId = $feedback->topic_id;
                    $topic = Topic::where('topic_id',  $topicId);
                    $contentId = $feedback->content_id;
                    $content = TopicContent::where('topic_content_id',  $contentId);
        
                    $sessionView = LiveSession::where('topic_id', $topicId);
        
                    $singleRec = array(
                        'content_id' => $contentId,
                        'content_title' => $content->value('topic_title'),
                        'topic_id' => $topicId,
                        'topic_title' => $topic->value('topic_title'),
                        'student_id' => $feedback->value('student'),
                        'likes' => $feedback->value('positive'),
                        'dislikes' => $feedback->value('negative'),
                        'sessionId' => $sessionView->value('live_session_id')
                    );
        
                    array_push($finalRec, $singleRec);
                }
            }
            return response()->json(['status' => 200, 'recommendations' => $finalRec]);
        }
    } catch(Exception $exception) {
        return response()->json([
            'status' => 503,
            'message' => $exception->getMessage()
        ]);
    } 
 }

 /**
* Api function to retrieve recommendations for an instructor
*/
 public function instructorRecommendationsApi($courseId, $batchId) {
     try {
        $singleRecommendation = [];
        $finalRecommendation = [];
        $studentsEnrolled = $this->studentsEnrolled($courseId, $batchId);
        foreach($studentsEnrolled as $student) {
            $student_name = User::where('id', $student->user_id)->get();
            $studentFeedbackCounts = StudentFeedbackCount::where('course_id', $courseId)->where('student', $student->user_id)->get();
            foreach($studentFeedbackCounts as $feedback) {
                if($feedback->negative > $feedback->positive) {
                    $topicId = $feedback->topic_id;
                    $topic = Topic::where('topic_id',  $topicId);
                    $contentId = $feedback->content_id;
                    $content = TopicContent::where('topic_content_id',  $contentId);                    
                    $singleRecommendation = array(
                        'content_id' => $contentId,
                        'content_title' => $content->value('topic_title'),
                        'topic_id' => $topicId,
                        'topic_title' => $topic->value('topic_title'),
                        'student_id' => $feedback->student,
                        'likes' => $feedback->positive,
                        'dislikes' => $feedback->negative
                    );
                    array_push($finalRecommendation, $singleRecommendation);
                }
            }
        }
        return response()->json(['status' => 200, 'recommendations' => $finalRecommendation]);
     } catch(Exception $exception) {
        return response()->json([
            'status' => 503,
            'message' => $exception->getMessage()
        ]);
    }
}

/**
* Api function to retrieve students assignment status for an instructor
*/
public function getInstructorAssignmentDataApi($courseId, $selectedBatch) {
    try {
        $assignmentArr = [];
        $assignments = TopicAssignment::where('course_id', $courseId)->get();
    
        $students = $this->studentsEnrolled($courseId, $selectedBatch);
        foreach($students as $student){
            $assignmentStatus = [];
            $studentName = $student->firstname . ' ' . $student->lastname;
            $studentImg = $student->image;
            $batchName = CohortBatch::where('id', $selectedBatch)->value('batchname');
            foreach($assignments as $assignment) {
                $status = "Submitted";
                $stuAssignment = "";
                $studentAssignment = Assignment::where('student_id' , $student->id)->where('topic_assignment_id', $assignment->id)->get();
                if(count($studentAssignment) == 0) {
                    $status = "Pending";  
                } elseif($studentAssignment[0]->is_submitted == false) {
                    $status = "Pending";
                    $stuAssignment = $studentAssignment[0]->assignment_id;
                } elseif($studentAssignment[0]->is_completed == true) {
                    $status = "Completed";
                    $stuAssignment = $studentAssignment[0]->assignment_id;
                } else {
                    $stuAssignment = $studentAssignment[0]->assignment_id;
                }
    
                array_push($assignmentStatus, array(
                    'status' => $status,
                    'assignment_id' => $assignment->id,
                    'stuAssignment' => $stuAssignment
                ));
            }
            
            array_push($assignmentArr, array(
                'studentImg' => $studentImg,
                'student_name' => $studentName,
                'batch_name' => $batchName,
                'assignment_data' => $assignmentStatus
            ));
        }  
        
        return response()->json(['status' => 200, 'assignmentData' => $assignmentArr, 'assignments' => $assignments]);
    } catch(Exception $exception) {
        return response()->json([
            'status' => 503,
            'message' => $exception->getMessage()
        ]);
    }
}

/**
* Api function to review an assignment
*/
public function completeAssignmentApi($assignment) {
    try {
        $user = Auth::user();
        if($user) {
            $assignmentObj = Assignment::where('assignment_id', $assignment)->update(['is_completed' => true]);
        
            $assignmentData = Assignment::where('assignment_id', $assignment);
            $studentId = $assignmentData->value('student_id');
            $courseId = $assignmentData->value('course_id');
            $student = User::where('id', $studentId);
            $studentName = $student->value('firstname').' '.$student->value('lastname');
            $studentEmail = $student->value('email');
            $courseTitle = Course::where('id', $courseId)->value('course_title');
        
            $details= [
                'studentName' => $studentName,
                'courseTitle' => $courseTitle
            ];
            
            Mail::to('infosmtp')->to($studentEmail)->send(new mailAfterAssignmentReview($details));
            $notification = new Notification; 
            $notification->user = $user->id;
            $notification->notification = "Hello ".$studentName." ,Your assignment for the course ".$courseTitle." has been reviewed by the instructor. 
                                           To view the reviewed assignment, please log in to your account on ThinkLit.com";
            $notification->is_read = false;
            $notification->save();
            
            return response()->json(['status' => 200, 'message' => 'successfully reviewed']);
        }
    } catch(Exception $exception) {
        return response()->json([
            'status' => 503,
            'message' => $exception->getMessage()
        ]);
    }
}

/**
* private function to retrieve students enrolled in a course in a batch
*/
    private function studentsEnrolled($courseId, $batchId) {
        $studentsEnrolled = DB::table('enrolled_courses as a')
                            ->join('users as b', 'a.user_id', '=', 'b.id')
                            ->where('a.course_id', $courseId)
                            ->where('a.batch_id', $batchId)
                            ->get();
        return $studentsEnrolled;
    }

    /**
    * Api function to ask a question in the QA section for a student user
    */
    public function askQuestionApi(Request $request) {
        try {

            $question = $request->question;
            $course_id = $request->course_id;
            $student = 0;

            $qa = new CourseQA;
            $qa->course_id = $course_id;
            $instructor = AssignedCourse::where('course_id', intval($course_id))->value('user_id');
            $user = Auth::user();
            $instructorName = User::find($instructor)->firstname.' '.User::find($instructor)->lastname;
            $instructorEmail = User::where('id', $instructor)->value('email');
            $studentName = $user->firstname.' '.$user->lastname;
            if($user) {
                $student = User::where('id', $user->id)->value('id');
                
                $enrolledCourse = EnrolledCourse::where('user_id', $user->id)->where('course_id', $course_id);
                $batch = $enrolledCourse->value('batch_id');
                
                $badgeId = AchievementBadge::where('title', 'Q&A')->value('id');
                $achievementCheck = StudentAchievement::where('student_id', $user->id)->where('course_id', $course_id)->where('badge_id', $badgeId)->count();
                
                if(!$achievementCheck) {
                    $student_achievement = new StudentAchievement;
                    $student_achievement->student_id = $user->id;
                    $student_achievement->badge_id =  $badgeId;
                    $student_achievement->course_id =  $course_id;
                    $student_achievement->is_achieved = true;
                    $student_achievement->save();
                }
                
                $data = [
                    'studentName' => $studentName,
                    'instructorName' => $instructorName,
                ];
    
                $qa->student = $student;
                $qa->instructor = $instructor;
                $qa->question = $question;
                $qa->has_replied = false;
                $qa->batch_id = $batch;
    
                $qa->save();
    
                Mail::to('infosmtp')->to($instructorEmail)->send(new MailAfterQuestion($data));
    
                $notification = new Notification; 
                $notification->user = $instructor;
                $notification->notification = "Hi ". $instructorName.",You have got a new message from your student ".$studentName." on ThinkLit. To view the message, please log in to your account on ThinkLit.com";
                $notification->is_read = false;
                $notification->save();
    
                return response()->json(['status' => 200, 'msg' => 'Saved successfully!', 'question' => $question, 'studentName' => $studentName, 'studentId' => $student]);
            }

        } catch (Exception $exception) {
            return response()->json(['status' => 503, 'msg' => 'Some error']);
        }
    }

    /**
    * Api function to reply to a students question in the QA section by an instructor
    */
    public function replyToStudentApi(Request $request) {
        try{
        $qaId = $request->qaId;
        $reply = $request->replyContent;

        $instructorId = Auth::user()->id;
        $courseQA = CourseQA::find($qaId);
        $studentId = $courseQA->value('student');
        $courseTitle = Course::where('id', $courseQA->value('course_id'))->value('course_title');
        $student = User::where('id', $studentId);
        $studentEmail = $student->value('email');
        $studentName = $student->value('firstname').' '.$student->value('lastname');
        $instructorName = User::find($instructorId)->firstname.' '.User::find($instructorId)->lastname;
        
        $details= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];
   
        $courseQA->reply = $reply;
        $courseQA->has_replied = true;
        $updatedAt = $courseQA->updated_at->format('d M H:m');
        $courseQA->save();

        Mail::to('infosmtp')->to($studentEmail)->send(new MailAfterReplay($details));

        $notification = new Notification; 
        $notification->user = $studentId;
        $notification->notification = "Hello ". $studentName.", You have got a reply to your message from your Instructor ". $instructorName."for the course ". $courseTitle." on ThinkLit. To view the message,
         please log in to your account on ThinkLit.com";
        $notification->is_read = false;
        $notification->save();

        return response()->json([
            'status' => 200,
            'reply' => $reply, 
            'updatedAt' => $updatedAt,
            'message' => 'Replied successfully'
         ]);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => 'Some error'
             ]);
        } 
    }

    /**
    * Api function to retrieve instructors schedule for a particular course and batch
    */
    public function viewInstructorScheduleApi($courseId, $batchId) {
        try {
            $liveSessions = LiveSession::where('course_id', $courseId)->where('batch_id', $batchId)->orderby('start_date', 'asc')->get();
            return response()->json(['status' => 200, 'liveSessions' => $liveSessions]);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function viewStudentScheduleApi($courseId, $batchId) {
        try {
            $liveSessions = LiveSession::where('course_id', $courseId)->where('batch_id', $batchId)->orderby('start_date', 'asc')->get();
            return response()->json(['status' => 200, 'liveSessions' => $liveSessions]);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }

    /**
    * Api function to retrieve list of cohort batches to choose from for an instructor
    */
    public function chooseCohortApi($courseId){
        try {
            $user = Auth::user();
            $singleCourseDetails =[];
            $course = Course::findOrFail($courseId);
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
           
            $batches = DB::table('cohort_batches')->where('course_id', $course->id)->get();
    
            $offset = CustomTimezone::where('name', $user->timezone)->value('offset');
    
            $offsetHours = intval($offset[1] . $offset[2]);
            $offsetMinutes = intval($offset[4] . $offset[5]);
            
            $date = new DateTime("now");
            $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');
    
            foreach($batches as $batch){
                if($offset[0] == "+") {
                    $sTime = strtotime($batch->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                    $eTime = strtotime($batch->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                } else {
                    $sTime = strtotime($batch->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                    $eTime = strtotime($batch->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                }
                        
                $startTime = date("H:i A", $sTime);
                $endTime = date("H:i A", $eTime);
                
    
                $singleCourseData =  array (
                'batch_id' => $batch->id,
                'batchname' => $batch->batchname,
                'title' => $batch->title,
                'start_date' => Carbon::createFromFormat('Y-m-d',$batch->start_date)->format('M d'),
                'start_time'=> $startTime,
                'end_time' => $endTime,
                'time_zone' => $time_zone
            );
            
            array_push($singleCourseDetails, $singleCourseData);
          }
    
          $duration = $course->course_duration;
          $hours = intval($duration);
          $minutesDecimal = $duration - $hours;
          $minutes = ($minutesDecimal/100) * 6000;
    
          $duration = $hours . 'h ' . $minutes . 'm';
    
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
          $ratings = $course->course_rating;
          $studentCount = EnrolledCourse::where('course_id', $course->id)->count();
          $courseDetails = array (
            'course_id' => $course->id,
            'course_title' => $course->course_title,
            'course_category' => $courseCategory,
            'description' => $course->description,
            'course_difficulty' => $course->course_difficulty,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'course_thumbnail_image' => $course->course_thumbnail_image,
            'rating' => $ratings,
            'studentCount' => $studentCount,
            'use_custom_ratings' => $course->use_custom_ratings,
            'ratingsCount' => $ratingsCount,
            'duration' => $duration
          );
         
            return response()->json([
                'status' => 200,
                'singleCourseDetails' => $singleCourseDetails,
                'courseDetails' => $courseDetails
            ]);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }


    /**
    * Api function to push feedbacks for topic contents by a student, which is a part of the recommendations engine
    */ 
    public function pushFeedbacksApi(Request $request) {
        try {
            $contentId = $request->content_id;
            $session = $request->session;
            $type = $request->type;
            $user = Auth::user();
            $feedbackCountExists = StudentFeedbackCount::where('content_id', $contentId)->where('student', $user->id)->where('live_session', $session)->get();
            if(count($feedbackCountExists)) {
                $feedbackCountExists = StudentFeedbackCount::where('content_id', $contentId)->where('live_session', $session);
                if($type == "positive") {
                    $feedbackCountExists->update(['positive' => 1]);
                    $feedbackCountExists->update(['negative' => 0]);
                } else {
                    $feedbackCountExists->update(['positive' => 0]);
                    $feedbackCountExists->update(['negative' => 1]);
                }
            } else {
                $feedbackCount = new StudentFeedbackCount;
                $content = TopicContent::where('topic_content_id', $contentId);
                $topicId = $content->value('topic_id');
                $topic = Topic::where('topic_id', $topicId);
                $courseId = $topic->value('course_id');
                $user = Auth::user();
    
                $enrolledCourse = EnrolledCourse::where('user_id', $user->id)->where('course_id', $courseId);
                $batchId = $enrolledCourse->value('batch_id');
    
                $student =  $user->id;
                $feedbackCount->content_id = $contentId;
                $feedbackCount->topic_id = $topicId;
                $feedbackCount->course_id = $courseId;
                $feedbackCount->student = $student;
                $feedbackCount->batch_id = $batchId;
                $feedbackCount->live_session = $session;
                if($type == "positive") {
                    $feedbackCount->positive = 1;
                    $feedbackCount->negative = 0;
                } else {
                    $feedbackCount->positive = 0;
                    $feedbackCount->negative = 1;
                }
    
                $feedbackCount->save();
            }
            $finalCounts = StudentFeedbackCount::where('content_id', $contentId)->where('live_session', $session);
            $positiveCount = $finalCounts->value('positive');
            $negativeCount = $finalCounts->value('negative');
            return response()->json(['status' => 200, 'positive' => $positiveCount, 'negative' => $negativeCount, 'message' => 'Feedback recorded']);
        } catch(Exception $exception) {
            return response()->json([
                'status' => 503,
                'message' => $exception->getMessage()
            ]);
        }
    }
}
