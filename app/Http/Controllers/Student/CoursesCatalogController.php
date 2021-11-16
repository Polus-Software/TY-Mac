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
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;



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
        $course = Course::findOrFail($id);
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
        $profilePhoto = User::where('id', $assigned)->value('image');
    
        $singleCourseData =  array (
            'id' => $course->id,
            'course_title' => $course->course_title,
            'course_category' => $courseCategory,
            'description' => $course->description,
            'course_difficulty' => $course->course_difficulty,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'profile_photo' => $profilePhoto,
        );
        array_push($singleCourseDetails, $singleCourseData);
   
        return view('Student.showCourse', [
            'singleCourseDetails' => $singleCourseDetails
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
        //return redirect('/register-course');
        }
    }

    public function registerCourse(Request $request){

        $singleCourseDetails =[];
        $course = Course::findOrFail($request->id);
        
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
       
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
       
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
        $batchname = CohortBatch::where('course_id',  $course->id)->value('batchname');
        $batch_start_time = CohortBatch::where('course_id',  $course->id)->value('start_time');
        $batch_end_time = CohortBatch::where('course_id',  $course->id)->value('end_time');
    
        $singleCourseData =  array (
            'id' => $course->id,
            'course_title' => $course->course_title,
            'course_category' => $courseCategory,
            'description' => $course->description,
            'course_difficulty' => $course->course_difficulty,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
           
            
        );
        array_push($singleCourseDetails, $singleCourseData);
   
        return view('Student.registerCourse', [
            'singleCourseDetails' => $singleCourseDetails
        ]);

    }

    public function registerCourseProcess(){


    }


}
