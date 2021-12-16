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
use Illuminate\Support\Facades\Storage;
use Response;
use File;
use Closure;




class AssignedCoursesController extends Controller
{
    public function viewAssignedCourses(){

        $assignedCourseData = [];
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
 
        $assigned = AssignedCourse::where('user_id', $user->id)->get();
        foreach($assigned as $assign){
           $course =  Course::where('id', $assign->course_id);
           $courseId = $course->value('id');
           $course_title = $course->value('course_title');
           $course_description = $course->value('description');
           $category = $course->value('category');
           $courseCategory = CourseCategory::where('id', $category)->value('category_name');
          
           $enrolled = EnrolledCourse::where('course_id',$courseId)->get();
           $enrolledCourseCount = count($enrolled);
        
           array_push($assignedCourseData, array(
               'id' => $courseId,
               'course_title' => $course_title,
               'description' => $course_description,
               'category' => $courseCategory,
               'enrolled_course_count' => $enrolledCourseCount
           ));
        }
        
        return view('Instructor.assignedCourses',[
            'assignedCourseData' => $assignedCourseData,
            'userType' =>  $userType
        ]);
    }

    public function viewStudentList($id){

        $studentLists =[];
        $enrolled = EnrolledCourse::where('course_id',$id)->get();
        $user = Auth::user();
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

    }


    public function ViewCourseContent($id){

       $courseContents = [];
       $topics = Topic::where('course_id', $id)->get();
       $user = Auth::user();
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
            'userType' =>  $userType
        ]);
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

