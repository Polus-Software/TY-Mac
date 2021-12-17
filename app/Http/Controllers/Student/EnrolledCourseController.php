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
use App\Models\GeneralCourseFeedback;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Models\TopicAssignment;
use Illuminate\Support\Facades\Storage;
use Response;
use App\Models\Assignment;

class EnrolledCourseController extends Controller
{
    public function afterEnrollView(Request $request){


        $courseDetails =[];
        $topicDetails = [];
        $courseId = $request->course_id;
        $course = Course::findOrFail($courseId);
 
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');
        $profilePhoto = User::where('id', $assigned)->value('image');
        $instructorDesignation = User::where('id', $assigned)->value('designation');
        $instructorInstitute = User::where('id', $assigned)->value('institute');
        $instructorDescription = User::where('id', $assigned)->value('description');
        $instructorTwitter = User::where('id', $assigned)->value('twitter_social');
        $instructorLinkedin = User::where('id', $assigned)->value('linkedIn_social');
        $instructorYoutube = User::where('id', $assigned)->value('youtube_social');
    
        $topics = Topic::where('course_id',  $courseId)->get();

        foreach($topics as $topic){

            $courseId =  $topic->course_id;
            $topicId = $topic->topic_id;
            $topic_title =  $topic->topic_title;
            $assignmentsArray = TopicAssignment::where('topic_id', array($topicId))->get();
            $assignmentList = $assignmentsArray->toArray();
 
            array_push($topicDetails, array(
                'topic_id' => $topicId,
                'topic_title' =>$topic_title,
                'assignmentList'=> $assignmentList
            ));
        }
 
        $singleCourseData =  array (
            'id' => $course->id,
            'course_title' => $course->course_title,
            'course_category' => $courseCategory,
            'description' => $course->description,
            'course_difficulty' => $course->course_difficulty,
            'course_details' => $course->course_details,
            'course_thumbnail_image' => $course->course_thumbnail_image,
            'instructor_firstname' => $instructorfirstname,
            'instructor_lastname' => $instructorlastname,
            'profile_photo' => $profilePhoto,
            'designation' => $instructorDesignation,
            'institute' => $instructorInstitute,
            'instructorDescription' => $instructorDescription,
            'instructorTwitter' => $instructorTwitter,
            'instructorLinkedin' => $instructorLinkedin,
            'instructorYoutube' => $instructorYoutube,
        );

        array_push($courseDetails, $singleCourseData);

        return view('Student.enrolledCoursePage',[
            'singleCourseDetails' => $courseDetails,
            'topicDetails' =>  $topicDetails
        ]);
    }

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
   
    public function showassignment($id){
        $assignments= TopicAssignment::where('id' , $id)->get();
       
        return view('Student.assignmentDetails',[
           'assignments'=> $assignments
        ]);
    }

    public function downloadAssignmentDocument($id){
       
       $attachment_name = TopicAssignment::where('id', $id)->value('document');

        if(Storage::disk('downloads')->exists("assignmentAttachments/$attachment_name")) {
            $absolutePath = Storage::disk('downloads')->path("assignmentAttachments/$attachment_name");
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

    public function submitAssignment(Request $request){

    $assignementFile = $request->assignment_answer->getClientOriginalName();
    $topic_assignment_id = $request->topic_assignment_id;
    
     //dd($topic_id);
    $request->assignment_answer->storeAs('assignmentAnswers', $assignementFile,'public');
    $user = Auth::user();
    $userId = $user->id;

    $courseId = TopicAssignment::where('id', $topic_assignment_id)->value('course_id');
    $instructorId = TopicAssignment::where('id', $topic_assignment_id)->value('instructor_id');
    $topicId = TopicAssignment::where('id', $topic_assignment_id)->value('topic_id');
    

    $assignment = new Assignment;
    $assignment->assignment_answer = $assignementFile;
    $assignment->topic_assignment_id = $topic_assignment_id;
    $assignment->student_id = $userId;
    $assignment->course_id = $courseId;
    $assignment->instructor_id = $instructorId;
    $assignment->topic_id = $topicId;
    $assignment->is_submitted = true;
    $assignment->save();
    return redirect()->back();
    
    }
}