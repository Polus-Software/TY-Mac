<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\UserType;
use App\Models\CohortBatch;
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



class CoursesCatalogController extends Controller
{
    public function viewAllCourses()
    {
    
        $courseDetails = [];
        $courses = Course::all();
        foreach($courses as $course)
        {
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
       
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_image' => $course->course_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
            );
            array_push($courseDetails, $courseData);
        }
        $courseDetailsObj = collect($courseDetails);
        $courseDatas = $this->paginate($courseDetailsObj);
        $courseDatas->withPath('');
        return view('Student.allCourses', compact('courseDatas'));
        
    }
        
    

    public function paginate($items, $perPage = 3, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function showCourse($id){

        $singleCourseDetails =[];
        $singleCourseFeedbacks = [];
        $course = Course::findOrFail($id);
        $short_description = explode(";",$course->short_description);
        $course_details_points = explode(";",$course->course_details_points);

        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
        $profilePhoto = User::where('id', $assigned)->value('image');

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
        );
        array_push($singleCourseDetails, $singleCourseData);
  
        return view('Student.showCourse', [
            'singleCourseDetails' => $singleCourseDetails,
            'singleCourseFeedbacks' => $singleCourseFeedbacks,
            'short_description' => $short_description,
            'course_details_points' => $course_details_points 
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
    

    public function courseReviewProcess(Request $request){

        $courseId = $request->course_id;
        $userId = $request->user_id;
        $comment = $request->input('comment');
        $rating = $request->input('rating');

        $generalCourseFeedback = new GeneralCourseFeedback;
        $generalCourseFeedback->user_id = $userId;
        $generalCourseFeedback->course_id = $courseId;
        $generalCourseFeedback->comment = $comment;
        $generalCourseFeedback->rating = $rating;
        $generalCourseFeedback->save();

        return response()->json([
            'status' => 'success', 
            'message' => 'submitted successfully'
         ]);
    }

}
