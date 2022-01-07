<?php

namespace App\Http\Controllers\Instructor;

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
use App\Models\CohortBatch;
use Illuminate\Support\Facades\Storage;
use Response;
use File;
use Closure;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;




class AssignedCoursesController extends Controller
{
    public function viewAssignedCourses(){
        
        $singleEnrolledCourseData = [];
        $liveSessionDetails = [];
        $upComingSessionDetails = [];
        $user = Auth::user();
        if($user){
         $enrolledCourses = AssignedCourse::where('user_id', $user->id)->get();
         foreach($enrolledCourses as $enrolledCourse){
 
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
           
           $enrolledCourseData = array(
             'course_id' => $courseId,
             'course_title' =>  $course_title,
             'description' => $description,
             'category_name' => $courseCategory,
             'course_difficulty' => $course_difficulty,
             'course_image' => $course_image,
             'start_date' => Carbon::parse($start_date)->format('m/d/Y'),
            //  'start_time' =>Carbon::createFromFormat('H:i:s',$start_time)->format('h A'),
            //  'end_time' =>Carbon::createFromFormat('H:i:s',$end_time)->format('h A'),
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
 
                 $currentBatchStartDate = $batch->value('start_date');
 
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
                         'enrolledCourses' => $enrolledCourses,
                         'date' => $date
                     ));
                 } elseif ($currentBatchStartDate == $current_date) {
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
                         'enrolledCourses' => $enrolledCourses,
                         'date' => $date
                     ));
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

    public function viewStudentList($id){

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

}

