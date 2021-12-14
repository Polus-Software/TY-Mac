<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Filter;
use App\Models\UserType;
use App\Models\CohortBatch;
use App\Models\LiveSession;
use App\Models\CourseCategory;
use App\Models\EnrolledCourse;
use App\Models\GeneralCourseFeedback;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentMailAfterEnrolling;
use App\Mail\InstructorMailAfterEnrolling;
use App\Models\Topic;
use App\Models\TopicContent;


class CoursesCatalogController extends Controller
{
    public function viewAllCourses(Request $request)
    {
    
        $courseDetails = [];
        $allCourseCategory = CourseCategory::all();
        $courses = Course::all();

        $filters = Filter::all();
        $userType =  UserType::where('user_role', 'instructor')->value('id');

        $instructors = User::where('role_id', $userType)->get();

        foreach($courses as $course)
        {
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
            $duration = $course->course_duration . "h";
       
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_thumbnail_image' => $course->course_thumbnail_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
                'rating' => $course->course_rating,
                'duration' => $duration
            );
            array_push($courseDetails, $courseData);
        }
        $courseDetailsObj = collect($courseDetails);
        $courseDatas = $this->paginate($courseDetailsObj);
        $courseDatas->withPath('');
        return view('Student.allCourses', ['courseDatas' => $courseDatas, 'allCourseCategory' => $allCourseCategory, 'filters' => $filters, 'instructors' => $instructors]);
        
    }
        
    

    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function showCourse($id){

        $singleCourseDetails =[];
        $sessions = [];
        $enrolledFlag = false;
        $singleCourseFeedbacks = [];
        $courseContents = [];

        $course = Course::findOrFail($id);
        $liveSessions = LiveSession::where('course_id', $id)->get();
        $short_description = explode(";",$course->short_description);
        $course_details_points = explode(";",$course->course_details_points);

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
        $userType =  UserType::find($user->role_id)->user_role;

        if($userType == "student") {
            $userId = $user->id;
            $enrollment = EnrolledCourse::where('user_id', $userId)->where('course_id', $id)->get();
            if(count($enrollment) != 0) {
                $enrolledFlag = true;
            } else {
                $enrolledFlag = false;
            }
        }

        $generalCourseFeedbacks = DB::table('general_course_feedback')->where('course_id',$course->id)->get();
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
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'profile_photo' => $profilePhoto,
            'designation' => $instructorDesignation,
            'institute' => $instructorInstitute,
            'instructorDescription' => $instructorDescription,
            'instructorTwitter' => $instructorTwitter,
            'instructorLinkedin' => $instructorLinkedin,
            'instructorYoutube' => $instructorYoutube,

        );
        array_push($singleCourseDetails, $singleCourseData);
       // dd($singleCourseDetails);
        return view('Student.showCourse', [
            'singleCourseDetails' => $singleCourseDetails,
            'singleCourseFeedbacks' => $singleCourseFeedbacks,
            'courseContents' => $courseContents,
            'liveSessions' => $liveSessions,
            'short_description' => $short_description,
            'course_details_points' => $course_details_points,
            'userType' => $userType,
            'enrolledFlag' => $enrolledFlag
        ]);

    }







    public function enrollCourse(){

        if (Auth::check() == true) {
            return response()->json(
                ['status' => 'success', 'message' => 'User logged in !']);
       }else{
        return response()->json(
                ['status' => 'failed', 'message' => 'Not Logged in']);
       }
    }
    
    public function loginModalProcess(Request $request) {

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
           return redirect()->back()->with(['success' => 'Successfully logged in!']);
       
        }
    }

    public function registerCourse(Request $request){

        $singleCourseDetails =[];
        $course = Course::findOrFail($request->id);
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
       
        $batches = DB::table('cohort_batches')->where('course_id', $course->id)->get();
        foreach($batches as $batch){
            $singleCourseData =  array (
            'batch_id' => $batch->id,
            'batchname' => $batch->batchname,
            'start_date' => Carbon::createFromFormat('Y-m-d',$batch->start_date)->format('M d'),
            'start_time'=> Carbon::createFromFormat('H:i:s',$batch->start_time)->format('h A'),
            'end_time' => Carbon::createFromFormat('H:i:s',$batch->end_time)->format('h A'),
            'region' => $batch->region,
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
        'course_image' => $course->course_image,
      );
        return view('Student.registerCourse', [
            'singleCourseDetails' => $singleCourseDetails,
            'courseDetails' => $courseDetails
        ]);

    }

    public function registerCourseProcess(Request $request){
      
       $courseId = $request->course_id;
       
       $batchId = $request->batch_id;
       $user = Auth::user();
       $userId = $user->id;
       $studentEmail= $user->email;
       $assigned = DB::table('assigned_courses')->where('course_id',  $courseId)->value('user_id');
       $instructorEmail = User::where('id', $assigned)->value('email');
       
       $enrolledCourse = new EnrolledCourse;
       $enrolledCourse->user_id = $userId;
       $enrolledCourse->batch_id = $batchId;
       $enrolledCourse->course_id = $courseId;
       $enrolledCourse->progress = 0;
       $enrolledCourse->save();

       $mailDetails =[
        'title' => 'Thank you for enrolling the course',
        'body' => 'You have successfully enrolled the course... Happy learning!!!'
    ];
    Mail::to($studentEmail)->send(new StudentMailAfterEnrolling($mailDetails));

    $data =[
        'title' => 'student enrolled  your course',
        'body' => 'student enrolled  your course'
    ];
    Mail::to($instructorEmail)->send(new InstructorMailAfterEnrolling($data));
  
       return response()->json([
           'status' => 'success', 
           'message' => 'Enrolled successfully'
        ]);
        
    }

    // public function afterEnrollView(){
    //     return view('Student.enrolledCoursePage');
    // }
    

    // public function courseReviewProcess(Request $request){

    //     $courseId = $request->course_id;
    //     $userId = $request->user_id;
    //     $comment = $request->input('comment');
    //     $rating = $request->input('rating');

    //     $generalCourseFeedback = new GeneralCourseFeedback;
    //     $generalCourseFeedback->user_id = $userId;
    //     $generalCourseFeedback->course_id = $courseId;
    //     $generalCourseFeedback->comment = $comment;
    //     $generalCourseFeedback->rating = $rating;
    //     $generalCourseFeedback->save();

    //     return response()->json([
    //         'status' => 'success', 
    //         'message' => 'submitted successfully'
    //      ]);
    // }

    public function filterCourse(Request $request) {
     
     $html = '';
     $categoryFlag = 0;
     $levelsFlag = 0;
     $ratingsFlag = 0;
     $categories = $request->categories;
     $levels = $request->levels;
     $ratings = $request->ratings;
     $courses = DB::table('courses');
     

     if($categories) {
         $categoriesArr = explode(",", $categories);
         foreach($categoriesArr as $category) {
            $categoryPair = explode('=', $category);
            if($categoryFlag == 0) {
                $courses = $courses->where('category', $categoryPair[1]);
                $categoryFlag = 1;
            } else {
                $courses = $courses->orWhere('category', $categoryPair[1]);
            }
         }
     }

     if($levels) {
        $levelsArr = explode(",", $levels);
        foreach($levelsArr as $level) {
           $levelPair = explode('=', $level);
            if($levelPair[1] == "all") {
                $courses = $courses->where('course_difficulty', 'beginner')->orWhere('course_difficulty', 'intermediate')->orWhere('course_difficulty', 'advanced');
                break;
            }
            if($levelsFlag == 0) {
                $courses = $courses->where('course_difficulty', $levelPair[1]);
                $levelsFlag = 1;
            } else {
                $courses = $courses->orWhere('course_difficulty', $levelPair[1]);
            }
        }
    }

    if($ratings) {
        $ratingsArr = explode(",", $ratings);
        foreach($ratingsArr as $rating) {
           $ratingPair = explode('=', $rating);
            if($ratingsFlag == 0) {
                $courses = $courses->where('course_rating', '>=' , $ratingPair[1]);
                $ratingsFlag = 1;
            } else {
                $courses = $courses->orWhere('course_rating', '>=' , $ratingPair[1]);
            }
        }
    }


     $courses = $courses->get();
           foreach($courses as $course) {
                $html = $html . '<div class="col-lg-6"><div class="card mb-4">';
                $html = $html . '<img src="" class="card-img-top" alt="..."><div class="card-body">';
                $html = $html . '<h5 class="card-title text-center">'. $course->course_title .'</h5>';
                $html = $html . '<p class="card-text">';
                $html = $html . \Illuminate\Support\Str::limit($course->description, $limit = 150, $end = '....');
                $html = $html . '<a href="/show-course/' . $course->id . '" class="">Read More</a></p>';
                $html = $html . '<div class="row"><div class="col-lg-6 col-sm-6 col-6">';
                for($i=1;$i<=5;$i++) {
                    if($i <= $course->course_rating) {
                        $html = $html . '<i class="fas fa-star rateCourse"></i>';
                    } else {
                        $html = $html . '<i class="far fa-star rateCourse"></i>';
                    }
                } 

                $html = $html . '(60)</div>';  
                $html = $html . '<div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">';  
                $html = $html . '<i class="fas fa-tag fa-flip-horizontal ps-2"></i>Course category</div></div></div>';   //$courseCategory 
                $html = $html . '<ul class="list-group list-group-flush"><li class="list-group-item"><div class="row">'; 
                $html = $html . '<div class="col-lg-4 col-sm-4 col-4 item-1"><i class="far fa-clock pe-1"></i>1h 50m</div>';
                $html = $html . '<div class="col-lg-4 col-4 item-2 text-center"><i class="far fa-user pe-1"></i></div>'; //$instructorName
                $html = $html . '<div class="col-lg-4 col-4 item-3">'. $course->course_difficulty .'</div></div></li></ul>';
                $html = $html . '<div class="card-body"><div class="row"><div class="btn-group border-top" role="group" aria-label="Basic example">'; 
                $html = $html . '<a href="" class="card-link btn border-end">Register now</a>'; 
                $html = $html . '<a href="/show-course/' . $course->id . '" class="card-link btn">Go to details<i class="fas fa-arrow-right ps-2"></i></a></div></div></div></div></div>';        
            }
     
     return response()->json([
        'status' => 'success', 
        'message' => 'submitted successfully',
        'html' => $html
     ]);
    
    }

}
