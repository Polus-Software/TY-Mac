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
        
        $selectedBatch = $request->batchId;
        
        $courseDetails =[];
        $topicDetails = [];
        $liveIdArr = [];
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
            $liveSessionId = $attendanceRec->value('live_session_id');

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
        $next_live_cohort = "No sessions scheduled";
        $course_completion = '';
        if($userType === 'instructor') {
             $selectedBatchObj = CohortBatch::where('id', $selectedBatch);

             $occurrences = $selectedBatchObj->value('occurrence');
             $occArr = explode(',', $occurrences);
 
             $startDate = $selectedBatchObj->value('start_date');
             $endDate = $selectedBatchObj->value('end_date');
             $batchStartTime = $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'));
         
             if($startDate < $current_date && $current_date < $endDate) {
                 while($startDate < $endDate) {
                     $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
                     if($startDate >= $current_date && in_array(Carbon::createFromFormat('Y-m-d',$startDate)->format('l'), $occArr)) {
                         $latestDate = $startDate;
                         $start_date = Carbon::createFromFormat('Y-m-d',$latestDate)->format('m/d/Y');
                         $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'))->format('h:m A');
                         $end_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('end_time'))->format('h:m A');
                         $next_live_cohort = $start_date . '- ' . $start_time . ' ' .$selectedBatchObj->value('time_zone') . ' - ' . $end_time . ' ' . $selectedBatchObj->value('time_zone');
                         break;
                     }   
                 }
                 
             } else if($startDate >= $current_date) {
                 $latestDate = $startDate;
                 $start_date = Carbon::createFromFormat('Y-m-d',$latestDate)->format('m/d/Y');
                 $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'))->format('h:m A');
                 $end_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('end_time'))->format('h:m A');
                 $next_live_cohort = $start_date . '- ' . $start_time . ' ' .$selectedBatchObj->value('time_zone') . ' - ' . $end_time . ' ' . $selectedBatchObj->value('time_zone');
             } else {
                $next_live_cohort = "This batch has ended";
             }
             
             
             
        } else if($userType === 'student') {
            $enrolledCourseObj = EnrolledCourse::where('user_id', $user->id);
            if($enrolledCourseObj->value('course_completion_date') != null) {
                $course_completion = Carbon::createFromFormat('Y-m-d H:i:s', $enrolledCourseObj->value('course_completion_date'))->format('F d, Y');
            }
            
            
            $selectedBatchObj = CohortBatch::where('id', $enrolledCourseObj->value('batch_id'));
            $occurrences = $selectedBatchObj->value('occurrence');
            $occArr = explode(',', $occurrences);

            $startDate = $selectedBatchObj->value('start_date');
            $endDate = $selectedBatchObj->value('end_date');
            $batchStartTime = $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'));
        
            if($startDate < $current_date && $endDate > $current_date) {
                while($startDate < $endDate) {
                    $startDate = date('Y-m-d',strtotime($startDate . "+1 days"));
                    if($startDate >= $current_date && in_array(Carbon::createFromFormat('Y-m-d',$startDate)->format('l'), $occArr)) {
                        $latestDate = $startDate;
                        $start_date = Carbon::createFromFormat('Y-m-d',$latestDate)->format('m/d/Y');
                        $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'))->format('h:m A');
                        $end_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('end_time'))->format('h:m A');
                        $next_live_cohort = $start_date . '- ' . $start_time . ' ' .$selectedBatchObj->value('time_zone') . ' - ' . $end_time . ' ' . $selectedBatchObj->value('time_zone');
                        break;
                    }   
                }
                
            } else if($startDate >= $current_date) {
                $latestDate = $startDate;
                $start_date = Carbon::createFromFormat('Y-m-d',$latestDate)->format('m/d/Y');
                $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'))->format('h:m A');
                $end_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('end_time'))->format('h:m A');
                $next_live_cohort = $start_date . '- ' . $start_time . ' ' .$selectedBatchObj->value('time_zone') . ' - ' . $end_time . ' ' . $selectedBatchObj->value('time_zone');
            } else {
                $next_live_cohort = "This batch has ended";
            }
        } else {
            return false;
        }
           
            
       
       

    //    if(count($batches)) {
    //     $start_date = Carbon::createFromFormat('Y-m-d',$batches[0]->start_date)->format('m/d/Y');
    //     $start_time = Carbon::createFromFormat('H:i:s',$batches[0]->start_time)->format('h:m A');
    //     $end_time = Carbon::createFromFormat('H:i:s',$batches[0]->end_time)->format('h:m A');
 
    //     $next_live_cohort = $start_date . '- ' . $start_time . ' ' .$batches[0]->value('time_zone') . ' - ' . $end_time . ' ' . $batches[0]->value('time_zone');
       
    //    } 

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
                $liveSessions = LiveSession::where('topic_id', $topicId)->get();
                $startDate = "";
                $startTime = "";
                $endTime = "";
                $time_zone = "";
                $liveId = null;
                foreach($liveSessions as $liveSession) {
                    $batch = CohortBatch::where('id', $liveSession->batch_id);
                    $occurrence = $batch->value('occurrence');
                    $startDate = $batch->value('start_date');
                    $startTime = $batch->value('start_time');
                    $endTime = $batch->value('end_time');
                    $endDate = $batch->value('end_date');
                    $time_zone = $batch->value('time_zone');
                    $occurrenceArr = explode(',', $occurrence);
                    $checkDay = in_array(date("l"), $occurrenceArr);
                    if(date("Y-m-d") >= $startDate && date("Y-m-d") <= $endDate && $checkDay == true) {
                        
                        $liveId = $liveSession->live_session_id;
                    }else if(date("Y-m-d") < $startDate && $checkDay == true) {
                        $liveId = Null;
                    }else if(date("Y-m-d") > $endDate && $checkDay == true) {
                        $liveId = "Over";
                    }
                }
                
                $assignmentList = $assignmentsArray->toArray();
                $isAssignmentSubmitted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->where('is_submitted', true)->count() ? true : false;
                $isAssignmentCompleted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->where('is_submitted', true)->where('is_completed', true)->count() ? true : false;
                $isAssignmentStarted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->count() ? true : false;

                array_push($topicDetails, array(
                    'liveSessions' => $liveSessions,
                    'liveId' => $liveId,
                    'startDate' => $startDate,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'time_zone' => $time_zone,
                    'topic_id' => $topicId,
                    'topic_title' =>$topic_title,
                    'topic_content' => $topicContents,
                    'assignmentList'=> $assignmentList,
                    'isAssignmentSubmitted' => $isAssignmentSubmitted,
                    'isAssignmentCompleted' => $isAssignmentCompleted,
                    'isAssignmentStarted' => $isAssignmentStarted
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

        $studentFeedbackCounts = StudentFeedbackCount::where('course_id', $courseId)->where('student', $user->id)->get();
        
        foreach($studentFeedbackCounts as $feedback) {
            if($feedback->negative == 1) {
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
        
        $qas = CourseQA::where('course_id', $courseId)->orderBy('created_at', 'desc')->get();
        
        foreach($qas as $qa) {
            $student = User::where('id', $qa->student);
            $instructor = User::where('id', $qa->instructor);
            $instructorName = $instructor->value('firstname') . ' ' . $instructor->value('lastname');
            $studentName = $student->value('firstname') . ' ' . $student->value('lastname');
            $student_profile_photo = $student->value('image');
            $question = $qa->question;
            $reply = $qa->reply;
            $hasReplied = $qa->has_replied;
            $date = $qa->created_at;
            array_push($qaArray, array(
                'id' => $qa->id,
                'student' => $studentName,
                'instructor' => $instructorName,
                'student_profile_photo' => $student_profile_photo,
                'question' => $question,
                'reply' => $reply,
                'hasReplied' => $hasReplied,
                'date' => Carbon::parse($date)->diffForHumans(),
            ));
        }
        
        $progress = EnrolledCourse::where('user_id', $user->id)->where('course_id', $courseId)->value('progress');
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
                'progress' => $progress,
                'course_completion' => $course_completion
            ]);
        }
        
        if($userType === 'instructor') {
            $assignmentArr = [];
            $assignments = TopicAssignment::where('course_id', $courseId)->get();
            $assignmentCount = count($assignments);

            $students = $this->studentsEnrolled($courseId, $selectedBatch);
            foreach($students as $student){
                $assignmentStatus = [];
                $studentName = $student->firstname . ' ' . $student->lastname;
                $studentImg = $student->image;
                $batchName = CohortBatch::where('id', $selectedBatch)->value('batchname');
                foreach($assignments as $assignment) {
                    $status = "Submitted";
                    $stuAssignment = "";
                    $studentAssignment = Assignment::where('student_id' , $student->id)->where('topic_assignment_id', $assignment->id)->get();
                    if(count($studentAssignment) == 0) {
                        $status = "Pending";  
                    } elseif($studentAssignment[0]->is_completed == true) {
                        $status = "Completed";
                        $stuAssignment = $studentAssignment[0]->assignment_id;
                    } else {
                        $stuAssignment = $studentAssignment[0]->assignment_id;
                    }

                    array_push($assignmentStatus, array(
                        'status' => $status,
                        'assignment_id' => $assignment->id,
                        'stuAssignment' => $stuAssignment
                    ));
                }
                
                array_push($assignmentArr, array(
                    'studentImg' => $studentImg,
                    'student_name' => $studentName,
                    'batch_name' => $batchName,
                    'assignment_data' => $assignmentStatus
                ));
            }   
            $recommendations = $this->instructorRecommendations($courseId, $selectedBatch);
            $graph = $this->instructorGraph($courseId);
            return view('Student.enrolledCoursePage',[
                'singleCourseDetails' => $courseDetails,
                'topicDetails' =>  $topicDetails,
                'recommendations' => $recommendations,
                'userType' => $userType,
                'studentsEnrolled' => $this->studentsEnrolled($courseId, $selectedBatch),
                'next_live_cohort' =>  $next_live_cohort,
                'qas' => $qaArray,
                'progress' => $progress,
                'graph' => $graph,
                'selectedBatch' => $selectedBatch,
                'assignments' => $assignments,
                'assignmentArr' => $assignmentArr
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

    public function startAssignment(Request $request){
    

        $user = Auth::user();
        $userId = $user->id;

        $assignmentId = $request->assignment_id;


        $assignments = Assignment::where('student_id' , $userId)
                                  ->where('topic_assignment_id', $assignmentId)->get();
                               
                                  
        if(count($assignments) == 0){

        $topicAssignment = TopicAssignment::where('id', $assignmentId);
        $courseId = $topicAssignment->value('course_id');
        $instructorId = $topicAssignment->value('instructor_id');
        $topicId = $topicAssignment->value('topic_id');

        $assignment = new Assignment;

        $assignment->topic_assignment_id = $assignmentId;
        $assignment->student_id = $userId;
        $assignment->course_id = $courseId;
        $assignment->instructor_id = $instructorId;
        $assignment->topic_id = $topicId;
        $assignment->is_submitted = false;
        $assignment->save();
        }
        return response()->json([
            'status' => 'success', 
            'message' => 'submitted successfully'
         ]);
        
    }

    public function submitAssignment(Request $request){

        $user = Auth::user();
        $userId = $user->id;
        $topic_assignment_id = $request->assignment_id;
        $comment = $request->input('assignment_comment');
        
        $file = $request->assignment_upload;
        
        $assignementFile = $file->getClientOriginalName();
        $file->storeAs('assignmentAnswers', $assignementFile,'public');
        
        $assignment = Assignment::where('topic_assignment_id', $topic_assignment_id);
       
        $assignment->update(['assignment_answer' => $assignementFile, 'comment' => $comment, 'is_submitted' => true]);

        $badgeId = AchievementBadge::where('title', 'Assignment')->value('id');

        $student_achievement = new StudentAchievement;
        $student_achievement->student_id = $userId;
        $student_achievement->badge_id =  $badgeId;
        $student_achievement->is_achieved = true;
        $student_achievement->save();

        return redirect()->back();
    
    
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
                $pdf = PDF::loadView('Student.certificate', ['courseDetails' => $courseDetails])
                            ->setOption('enable-local-file-access', true)
                            ->setOrientation('landscape')
                            ->setOption('margin-top', 20);
                return $pdf->stream($course->course_title.'Certificate.pdf');
        }

    }


    private function studentsEnrolled($courseId, $batchId) {
        $studentsEnrolled = DB::table('enrolled_courses as a')
                            ->join('users as b', 'a.user_id', '=', 'b.id')
                            ->where('a.course_id', $courseId)
                            ->where('a.batch_id', $batchId)
                            ->get();
        return $studentsEnrolled;
    }

    private function instructorRecommendations($courseId, $batchId) {
        $singleRecommendation = [];
        $finalRecommendation = [];
        $studentsEnrolled = $this->studentsEnrolled($courseId, $batchId);
        foreach($studentsEnrolled as $student) {
            $student_name = User::where('id', $student->user_id)->get();
            $studentFeedbackCounts = StudentFeedbackCount::where('course_id', $courseId)->where('student', $student->user_id)->get();
            foreach($studentFeedbackCounts as $feedback) {
                if($feedback->negative > $feedback->positive) {
                    $topicId = $feedback->topic_id;
                    $topic = Topic::where('topic_id',  $topicId);
                    $contentId = $feedback->content_id;
                    $content = TopicContent::where('topic_content_id',  $contentId);                    
                    $singleRecommendation = array(
                        'content_id' => $contentId,
                        'content_title' => $content->value('topic_title'),
                        'topic_id' => $topicId,
                        'topic_title' => $topic->value('topic_title'),
                        'student_id' => $feedback->student,
                        'likes' => $feedback->positive,
                        'dislikes' => $feedback->negative
                    );
                    array_push($finalRecommendation, $singleRecommendation);
                }
            }
        }
        return $finalRecommendation;
    }

    public function instructorGraph($courseId) {
        
        $topics = Topic::where('course_id', $courseId)->get();
        $allTopics = [];
        foreach($topics as $topic) {
            $positiveCount = 0;
            $negativeCount = 0;
            
            $feedbackCounts = StudentFeedbackCount::where('topic_id', $topic->topic_id)->get();
            foreach($feedbackCounts as $feedback) {
                if($feedback->positive > $feedback->negative) {
                    $positiveCount++;
                } else {
                    $negativeCount++;
                }
            }
            $singleTopics = array(
                'topic_title' => $topic->topic_title,
                'likes' => $positiveCount,
                'dislikes' => $negativeCount,
            );
            array_push($allTopics, $singleTopics);
        }
        return $allTopics;
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

    public function studyMaterials(Request $request) {
        $courseId = $request->course;
        $contentsArray = [];
        $topicsArray = [];
        

        $topics = Topic::where('course_id', $courseId)->get();

        foreach($topics as $topic) {
            $attendanceStatus = 0;
            $topicContents = TopicContent::where('topic_id', $topic->topic_id)->get();
            $liveSession = LiveSession::where('topic_id', $topic->topic_id);
            
            $attendanceTracker = AttendanceTracker::where('live_session_id', $liveSession->value('live_session_id'))->where('student', Auth::user() ? Auth::user()->id : "");
            
            if($attendanceTracker->count()) {
                $attendanceStatus = $attendanceTracker->value('attendance_Status');
            }
            
            $topicTitle = $topic->topic_title;
            foreach($topicContents as $topicContent) {
                $topicContentId = $topicContent->topic_content_id;
                $topicContentTitle = $topicContent->topic_title;
                $topicContentDoc = $topicContent->document;
                array_push($contentsArray, array(
                    'topicContentId'=> $topicContentId,
                    'topicContentTitle' =>  $topicContentTitle,
                    'topicContentDoc' => $topicContentDoc,
                ));
            }
            array_push($topicsArray, array(
                'topicTitle'=> $topicTitle,
                'contents' =>  $contentsArray,
                'attendanceStatus' => $attendanceStatus
            ));
        }
        
        return view('Student.studymaterials',[
            'courseId' => $courseId,
            'topics' => $topicsArray
        ]);
    }

    public function getIndividualStudentChart(Request $request) {
        $student = $request->student;
        $topic = $request->topic;
        $course = $request->course;

        $contentsArr = [];

        $contentCount = TopicContent::where('topic_id', $topic)->count();

        $contents = TopicContent::where('topic_id', $topic)->get();

        $user = User::where('id', $student);

        $userName = $user->value('firstname') . ' ' . $user->value('lastname');

        foreach($contents as $content) {
            $likes = 0;
            $contentTitle = $content->topic_title;
            $contentId = $content->topic_content_id;
            $feedbacks = StudentFeedbackCount::where('content_id', $contentId)->where('student', $student)->get();
            if(count($feedbacks)) {
                foreach($feedbacks as $feedback) {
                    if($feedback->positive == 1) {
                        $likes = 1;
                    } elseif($feedback->negative == 1) {
                        $likes = -1;
                    }
                }
            } else {
                $likes = 0;
            }

            array_push($contentsArr, array(
                'contentId' => $contentId,
                'content_title'=> $contentTitle,
                'likes' =>  $likes
            ));
        }
        
        return response()->json(['contents' => $contentsArr, 'contentCount' => $contentCount, 'student' => $userName]);

    }

    public function getAssignmentModal(Request $request) {
        $assignmentId = $request->assignment_id;
        $batchId = $request->batch_id;

        $assignment = Assignment::where('assignment_id', $assignmentId);
        $topicAssignmentId = $assignment->value('topic_assignment_id');
        $topicAssignment = TopicAssignment::where('id', $topicAssignmentId);

        $assignmentTitle = $topicAssignment->value('assignment_title');
        $studentId = $assignment->value('student_id');

        $student = User::where('id', $studentId);

        $studentName = $student->value('firstname') . ' ' . $student->value('lastname');
        $studentImg = $student->value('image');
        $batchName = CohortBatch::where('id', $batchId)->value('batchname');
        $assignmentDoc = $assignment->value('assignment_answer');
        
        return response()->json(['assignmentTitle' => $assignmentTitle, 'studentName' => $studentName, 'studentImg' => $studentImg, 'batchName' => $batchName, 'assignmentDoc' => $assignmentDoc]);

    }

    public function completeAssignment(Request $request) {
        $assignment = $request->assignment_id;

        $assignmentObj = Assignment::where('assignment_id', $assignment)->update(['is_completed' => true]);

        return response()->json(['status' => 'success']);

    }

}
