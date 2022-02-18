<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\AssignedCourse;
use App\Models\UserType;
use App\Models\GeneralChat;
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
use App\Models\CustomTimezone;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailAfterReplay;
use App\Mail\MailAfterQuestion;
use App\Mail\MailAfterAssignmentSubmission;
use App\Mail\InstructorMailAfterFeedback;
use App\Models\Notification;
use App\Mail\mailAfterAssignmentReview;

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
        $overId = 0;
        
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
            $cohort_batches = DB::table('live_sessions')->where('batch_id', $selectedBatch)->where('start_date', '>=', $current_date)->get();
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
                  $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');
                  $next_live_cohort = Carbon::parse($start_date)->format('m/d/Y') . "-" . Carbon::createFromFormat('H:i:s',$start_time)->format('h:i A') . " " . $time_zone . " - " . Carbon::createFromFormat('H:i:s',$end_time)->format('h:i A') . " " . $time_zone;
                } else {
                  $next_live_cohort = "No live sessions scheduled";
                }
             
             
             
        } else if($userType === 'student') {
            $enrolledCourseObj = EnrolledCourse::where('user_id', $user->id);
            if($enrolledCourseObj->value('course_completion_date') != null) {
                $course_completion = Carbon::createFromFormat('Y-m-d H:i:s', $enrolledCourseObj->value('course_completion_date'))->format('F d, Y');
            }
            
            
            // $selectedBatchObj = CohortBatch::where('id', $enrolledCourseObj->value('batch_id'));
            $cohort_batches = DB::table('live_sessions')->where('batch_id', $enrolledCourseObj->value('batch_id'))->where('start_date', '>=', $current_date)->get();
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
                $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');
                $next_live_cohort = Carbon::parse($start_date)->format('m/d/Y') . "-" . Carbon::createFromFormat('H:i:s',$start_time)->format('h:i A') . " " . $time_zone . " - " . Carbon::createFromFormat('H:i:s',$end_time)->format('h:i A') . " " . $time_zone;
              } else {
                $next_live_cohort = "No live sessions scheduled";
              }
        } else {
            return false;
        }
 

        $achievements = StudentAchievement::where('student_id', $user->id)->where('course_id', $courseId)->get();
        
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
        $enrolledCourseObj = EnrolledCourse::where('user_id', $user->id)->where('course_id', $courseId);
        $studentBatch = $enrolledCourseObj->value('batch_id');
        
            foreach($topics as $topic){
                $nextCohort = "";
                $scheduled = false;
                $liveId = "";
                $courseId =  $topic->course_id;
                $topicId = $topic->topic_id;
                $topic_title =  $topic->topic_title;
                $topicContents = TopicContent::where('topic_id', $topicId)->get();
                $assignmentsArray = TopicAssignment::where('topic_id', array($topicId))->get();
                
                if($userType == 'instructor') {
                    $studentBatch = $selectedBatch;
                }
                $liveSessions = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->where('start_date', '=', $current_date)->orderby('start_date', 'asc')->get();

                if(count($liveSessions) != 0) {
                    if($userType == 'instructor') {
                        $todaysLiveSessions = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->where('start_date', '=', $current_date)->where('start_time', '<=', Carbon::now()->addMinutes(30)->format('H:i:s'))->where('end_time', '>=', Carbon::now()->format('H:i:s'))->orderby('start_date', 'asc')->get();
                    } else {
                        $todaysLiveSessions = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->where('start_date', '=', $current_date)->where('start_time', '<=', Carbon::now()->format('H:i:s'))->where('end_time', '>=', Carbon::now()->format('H:i:s'))->orderby('start_date', 'asc')->get();
                    }
                    
                    if(count($todaysLiveSessions) != 0) {
                        if($userType == 'instructor' || ($userType == 'student'  && $liveSessions[0]->is_instructor_present == true)) {
                            $liveId = $liveSessions[0]->live_session_id;
                        } else {
                            $liveId = "Wait";
                        }
                    } else {
                        $todaysLiveSessions = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->where('start_date', '=', $current_date)->where('end_time', '<=', Carbon::now()->format('H:i:s'))->orderby('start_date', 'asc')->get();
                        if(count($todaysLiveSessions) != 0) {
                            $liveId = "Over";
                            $ls = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->get();
                            if(count($ls)) {
                                $overId = $liveSessions[0]->live_session_id;
                            }
                        } else {
                            $cohort_batches = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->where('start_date', '=', $current_date)->where('end_time', '>=', Carbon::now()->format('H:i:s'))->orderby('start_date', 'asc')->get();
                            if(count($cohort_batches) != 0) {
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
                                $scheduled = true;
                                $liveId = Null;
                            }
                        }
                    }
                } else {
                    $liveSessions = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->where('start_date', '>', $current_date)->orderby('start_date', 'asc')->get();
                    if(count($liveSessions) != 0) {
                        
                        $cohort_batches = $liveSessions[0];
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
                        $scheduled = true;
                        $liveId = Null;
                    } else {
                        $liveSessions = LiveSession::where('topic_id', $topicId)->where('batch_id', $studentBatch)->get();
                        if(count($liveSessions) != 0) {
                            $liveId = "Over";
                            $overId = $liveSessions[0]->live_session_id;
                        } else {
                            $liveId = Null;
                        }
                    }
                }
                
                $startDate = "";
                $startTime = "";
                $endTime = "";
                $time_zone = "";
                
                $assignmentList = $assignmentsArray->toArray();
                $isAssignmentSubmitted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->where('is_submitted', true)->count() ? true : false;
                $isAssignmentCompleted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->where('is_submitted', true)->where('is_completed', true)->count() ? true : false;
                $isAssignmentStarted = Assignment::where('topic_id', $topicId)->where('student_id', $user->id)->count() ? true : false;
                $isAssignmentAssigned = TopicAssignment::where('topic_id', $topicId)->count() ? true : false;

                array_push($topicDetails, array(
                    'liveSessions' => $liveSessions,
                    'liveId' => $liveId,
                    'overId' => $overId,
                    'startDate' => $startDate,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                    'time_zone' => $time_zone,
                    'scheduled' => $scheduled,
                    'nextCohort' => $nextCohort,
                    'topic_id' => $topicId,
                    'topic_title' =>$topic_title,
                    'topic_content' => $topicContents,
                    'assignmentList'=> $assignmentList,
                    'isAssignmentCompleted' => $isAssignmentCompleted,
                    'isAssignmentStarted' => $isAssignmentStarted,
                    'isAssignmentAssigned' => $isAssignmentAssigned,
                    'isAssignmentSubmitted' => $isAssignmentSubmitted
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
		$total_review_count = count($studentFeedbackCounts);
		
		$review_status = true;
		if($total_review_count > 0){
			$review_status = false;
		}
		foreach($studentFeedbackCounts as $feedback) {
            if($feedback->negative == 1) {
                $topicId = $feedback->topic_id;
                $topic = Topic::where('topic_id',  $topicId);
                $contentId = $feedback->content_id;
                $content = TopicContent::where('topic_content_id',  $contentId);

                $sessionView = LiveSession::where('topic_id', $topicId);

                $singleRec = array(
                    'content_id' => $contentId,
                    'content_title' => $content->value('topic_title'),
                    'topic_id' => $topicId,
                    'topic_title' => $topic->value('topic_title'),
                    'student_id' => $feedback->value('student'),
                    'likes' => $feedback->value('positive'),
                    'dislikes' => $feedback->value('negative'),
                    'sessionId' => $sessionView->value('live_session_id')
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
            $replay_date = $qa->updated_at;
            array_push($qaArray, array(
                'id' => $qa->id,
                'student' => $studentName,
                'instructor' => $instructorName,
                'student_profile_photo' => $student_profile_photo,
                'question' => $question,
                'reply' => $reply,
                'hasReplied' => $hasReplied,
                'date' => Carbon::parse($date)->diffForHumans(),
                'replay_date' =>Carbon::parse($replay_date)->diffForHumans(),
            ));
        }
        
        $progress = EnrolledCourse::where('user_id', $user->id)->where('course_id', $courseId)->value('progress');
        $generalCourseFeedback = GeneralCourseFeedback::where('course_id', $courseId)->where('user_id', $user->id)->get();
        $feedbackCount = count($generalCourseFeedback);
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
                'course_completion' => $course_completion,
				'review_status' => $review_status,
                'feedbackCount' => $feedbackCount,
                'instructorId' => $assigned,
                'studentId' => $user->id
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

            $current_date = Carbon::now()->format('Y-m-d');
            $progress = 0;
            $totalSessions = LiveSession::where('course_id', $courseId)->count();
            if($totalSessions != 0) {
              $progressTracker = LiveSession::where('start_date', '<', $current_date)->count();
              $progress = round($progressTracker * 100 / $totalSessions, 0); 
            }

            $recommendations = $this->instructorRecommendations($courseId, $selectedBatch);
            $graph = $this->instructorGraph($courseId, $selectedBatch);

            // Hours spent
            $spentHours = 0;
            $spentSessions = LiveSession::where('course_id', $courseId)->where('batch_id', $selectedBatch)->where('start_date', '<', $current_date)->get();
            
            foreach($spentSessions as $spentSession) {
                $spentHours += intval((new Carbon($spentSession->start_time))->diff(new Carbon($spentSession->end_time))->format('%h'));
            }

            // Students joined

            $studentsJoined = EnrolledCourse::where('course_id', $courseId)->where('batch_id', $selectedBatch)->count();
            
            //Likes and dislikes

            $likesCount = 0;
            $dislikesCount = 0;
            $liveFeedbacks = StudentFeedbackCount::where('course_id', $courseId)->where('batch_id', $selectedBatch)->get();
            foreach($liveFeedbacks as $liveFeedback) {
                if($liveFeedback->positive == 1) {
                    $likesCount += 1;
                }
                if($liveFeedback->negative == 1) {
                    $dislikesCount += 1;
                }
            }
            
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
                'assignmentArr' => $assignmentArr,
                'likesCount' => $likesCount,
                'dislikesCount' => $dislikesCount,
                'studentsJoined' => $studentsJoined,
                'spentHours' => $spentHours,
                'instructorId' => $user->id,
                'courseId' => $courseId
            ]);
        }      

    }else{
        return redirect('/403');
    }
    }

     public function courseReviewProcess(Request $request){
        
        try{
        $courseId = $request->course_id;
        $userId = $request->user_id;
        $comment = $request->input('comment');
        $rating = $request->input('rating');
        $assigned = DB::table('assigned_courses')->where('course_id', $courseId)->value('user_id');
        $instructorName = User::find($assigned)->firstname.' '.User::find($assigned)->lastname;
        $instructorEmail = User::find($assigned)->email;
        $studentName = User::find($userId)->firstname.' '.User::find($userId)->lastname;
        $courseTitle = Course::where('id', $courseId)->value('course_title');

       
        $generalCourseFeedback = new GeneralCourseFeedback;
        $generalCourseFeedback->user_id = $userId;
        $generalCourseFeedback->course_id = $courseId;
        $generalCourseFeedback->comment = $comment;
        $generalCourseFeedback->rating = $rating;
        $generalCourseFeedback->save();

        $finalRating = 0;
        $totalRatings = 0;
        $allRatings = GeneralCourseFeedback::where('course_id', $courseId)->get();
       
        foreach($allRatings as $allRating) {
            $finalRating += intval($allRating->rating);
            $totalRatings += 1;
        }
        if($totalRatings != 0) {
            $finalRating = $finalRating / $totalRatings;
        }
        
        $course = Course::where('id', $courseId);
        $exRatingsCount = $course->value('ratings_count');
        $exRatingsCount += 1;
        if($course->value('use_custom_ratings') == true) {
            $course = $course->update(['students_ratings' => $finalRating, 'ratings_count' => $exRatingsCount]);
        } else {
            $course = $course->update(['course_rating' => $finalRating, 'students_ratings' => $finalRating, 'ratings_count' => $exRatingsCount]);
        }
        
        
        $details= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];

         Mail::mailer('infosmtp')->to($instructorEmail)->send(new InstructorMailAfterFeedback($details));

        $notification = new Notification; 
        $notification->user = $assigned;
        $notification->notification = "Hi ".$instructorName.", You have new feedback from your student ".$studentName." on your course ".$courseTitle.".";
        $notification->is_read = false;
        $notification->save();

        return response()->json([
            'status' => 'success', 
            'message' => 'submitted successfully'
         ]);

        }catch (Exception $exception) {
            return response()->json([
                'status' => 'success', 
                'message' => 'submitted successfully'
             ]);
        }
        
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

        $topicId = $request->topic_id;
        $assignments = Assignment::where('student_id' , $userId)
                                  ->where('topic_id', $topicId)->get();
                                          
        if(count($assignments) == 0){

        $topicAssignment = TopicAssignment::where('topic_id', $topicId);
        $courseId = $topicAssignment->value('course_id');
        $instructorId = $topicAssignment->value('instructor_id');
        $topicId = $topicAssignment->value('topic_id');
        $assignment = new Assignment;

        $assignment->topic_assignment_id = $topicAssignment->value('id');
        $assignment->student_id = $userId;
        $assignment->course_id = $courseId;
        $assignment->instructor_id = $instructorId;
        $assignment->topic_id = $topicId;
        $assignment->assignment_answer = "None";
        $assignment->is_submitted = false;
        $assignment->save();
        }
        return response()->json([
            'status' => 'success', 
            'message' => 'submitted successfully'
         ]);
        
    }

    public function submitAssignment(Request $request){
        try{
            $validatedData = $request->validate([
                'assignment_comment' => 'required',
                'assignment_upload' => 'required'
            ]);
        $user = Auth::user();
        $userId = $user->id;
        $studentName = $user->firstname.' '.$user->lastname;
        $topic_assignment_id = $request->assignment_id;
        $comment = $request->input('assignment_comment');
        
        $timestamp = time();
        $file = $request->assignment_upload;
        $tFileName = $_FILES['assignment_upload']['name'];
        $dotPos = strpos($tFileName,'.');
        $name = substr($tFileName, 0, $dotPos - 1);
        $ext = substr($tFileName, $dotPos + 1, strlen($tFileName));
        $assignementFile = $name . $timestamp . '.' . $ext;
        
        // $file->storeAs('assignmentAnswers', $assignementFile,'public');

        $destinationPath = public_path().'/storage/assignmentAnswers';
        $file->move($destinationPath,$assignementFile);

        $topicAssignment = TopicAssignment::where('id', $topic_assignment_id);
        $courseId = $topicAssignment->value('course_id');
        $instructorId = $topicAssignment->value('instructor_id');
        $courseTitle = Course::where('id', $courseId)->value('course_title');
       
        $instructorName = User::find($instructorId)->firstname.' '.User::find($instructorId)->lastname;
        $instructorEmail = User::find($instructorId)->email;

        $assignment = Assignment::where('topic_assignment_id', $topic_assignment_id);
       
        $assignment->update(['assignment_answer' => $assignementFile, 'comment' => $comment, 'is_submitted' => true]);

        $badgeId = AchievementBadge::where('title', 'Assignment')->value('id');

        $badgeAlreadyExists = StudentAchievement::where('student_id', $userId)->where('course_id', $courseId)->where('badge_id', $badgeId)->get();

        if(count($badgeAlreadyExists) == 0) {
            $student_achievement = new StudentAchievement;
            $student_achievement->student_id = $userId;
            $student_achievement->badge_id =  $badgeId;
            $student_achievement->course_id =  $courseId;
            $student_achievement->is_achieved = true;
            $student_achievement->save();
        }

        $data= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];

         Mail::mailer('infosmtp')->to($instructorEmail)->send(new MailAfterAssignmentSubmission($data));

         $notification = new Notification; 
         $notification->user = $instructorId;
         $notification->notification = "Hi ".$instructorName.", You have got a new assignment submitted by ".$studentName." for the course ".$courseTitle.
                                        "To view the submitted assignment, please log in to your account on ThinkLit.com";
         $notification->is_read = false;
         $notification->save();

        return redirect()->back();

        }catch (Exception $exception){
            return redirect()->back();
        }
    
    
    }

    public function generateCertificate($id){
      
        $courseDetails = [];
        $course= Course::findOrFail($id);    
        $user = Auth::user();
        $student_firstname = $user->firstname;
        $student_lastname = $user->lastname;
		$course_completion = '';
        if($user){

			$courseCategory = CourseCategory::where('id', $course->category)->value('category_name');

			$assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
			$instructor = User::where('id', $assigned);
			$instructorfirstname = $instructor->value('firstname');
			$instructorlastname = $instructor->value('lastname');
			$instructorSignature = $instructor->value('signature');
			$date_of_issue = Carbon::now();
			$enrolledCourseObj = EnrolledCourse::where('user_id', $user->id);
            if($enrolledCourseObj->value('course_completion_date') != null) {
                $course_completion = Carbon::createFromFormat('Y-m-d H:i:s', $enrolledCourseObj->value('course_completion_date'))->format('F d, Y');
            }
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
				'course_completion' => $course_completion
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

    public function instructorGraph($courseId, $selectedBatch) {
        
        $topics = Topic::where('course_id', $courseId)->get();
        $allTopics = [];
        foreach($topics as $topic) {
            $positiveCount = 0;
            $negativeCount = 0;
            
            $feedbackCounts = StudentFeedbackCount::where('topic_id', $topic->topic_id)->where('batch_id', $selectedBatch)->get();
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
        try{
        $qaId = $request->qaId;
        $reply = $request->replyContent;

        $instructorId = Auth::user()->id;
        $courseQA = CourseQA::find($qaId);
        $studentId = $courseQA->value('student');
        $courseTitle = Course::where('id', $courseQA->value('course_id'))->value('course_title');
        $student = User::where('id', $studentId);
        $studentEmail = $student->value('email');
        $studentName = $student->value('firstname').' '.$student->value('lastname');
        $instructorName = User::find($instructorId)->firstname.' '.User::find($instructorId)->lastname;
        
        $details= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];
   
        $courseQA->reply = $reply;
        $courseQA->has_replied = true;
        $updatedAt = $courseQA->updated_at->format('d M H:m');
        $courseQA->save();

        Mail::mailer('infosmtp')->to($studentEmail)->send(new MailAfterReplay($details));

        $notification = new Notification; 
        $notification->user = $studentId;
        $notification->notification = "Hello ". $studentName.", You have got a reply to your message from your Instructor ". $instructorName."for the course ". $courseTitle." on ThinkLit. To view the message,
         please log in to your account on ThinkLit.com";
        $notification->is_read = false;
        $notification->save();

        return response()->json([
            'status' => 'success',
            'reply' => $reply, 
            'updatedAt' => $updatedAt,
            'message' => 'Replied successfully'
         ]);

        }catch (Exception $exception){

            return response()->json([
                'status' => 'success',
                'reply' => $reply, 
                'updatedAt' => $updatedAt,
                'message' => 'Replied successfully'
             ]);

        }

         
    }

    public function askQuestion(Request $request) {
        try{

        $question = $request->question;
        $course_id = $request->course_id;
        $student = 0;

        $qa = new CourseQA;
        $qa->course_id = $course_id;
        $instructor = AssignedCourse::where('course_id', intval($course_id))->value('user_id');
        $user =Auth::user();
        $instructorName = User::find($instructor)->firstname.' '.User::find($instructor)->lastname;
        $instructorEmail = User::where('id', $instructor)->value('email');
        $studentName = $user->firstname.' '.$user->lastname;
        if($user) {
            $student = User::where('id', $user->id)->value('id');
            
            
            $badgeId = AchievementBadge::where('title', 'Q&A')->value('id');
            $achievementCheck = StudentAchievement::where('student_id', $user->id)->where('course_id', $course_id)->where('badge_id', $badgeId)->count();
            
            if(!$achievementCheck) {
                $student_achievement = new StudentAchievement;
                $student_achievement->student_id = $user->id;
                $student_achievement->badge_id =  $badgeId;
                $student_achievement->course_id =  $course_id;
                $student_achievement->is_achieved = true;
                $student_achievement->save();
            }
            
        }

        $data= [
            'studentName' => $studentName,
            'instructorName' => $instructorName,
         ];
        $qa->student = $student;
        $qa->instructor = $instructor;
        $qa->question = $question;
        $qa->has_replied = false;

        $qa->save();

        Mail::mailer('infosmtp')->to($instructorEmail)->send(new MailAfterQuestion($data));

        $notification = new Notification; 
        $notification->user = $instructor;
        $notification->notification = "Hi ". $instructorName.",You have got a new message from your student ".$studentName." on ThinkLit. To view the message, please log in to your account on ThinkLit.com";
        $notification->is_read = false;
        $notification->save();

        return response()->json(['status' => 'success', 'msg' => 'Saved successfully!']);
        
        }catch (Exception $exception){
            return response()->json(['status' => 'success', 'msg' => 'Saved successfully!']);
        }

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
        
        $assignmentData = Assignment::where('assignment_id', $assignment);
        $studentId = $assignmentData->value('student_id');
        $courseId = $assignmentData->value('course_id');
        $student = User::where('id', $studentId);
        $studentName = $student->value('firstname').' '.$student->value('lastname');
        $studentEmail = $student->value('email');
        $courseTitle = Course::where('id', $courseId)->value('course_title');

        $details= [
            'studentName' => $studentName,
            'courseTitle' => $courseTitle
         ];
        
         Mail::mailer('infosmtp')->to($studentEmail)->send(new mailAfterAssignmentReview($details));
         $notification = new Notification; 
         $notification->user = $sessionInstructor;
         $notification->notification = "Hello ".$studentName." ,Your assignment for the course ".$courseTitle." has been reviewed by the instructor. 
                                        To view the reviewed assignment, please log in to your account on ThinkLit.com";
         $notification->is_read = false;
         $notification->save();
        return response()->json(['status' => 'success']);

    }

    public function instructorChatView(Request $request) {
        $user = Auth::user();

        $studentId = $request->student;
        $instructorId = $request->instructor;
        $courseId = $request->course;
        $batch = $request->batch;

        return view('Student.studentInstructorChat',[
            'courseId' => $courseId,
            'studentId' => $studentId,
            'instructorId' => $instructorId,
            'batch' => $batch
        ]);
    }

    public function getGeneralChat(Request $request) {
        $html = "";
        $user = Auth::user();
        
        $courseId = $request->courseId;
        $studentId = $request->studentId;
        $instructorId = $request->instructorId;

        $chats = GeneralChat::where('course_id', $courseId)->where('student', $studentId)->where('instructor', $instructorId)->get();

        foreach($chats as $chat) {
            if($chat->sender == $chat->student) {
                $sender = $chat->student_name;
                if($user->id == $chat->student) {
                    $sameUser = "same_user";
                } else {
                    $sameUser = "";
                }
                
            } elseif($chat->sender == $chat->instructor) {
                $sender = $chat->instructor_name;
                if($user->id == $chat->instructor) {
                    $sameUser = "same_user";
                } else {
                    $sameUser = "";
                }
            }
            $html = $html . "<p class='chat-message-body ". $sameUser ."'><b class='participant-name'>". $sender .": </b><span class='participant-msg'>" . $chat->message . "</span></p>";
        }

        return response()->json(['html' => $html]);
    }

    public function saveGeneralChat(Request $request) {

        $user = Auth::user();
        $loggedInId = $user->id;

        $courseId = $request->courseId;
        $studentId = $request->studentId;
        $instructorId = $request->instructorId;
        $message = $request->message;
        
        $generalChat = new GeneralChat;
        $generalChat->course_id = $courseId;
        $generalChat->student = $studentId;
        $generalChat->instructor = $instructorId;
        $studentName = User::where('id', $studentId)->value('firstname') .' '. User::where('id', $studentId)->value('lastname');
        $generalChat->student_name = $studentName;
        $instName = User::where('id', $instructorId)->value('firstname') .' '. User::where('id', $studentId)->value('lastname');
        $generalChat->instructor_name = $instName;
        $generalChat->message = $message;
        if($loggedInId == $studentId) {
            $generalChat->sender = $studentId;
        } else {
            $generalChat->sender = $instructorId;
        }

        $generalChat->save();

        return response()->json(['status' => 'success', 'message' => 'Successfully sent!']);
    }
}
