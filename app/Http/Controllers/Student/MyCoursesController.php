<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\CourseCategory;
use App\Models\EnrolledCourse;
use App\Models\LiveSession;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\CohortBatch;

class MyCoursesController extends Controller
{
    public function showMyCourses(){
      
       $singleEnrolledCourseData = [];
       $liveSessionDetails = [];
       $upComingSessionDetails = [];
       $user = Auth::user();
       if($user){
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

          $cohort_batches = DB::table('cohort_batches')->where('id', $enrolledCourse->batch_id);
          $start_date =  $cohort_batches->value('start_date');
          $start_time =  $cohort_batches->value('start_time');
          $end_time =  $cohort_batches->value('end_time');
          $time_zone = $cohort_batches->value('time_zone');
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
            'start_date' => Carbon::parse($start_date)->format('m/d/Y'),
            'start_time' =>Carbon::createFromFormat('H:i:s',$start_time)->format('h A'),
            'end_time' =>Carbon::createFromFormat('H:i:s',$end_time)->format('h A'),
            'time_zone' => $time_zone,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'progress' => (!is_null($progress)) ? $progress : 0
          );
        array_push($singleEnrolledCourseData, $enrolledCourseData);
      }


            $liveSessions = LiveSession::all();
            $current_date = Carbon::now()->format('Y-m-d');
           
            foreach($liveSessions as $session) {
               
                $batchId = $session->batch_id;
                $batch = CohortBatch::where('id', $batchId);

                $currentBatchStartDate = $batch->value('start_date');

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
                        'date' => $date
                    ));
                } elseif ($currentBatchStartDate == $current_date) {
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
                        'date' => $date
                    ));
                }
            }
            
      return view('Student.myCourses', [
        'singleEnrolledCourseData' => $singleEnrolledCourseData,
        'upComingSessionDetails' => $upComingSessionDetails,
        'liveSessionDetails' => $liveSessionDetails,
      ]);
    } else {
      return redirect('/student-courses');
    }
  }
 
}
