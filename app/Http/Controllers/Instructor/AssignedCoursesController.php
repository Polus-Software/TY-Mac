<?php

namespace App\Http\Controllers\Instructor;

use App\Models\CustomTimezone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\UserType;
use App\Models\AssignedCourse;
use App\Models\CourseCategory;
use App\Models\EnrolledCourse;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Models\LiveSession;
use App\Models\GeneralCourseFeedback;
use App\Models\CohortBatch;
use Illuminate\Support\Facades\Storage;
use Response;
use File;
use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;




class AssignedCoursesController extends Controller
{
    public function viewAssignedCourses(){
        
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
       return view('Instructor.assignedCourses', [
         'singleEnrolledCourseData' => $singleEnrolledCourseData,
         'upComingSessionDetails' => $upComingSessionDetails,
         'liveSessionDetails' => $liveSessionDetails,
       ]);
     } else {
       return redirect('/student-courses');
     }
   }

    public function viewStudentList(Request $request, $id){

        $studentLists =[];
        $enrolled = EnrolledCourse::where('course_id',$id)->get();
        $user = Auth::user();
        if($user){
        $userType =  UserType::find($user->role_id)->user_role;
        foreach($enrolled as $enroll){

            $userId = $enroll->user_id;
            $studentFirstName = user::where('id', $userId)->value('firstname');
            $studentLastName = user::where('id', $userId)->value('lastname');
            $studentEmail = user::where('id', $userId)->value('email');
            $studentProfile = user::where('id', $userId)->value('image');

            array_push($studentLists, array(
                'userId' => $userId,
                'student_firstname' => $studentFirstName,
                'student_lastname' => $studentLastName,
                'student_email' => $studentEmail,
                'student_profile' => $studentProfile
             ));
        }
        return view('Instructor.studentList',[
            'studentLists' =>$studentLists,
            'userType' =>  $userType
        ]);
    }else{
        return redirect('/403');
    }

    }


    public function ViewCourseContent($id){

       $courseContents = [];
       $topics = Topic::where('course_id', $id)->get();
       $user = Auth::user();
       if($user){
       $userType =  UserType::find($user->role_id)->user_role;

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
        return view('Instructor.viewCourseContent',[
            'courseContents' => $courseContents,
            'userType' =>  $userType,
        ]);
    }else{
        return redirect('/403');
    }
    }


    public function downloadStudyMaterial($topic_content_id){
        $attachment_name = TopicContent::where('topic_content_id', $topic_content_id)->value('document');

        if(Storage::disk('downloads')->exists("study_material/$attachment_name")) {
            $absolutePath = Storage::disk('downloads')->path("study_material/$attachment_name");
            $content = file_get_contents($absolutePath);
            ob_end_clean();
        
            $headers = [
                'Content-type' =>  mime_content_type($absolutePath), 
                'Content-Disposition' => sprintf('attachment; filename="%s"', $attachment_name)
            ];

            return Response::make($content, 200, $headers);
        }
        return redirect('/404');
        
        }


        public function chooseCohort(Request $request){

            $user = Auth::user();
            $singleCourseDetails =[];
            $course = Course::findOrFail($request->id);
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
         
            return view('Instructor.cohortSelection', [
                'singleCourseDetails' => $singleCourseDetails,
                'courseDetails' => $courseDetails
            ]);
    
        }
}
