<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EnrolledCourseController extends Controller
{
    public function afterEnrollView(Request $request){


    $courseDetails =[];
    $courseId = $request->course_id;
    $course = Course::findOrFail($courseId);
 
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        //dd($courseCategory);
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
            'course_details' => $course->course_details,
            'course_image' => $course->course_image,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'profile_photo' => $profilePhoto,
        );
        array_push($courseDetails, $singleCourseData);
    
  
    
//dd($courseDetails);
        return view('Student.enrolledCoursePage',[
            'singleCourseDetails' => $courseDetails,
        ]);
    }

    
    
}
