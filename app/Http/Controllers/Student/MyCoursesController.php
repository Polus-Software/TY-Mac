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
use Carbon\Carbon;

class MyCoursesController extends Controller
{
    public function showMyCourses(){
        
       $singleEnrolledCourseData = [];
       $user = Auth::user();
       if($user){
        $enrolledCourses = EnrolledCourse::where('user_id', $user->id)->get();
        foreach($enrolledCourses as $enrolledCourse){

          $courseId = $enrolledCourse->course_id;
          $course_title = Course::where('id', $enrolledCourse->course_id)->value('course_title');
          $description = Course::where('id', $enrolledCourse->course_id)->value('description');
          $category_id = Course::where('id', $enrolledCourse->course_id)->value('category');
          $course_image = Course::where('id', $enrolledCourse->course_id)->value('course_image');
          $course_difficulty = Course::where('id', $enrolledCourse->course_id)->value('course_difficulty');
          $courseCategory = CourseCategory::where('id', $category_id)->value('category_name');
          $start_date = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_date');
          $start_time = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('start_time');
          $end_time = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id)->value('end_time');
          $assigned = DB::table('assigned_courses')->where('course_id', $enrolledCourse->course_id)->value('user_id');
          $instructorfirstname = User::where('id', $assigned)->value('firstname');
          $instructorlastname = User::where('id', $assigned)->value('lastname');

          $enrolledCourseData = array(
            'course_id' => $courseId,
            'course_title' =>  $course_title,
            'description' => $description,
            'category_name' => $courseCategory,
            'course_difficulty' => $course_difficulty,
            'course_image' => $course_image,
            'start_date' => Carbon::parse($start_date)->format('m/d/Y'),
            'start_time' =>Carbon::createFromFormat('H:i:s',$start_time)->format('h A'),
            'end_time' =>Carbon::createFromFormat('H:i:s',$end_time)->format('h A'),
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
          );
        array_push($singleEnrolledCourseData, $enrolledCourseData);
      }
      return view('Student.myCourses', [
        'singleEnrolledCourseData' => $singleEnrolledCourseData
      ]);
    } else {
      return redirect('/student-courses');
    }
  }
 
}
