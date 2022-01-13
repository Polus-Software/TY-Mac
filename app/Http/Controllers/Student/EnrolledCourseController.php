<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\AssignedCourse;
use App\Models\UserType;
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
use App\Models\CohortBatch;
use PDF;
use SnappyImage;
use App\Models\StudentFeedbackCount;
use App\Models\CourseQA;
use App\Models\EnrolledCourse;
use App\Models\AttendanceTracker;
use App\Models\LiveSession;

class EnrolledCourseController extends Controller
{
    public function afterEnrollView(Request $request, $courseId) {
        
       
        $courseDetails =[];
        $topicDetails = [];
        $achievedBadgeDetails = [];
        $badgesDetails = [];
        $allBadges = [];
        $badgeComparisonArray = [];
        $upcoming = [];
        $singleRec = [];
        $finalRec = [];
        $qaArray = [];
        $next_live_cohort = '';
        $course = Course::findOrFail($courseId);
        $user =Auth::user();
        $userType = "";
        $attendedTopics = 0;
        $progress = 0;
        
        if($user){
        $attendanceRecs = AttendanceTracker::where('student', $user->id)->get();
        $topics = Topic::where('course_id', $courseId)->get();
        $totalTopics = count($topics);
        foreach($attendanceRecs as $attendanceRec) {
            $liveSessionId = $attendance->value('live_session_id');

            $sessionCourse = LiveSession::where('live_session_id', $liveSessionId);

            if($sessionCourse == $courseId) {
                $attendedTopics = $attendedTopics + 1;
            }
        }

        
       
        
        $currentUserRoleId = User::where('id', $user->id)->value('role_id');
        $userType = Usertype::where('id', $currentUserRoleId)->value('user_role');
        $student_firstname = $user->firstname;
        $student_lastname = $user->lastname;
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
        $instructorSignature = $instructor->value('signature');
        $date_of_issue = Carbon::now();
        $current_date = Carbon::now()->format('Y-m-d');
       
       $batches = CohortBatch::where('course_id', $courseId)->where('start_date', '>', $current_date)->orderBy('start_date')->get();
       $next_live_cohort = "";
       if(count($batches)) {
        $start_date = Carbon::createFromFormat('Y-m-d',$batches[0]->start_date)->format('m/d/Y');
        $start_time = Carbon::createFromFormat('H:i:s',$batches[0]->start_time)->format('h A');
        $end_time = Carbon::createFromFormat('H:i:s',$batches[0]->start_time)->format('h A');
 
        $next_live_cohort = $start_date . '- ' . $start_time . ' ' .$batches[0]->value('time_zone') . ' - ' . $end_time . ' ' . $batches[0]->value('time_zone');
       
       } 

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
                $topicContents = TopicContent::where('topic_id', $topicId)->get();
                $assignmentsArray = TopicAssignment::where('topic_id', array($topicId))->get();
                $liveSession = LiveSession::where('topic_id', $topicId);
                $liveId = null;
                if($liveSession) {
                    $liveId = $liveSession->value('live_session_id');
                }
                $assignmentList = $assignmentsArray->toArray();
    
                array_push($topicDetails, array(
                    'liveId' => $liveId,
                    'topic_id' => $topicId,
                    'topic_title' =>$topic_title,
                    'topic_content' => $topicContents,
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
            'instructor_signature' => $instructorSignature,
            'student_firstname' =>$student_firstname,
            'student_lastname' =>$student_lastname,
            'date_of_issue' => Carbon::createFromFormat('Y-m-d H:i:s', $date_of_issue)->format('F d, Y'),
        );

        array_push($courseDetails, $singleCourseData);

        $studentFeedbackCounts = StudentFeedbackCount::where('course_id', $courseId)->get();
        
        foreach($studentFeedbackCounts as $feedback) {
            if($feedback->value('negative') == 1) {
                $topicId = $feedback->topic_id;
                $topic = Topic::where('topic_id',  $topicId);
                $contentId = $feedback->content_id;
                $content = TopicContent::where('topic_content_id',  $contentId);

                $singleRec = array(
                    'content_id' => $contentId,
                    'content_title' => $content->value('topic_title'),
                    'topic_id' => $topicId,
                    'topic_title' => $topic->value('topic_title'),
                    'student_id' => $feedback->value('student'),
                    'likes' => $feedback->value('positive'),
                    'dislikes' => $feedback->value('negative')
                );

                array_push($finalRec, $singleRec);
            }
        }

        $qas = CourseQA::where('course_id', $courseId)->get();

        foreach($qas as $qa) {
            $student = User::where('id', $qa->student);
            $instructor = User::where('id', $qa->instructor);
            $instructorName = $instructor->value('firstname') . ' ' . $instructor->value('lastname');
            $studentName = $student->value('firstname') . ' ' . $student->value('lastname');
            $question = $qa->question;
            $reply = $qa->reply;
            $hasReplied = $qa->has_replied;
            $date = $qa->created_at->format('d M H:m');
            array_push($qaArray, array(
                'id' => $qa->id,
                'student' => $studentName,
                'instructor' => $instructorName,
                'question' => $question,
                'reply' => $reply,
                'hasReplied' => $hasReplied,
                'date' => $date
            ));
        }
        if($userType === 'student') {
            return view('Student.enrolledCoursePage',[
                'singleCourseDetails' => $courseDetails,
                'topicDetails' =>  $topicDetails,
                'achievedBadgeDetails' => $achievedBadgeDetails,
                'badgesDetails' => $badgesDetails,
                'upcoming' => $upcoming,
                'recommendations' => $finalRec,
                'qas' => $qaArray,
                'userType' => $userType,
                'next_live_cohort' =>  $next_live_cohort,
                'progress' => ($attendedTopics / $totalTopics) * 100
            ]);
        }
        
        if($userType === 'instructor') {
            $recommendations = $this->instructorRecommendations($courseId);
            return view('Student.enrolledCoursePage',[
                'singleCourseDetails' => $courseDetails,
                'topicDetails' =>  $topicDetails,
                'recommendations' => $recommendations,
                'userType' => $userType,
                'studentsEnrolled' => $this->studentsEnrolled($courseId),
                'next_live_cohort' =>  $next_live_cohort,
                'qas' => $qaArray,
                'progress' => $progress
            ]);
        }      

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

                $singleCourseData =  array(
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
                $pdf = PDF::loadView('Student.certificate', ['courseDetails' => $courseDetails])->setOption('enable-local-file-access', true);
                return $pdf->stream($course->course_title.'Certificate.pdf');
        }

    }


    private function studentsEnrolled($courseId) {
        $studentsEnrolled = DB::table('enrolled_courses as a')
                            ->join('users as b', 'a.user_id', '=', 'b.id')
                            ->where('a.course_id', $courseId)
                            ->get();
        return $studentsEnrolled;
    }

    private function instructorRecommendations($courseId) {
        $singleRecommendation = [];
        $finalRecommendation = [];
        $studentsEnrolled = $this->studentsEnrolled($courseId);
        foreach($studentsEnrolled as $student) {
            $student_name = User::where('id', $student->user_id)->get();
            $studentFeedbackCounts = StudentFeedbackCount::where('course_id', $courseId)->where('student', $student->user_id)->get();
            foreach($studentFeedbackCounts as $feedback) {
                if($feedback->value('negative') > $feedback->value('positive')) {
                    $topicId = $feedback->topic_id;
                    $topic = Topic::where('topic_id',  $topicId);
                    $contentId = $feedback->content_id;
                    $content = TopicContent::where('topic_content_id',  $contentId);                    
                    $singleRecommendation = array(
                        'content_id' => $contentId,
                        'content_title' => $content->value('topic_title'),
                        'topic_id' => $topicId,
                        'topic_title' => $topic->value('topic_title'),
                        'student_id' => $feedback->value('student'),
                        'likes' => $feedback->value('positive'),
                        'dislikes' => $feedback->value('negative')
                    );
    
                    array_push($finalRecommendation, $singleRecommendation);
                }
            }
        }
        return $finalRecommendation;
    }

    public function replyToStudent(Request $request) {
        $qaId = $request->qaId;
        $reply = $request->replyContent;

        $courseQA = CourseQA::find($qaId);
        $courseQA->reply = $reply;
        $courseQA->has_replied = true;
        $updatedAt = $courseQA->updated_at->format('d M H:m');
        $courseQA->save();

        return response()->json([
            'status' => 'success',
            'reply' => $reply, 
            'updatedAt' => $updatedAt,
            'message' => 'Replied successfully'
         ]);
    }

    public function askQuestion(Request $request) {
        $question = $request->question;
        $course_id = $request->course_id;
        $student = 0;

        $qa = new CourseQA;
        $qa->course_id = $course_id;
        $instructor = AssignedCourse::where('course_id', intval($course_id))->value('user_id');
        
        $user =Auth::user();
        if($user) {
            $student = User::where('id', $user->id)->value('id');
            
            
            $badgeId = AchievementBadge::where('title', 'Q&A')->value('id');
            $achievementCheck = StudentAchievement::where('student_id', $user->id)->where('badge_id', $badgeId)->count();
            
            if(!$achievementCheck) {
                $student_achievement = new StudentAchievement;
                $student_achievement->student_id = $user->id;
                $student_achievement->badge_id =  $badgeId;
                $student_achievement->is_achieved = true;
                $student_achievement->save();
            }
            
        }

        $qa->student = $student;
        $qa->instructor = $instructor;
        $qa->question = $question;
        $qa->has_replied = false;

        $qa->save();

        return response()->json(['status' => 'success', 'msg' => 'Saved successfully!']);

    }

}
