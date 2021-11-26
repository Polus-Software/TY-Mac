<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use App\Models\EnrolledCourse;
use Illuminate\Support\Facades\DB;

class MyCoursesController extends Controller
{
    public function showMyCourses(){
        
       $singleEnrolledCourseData = [];
       $user = Auth::user();
       //dd($user); 
       $enrolledCourses = EnrolledCourse::where('user_id', $user->id)->get();
       //dd($enrolledCourses);

      foreach($enrolledCourses as $enrolledCourse){

        $course_title = Course::where('id', $enrolledCourse->course_id)->value('course_title');
        $description = Course::where('id', $enrolledCourse->course_id)->value('description');
        $categoryId = Course::where('id', $enrolledCourse->course_id)->value('category');
        $course_difficult = Course::where('id', $enrolledCourse->course_id)->value('course_difficulty');
        $courseCategory = CourseCategory::where('id', $categoryId)->value('category_name');
        $start_date = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_date');
        $start_time = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_time');
        $end_time = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_time');
        //dd($start_date);
        $assigned = DB::table('assigned_courses')->where('course_id', $enrolledCourse->course_id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');

 $enrolledCourseData = array(
     'course_title' =>  $course_title,
     'description' => $description,


 );
 //dd($enrolledCourseData);
        
      }
      
      //dd($instructorfirstname);

      return view('Student.myCourses');
    }
}
