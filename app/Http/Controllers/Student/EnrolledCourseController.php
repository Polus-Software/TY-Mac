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
use Illuminate\Database\Eloquent\Collection;
use Response;
use App\Models\Assignment;
use App\Models\StudentAchievement;
use App\Models\AchievementBadge;
use PDF;


class EnrolledCourseController extends Controller
{
    public function afterEnrollView(Request $request){


        $courseDetails =[];
        $topicDetails = [];
        $achievedBadgeDetails = [];
        $badgesDetails = [];
        $allBadges = [];
        $badgeComparisonArray = [];
        $upcoming = [];
        $courseId = $request->course_id;
        $course = Course::findOrFail($courseId);
        $user =Auth::user();

        if($user){

        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructor = User::where('id', $assigned);
        $instructorfirstname = $instructor->value('firstname');
        $instructorlastname = $instructor->value('lastname');
        $profilePhoto = $instructor->value('image');
        $instructorDesignation = $instructor->value('designation');
        $instructorInstitute = $instructor->value('institute');
        $instructorDescription = $instructor->value('description');
        $instructorTwitter = $instructor->value('twitter_social');
        $instructorLinkedin =$instructor->value('linkedIn_social');
        $instructorYoutube = $instructor->value('youtube_social');
    
        $achievements = StudentAchievement::where('student_id', $user->id)->get();

        foreach($achievements as $achievement){

            $achievementBadge = AchievementBadge::where('id' , $achievement->badge_id);
            $badge_name = $achievementBadge->value('title');
            $badge_image = $achievementBadge->value('image');
            $badge_created_at =  StudentAchievement::where('badge_id', $achievement->badge_id)->value('created_at');
   
            array_push($badgeComparisonArray, $achievement->badge_id);

        array_push($achievedBadgeDetails, array(
            'id'=> $achievement->badge_id,
            'badge_name' =>  $badge_name,
            'badge_image' => $badge_image,
            'badge_created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $badge_created_at)->format('F d, Y'),
        ));
        }

        $achievementBadges = AchievementBadge::all(); 

        foreach($achievementBadges as $badge){
            $badge_id = $badge->id;
            $badge_name = $badge->title;
            $badge_description = $badge->description;
            $badge_image = $badge->image;

            array_push($allBadges, $badge_id);

            array_push($badgesDetails, array(
                'id' => $badge_id,
                'badge_name' => $badge_name,
                'badge_description' => $badge_description,
                'badge_image' => $badge_image
            ));
        }

        $upcomingBadges = array_diff($allBadges, $badgeComparisonArray);

        foreach($upcomingBadges as $badges) {

            $achievementBadge = AchievementBadge::where('id' , $badges);
            $badge_name = $achievementBadge->value('title');
            $badge_image = $achievementBadge->value('image');
            //$badge_created_at = StudentAchievement::where('badge_id', $badges)->value('created_at');
        
            array_push($upcoming, array(
                'id'=> $badges,
                'badge_name' =>  $badge_name,
                'badge_image' => $badge_image,
                
            ));
        }

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
            'topicDetails' =>  $topicDetails,
            'achievedBadgeDetails' => $achievedBadgeDetails,
            'badgesDetails' => $badgesDetails,
            'upcoming' => $upcoming
        ]);

    }else{
        return redirect('/403');
    }
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
       

        $user = Auth::user();
        $userId = $user->id;

        $assignementFile = $request->assignment_answer->getClientOriginalName();
        $topic_assignment_id = $request->topic_assignment_id;

        $assignments = Assignment::where('student_id' , $userId)
                                  ->where('topic_assignment_id', $topic_assignment_id)->get();
      
                           
        if(count($assignments) == 0){

        $request->assignment_answer->storeAs('assignmentAnswers', $assignementFile,'public');
        $topicAssignment = TopicAssignment::where('id', $topic_assignment_id);
        $courseId = $topicAssignment->value('course_id');
        $instructorId = $topicAssignment->value('instructor_id');
        $topicId = $topicAssignment->value('topic_id');
        
        $assignment = new Assignment;
        $assignment->assignment_answer = $assignementFile;
        $assignment->topic_assignment_id = $topic_assignment_id;
        $assignment->student_id = $userId;
        $assignment->course_id = $courseId;
        $assignment->instructor_id = $instructorId;
        $assignment->topic_id = $topicId;
        $assignment->is_submitted = true;
        $assignment->save();

        $badgeId = AchievementBadge::where('title', 'Assignment')->value('id');

        $student_achievement = new StudentAchievement;
        $student_achievement->student_id = $userId;
        $student_achievement->badge_id =  $badgeId;
        $student_achievement->is_achieved = true;
        $student_achievement->save();

        return redirect()->back();
        }
    
    }

    public function generateCertificate($id){

    $courseDetails = [];
    $course= Course::findOrFail($id);    
    $user = Auth::user();
    $student_firstname = $user->firstname;
    $student_lastname = $user->lastname;

    if($user){

    $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');

    $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
    $instructor = User::where('id', $assigned);
    $instructorfirstname = $instructor->value('firstname');
    $instructorlastname = $instructor->value('lastname');
    $instructorSignature = $instructor->value('signature');
    $date_of_issue = Carbon::now();
  
  $image = Storage::url('signatures/'.$instructorSignature); 
  $absolutePath = Storage::disk('downloads')->path("signatures/$instructorSignature");

    $singleCourseData =  array (
        'id' => $course->id,
        'course_title' => $course->course_title,
        'course_category' => $courseCategory,
        'instructor_firstname' => $instructorfirstname,
        'instructor_lastname' => $instructorlastname,
        'instructor_signature' => $instructorSignature,
        'student_firstname' =>$student_firstname,
        'student_lastname' =>$student_lastname,
        'date_of_issue' => Carbon::createFromFormat('Y-m-d H:i:s', $date_of_issue)->format('F d, Y'),
    );
      
    array_push($courseDetails, $singleCourseData);

    view()->share('p', $courseDetails);

    $pdf_doc = PDF::loadView('Student.certificate',['courseDetails' => $courseDetails])
               ->setOptions(['defaultFont' =>'sans-serif', 'chroot' => public_path()]);

    return $pdf_doc->stream($course->course_title.'Certificate.pdf');

    }else{
        return redirect('/403');
    }
    }

}