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
use App\Models\CustomTimezone;
use DateTime;
use DateTimeZone;

class MyCoursesController extends Controller
{
    public function showMyCourses(Request $request){
	   $singleEnrolledCourseData = [];
       $liveSessionDetails = [];
       $upComingSessionDetails = [];
       $user = Auth::user();
       
       if($user){
        $current_date = Carbon::createFromFormat('Y-m-d', Carbon::now()->format('Y-m-d'), 'UTC')->setTimezone($user->timezone)->format('Y-m-d');
      if($request->courses && $request->courses == 1){
        $filter_course = 'completed';
        $enrolledCourses = EnrolledCourse::where('user_id', $user->id)->where('progress','=', 100)->get();
      } elseif($request->courses && $request->courses == 2) {
        $filter_course = 'most-popular';
        $enrolledCourses = EnrolledCourse::where('user_id', $user->id)->get();
      } else {
        $filter_course = 'most-popular';
        $enrolledCourses = EnrolledCourse::where('user_id', $user->id)->where('progress','<', 100)->get();
      }
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
            if($cohort_batches[0]->end_time < Carbon::now()->format('H:i:s')) {
              if(!isset($cohort_batches[1])) {
                $nextCohort = "All sessions have ended!";
              } else {
                $cohort_batches = $cohort_batches[1];

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
              }
              
            } else {
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
            }
                
                
            
                
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

            
      return view('Student.myCourses', [
        'singleEnrolledCourseData' => $singleEnrolledCourseData,
        'upComingSessionDetails' => $upComingSessionDetails,
        'liveSessionDetails' => $liveSessionDetails,
		    'filter_course'=>$filter_course
      ]);
    } else {
      return redirect('/student-courses');
    }
  }
 
}
