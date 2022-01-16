<?php



namespace App\Http\Controllers\AgoraIntegrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;
use App\Models\User;
use App\Models\AssignedCourse;
use App\Models\EnrolledCourse;
use App\Models\Topic;
use App\Models\CohortBatch;
use App\Models\TopicContent;
use App\Models\LiveSession;
use App\Models\LiveFeedbacksPushRecord;
use App\Models\StudentFeedbackCount;
use App\Models\AttendanceTracker;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralSetting;
use App\Models\AchievementBadge;
use App\Models\StudentAchievement;

require_once "AccessToken.php";

class RtmTokenGeneratorController extends Controller
{
    const RoleAttendee = 0;
    const RolePublisher = 1;
    const RoleSubscriber = 2;
    const RoleAdmin = 101;
    const appId = "88a4d4d0cb874afd82ada960cdcc1b1f";
    const appCertificate = "3b0fc46ccb5c4fc68fd98bd0d9e60131";


    public function index(Request $request, $session) {
        $userObj = Auth::user();

        $sessionObj = LiveSession::where('live_session_id', $session);
        $topicId = $sessionObj->value('topic_id');
        $topic = Topic::where('topic_id', $topicId)->value('topic_title');

        $participants = [];
        $contents = TopicContent::where('topic_id', $topicId)->get();
        
        if($userObj) {
            $userTypeLoggedIn =  UserType::find($userObj->role_id)->user_role;
            $attendanceRec = AttendanceTracker::where('live_session_id', $session)->get();
            
            foreach($attendanceRec as $rec) {
                $student = User::where('id', $rec->student);
                $studentName = $student->value('firstname') . ' ' . $student->value('lastname');
                array_push($participants, $studentName);
            }

            return view('Agora.SessionScreen.live_session_screen', [
                'participants'=> $participants,
                'session' => $session,
                'topic_title' => $topic,
                'contents' => $contents,
                'userType' => $userTypeLoggedIn
            ]);
        } else {
            return redirect('/403');
        }
    }

    public function buildToken(Request $request, $session) {

        $sessionObj = LiveSession::where('live_session_id', $session);
        

        $batch = CohortBatch::where('id', $sessionObj->value('batch_id'));
        
        $startTime = $batch->value('start_time');
        $endTime = $batch->value('end_time');

        $firstTime=strtotime($startTime);
        $lastTime=strtotime($endTime);
        $timeDiff=$lastTime-$firstTime;
        $totalSeconds = $timeDiff;

        $sessionTitle = $sessionObj->value('session_title');
        $userObj = Auth::user();
        $user = "1005" . strval($userObj->id);
        
        if($userObj->role_id == 2) {
            $role = self::RoleSubscriber;
            $roleName = $userObj->firstname;

            $attendanceRec = AttendanceTracker::where('live_session_id', $session)->where('student', $userObj->id)->get();
            if(!count($attendanceRec)) {
                $attendance = New AttendanceTracker;
                $attendance->live_session_id = $session;
                $attendance->student = $userObj->id;
                $attendance->start_time = (new DateTime("now", new DateTimeZone('UTC')));
                $attendance->save();
            }
        } else {
            $role = self::RolePublisher;
            $roleName = "Instructor";
        }
        
        $expireTimeInSeconds = $totalSeconds;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        return response()->json(['token' => $generatedToken, 'appId' => self::appId, 'uid' => $user, 'rolename' => $roleName, 'roomid' => "124", 'channel' => $sessionTitle, 'role' => $role , 'duration' => $expireTimeInSeconds]);
        
    }

    public function buildTokenStudent(Request $request) {
        $user = Auth::user()->id;
        $role = self::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        return response()->json(['token' => $generatedToken, 'appId' => self::appId, 'uid' => $user, 'rolename' => 'Instructor', 'roomid' => strval(rand(101, 500)), 'channel' => 'Live Session', 'role' => $role , 'duration' => $expireTimeInSeconds]);
    }

    public function scheduleSession(Request $request) {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $courses = Course::all();
        $sessions = LiveSession::all();
        $sessionsArray = [];
        $slNo = 1;
        foreach($sessions as $session) {
            $sessionTitle = $session->session_title;
          
            $instructor = User::find($session->instructor)->firstname . ' ' . User::find($session->instructor)->lastname;
            $batch = CohortBatch::where('id', $session->batch_id)->value('title');
            $topic = Topic::where('topic_id', $session->topic_id)->value('topic_title');
            $sessionCourse = Course::where('id', $session->course_id)->value('course_title');
            array_push($sessionsArray, array(
                'slNo' => $slNo,
                'sessionCourse' => $sessionCourse,
                'sessionTitle' => $sessionTitle,
                'instructor' =>$instructor,
                'batch' => $batch,
                'topic'=> $topic
            ));

            $slNo++;
        }
        
        $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
        return view('Agora.ScheduleScreens.schedule_session', [
            'courses' => $courses,
            'instructors' => $instructors,
            'sessions' => $sessionsArray,
            'userType' => $userTypeLoggedIn
        ]);
    }

    public function showCourseAttributes(Request $request) {
        $course = $request->courseId;
       
        $batchHtml = '';
        $topicHtml = '';

        $batches = CohortBatch::where('course_id', $course)->get();
        $topics = Topic::where('course_id', $course)->get();

        foreach($batches as $batch) {
            $batchHtml = $batchHtml . "<option value=" . $batch->id . ">" . $batch->title . "</option>";
        }
        foreach($topics as $topic) {
            $topicHtml = $topicHtml . "<option value=" . $topic->topic_id . ">" . $topic->topic_title . "</option>";
        }

        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'batches' => $batchHtml, 'topics' => $topicHtml]);
    }

    public function saveSessionDetails(Request $request) {
        $sessionTitle = $request->sessionTitle;
        $sessionCourse = $request->sessionCourse;
        $sessionTopic = $request->sessionTopic;
        $sessionBatch = $request->sessionBatch;
        $sessionInstructor = $request->sessionInstructor;

        $liveSession = new LiveSession;

        $liveSession->session_title = $sessionTitle;
        $liveSession->course_id = $sessionCourse;
        $liveSession->topic_id = $sessionTopic;
        $liveSession->batch_id = $sessionBatch;
        $liveSession->instructor = $sessionInstructor;

        $liveSession->save();

        return response()->json(['status' => 'success', 'message' => 'Added successfully']);
    }

    public function viewSessions(Request $request) {

        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;

        $sessions = LiveSession::all();
        $sessionsArray = [];
        $slNo = 1;
        foreach($sessions as $session) {
            $sessionTitle = $session->session_title;
            $instructor = User::find($session->instructor)->firstname . ' ' . User::find($session->instructor)->lastname;
            $batch = CohortBatch::where('id', $session->batch_id)->value('title');
            $topic = Topic::where('topic_id', $session->topic_id)->value('topic_title');

            array_push($sessionsArray, array(
                'id' => $session->live_session_id,
                'slNo' => $slNo,
                'sessionTitle' => $sessionTitle,
                'instructor' =>$instructor,
                'batch' => $batch,
                'topic'=> $topic
            ));

            $slNo++;
        }
        
        return view('Instructor.sessionList', [
            'sessions' => $sessionsArray,
            'userType' => $userTypeLoggedIn
        ]);
    }

    public function pushLiveRecord(Request $request) {

        $contentId = $request->content_id;

        $content = TopicContent::where('topic_content_id', $contentId);
        $topic = Topic::where('topic_id', $content->value('topic_id'));
        $previousPushes = LiveFeedbacksPushRecord::where('topic_id', $topic->value('topic_id'))->update(['is_expired' => true]);
        
        $pushRecord = new LiveFeedbacksPushRecord;
        $pushRecord->topic_content_id = $contentId;
        $pushRecord->topic_id = $content->value('topic_id');
        $pushRecord->course_id = $topic->value('course_id');
        $user = Auth::user();
        $instructor =  $user->id;
        $pushRecord->instructor = $instructor;
        $pushRecord->is_pushed = true;
        $pushRecord->is_expired = false;
        $pushRecord->save();

        return;
    }

    public function getLiveRecord(Request $request) {
        $flag = 0;

        $session = LiveSession::where('live_session_id', $request->session);

        $topicId = $session->value('topic_id');
        $push = LiveFeedbacksPushRecord::where('topic_id', $topicId)->where('is_expired', false);

        $topicContentId = $push->value('topic_content_id');

        $user = Auth::user();
        $student =  $user->id;
        $feedbackRecord = StudentFeedbackCount::where('content_id', $topicContentId)->where('student', $student)->get();

        if(count($feedbackRecord) != 0) {
            $flag = 1;
        }
        $content = TopicContent::where('topic_content_id', $topicContentId);
        
        $contentTitle = $content->value('topic_title');
        return response()->json(['content_id' => $topicContentId, 'content_title' => $contentTitle, 'flag' => $flag]);
    }

    public function pushFeedbacks(Request $request) {

        $contentId = $request->content_id;
        $type = $request->type;

        $feedbackCountExists = StudentFeedbackCount::where('content_id', $contentId)->get();
        if(count($feedbackCountExists)) {
            $feedbackCountExists = StudentFeedbackCount::where('content_id', $contentId);
            if($type == "positive") {
                $feedbackCountExists->update(['positive' => 1]);
                $feedbackCountExists->update(['negative' => 0]);
            } else {
                $feedbackCountExists->update(['positive' => 0]);
                $feedbackCountExists->update(['negative' => 1]);
            }
        } else {
            $feedbackCount = new StudentFeedbackCount;
            $content = TopicContent::where('topic_content_id', $contentId);
            $topicId = $content->value('topic_id');
            $topic = Topic::where('topic_id', $topicId);
            $courseId = $topic->value('course_id');

            $user = Auth::user();
            $student =  $user->id;
            $feedbackCount->content_id = $contentId;
            $feedbackCount->topic_id = $topicId;
            $feedbackCount->course_id = $courseId;
            $feedbackCount->student = $student;
            if($type == "positive") {
                $feedbackCount->positive = 1;
                $feedbackCount->negative = 0;
            } else {
                $feedbackCount->positive = 0;
                $feedbackCount->negative = 1;
            }

            $feedbackCount->save();
        }
        $finalCounts = StudentFeedbackCount::where('content_id', $contentId);
        $positiveCount = $finalCounts->value('positive');
        $negativeCount = $finalCounts->value('negative');
        return response()->json(['positive' => $positiveCount, 'negative' => $negativeCount]);
    }

    public function studentExit(Request $request) {
        $attendedSessions = 0;
        $sessionId = $request->sessionId;
        $newTime = $request->timer;
        $user = Auth::user();
        if($user) {

            $courseId = LiveSession::where('live_session_id', $sessionId)->value('course_id');

            $student =  $user->id;

            

            $attendance = AttendanceTracker::where('student', $student)->where('live_session_id', $sessionId);
            if($attendance) {
                $timer = $attendance->value('attendance_time') == NULL ? $newTime : $attendance->value('attendance_time') + $newTime;
            }
            
            $attendance->update(['attendance_time' => $timer]);

            $attendanceSettings = GeneralSetting::where('setting', 'attendance_timer')->value('value');

            $batchId = LiveSession::where('live_session_id', $sessionId)->value('batch_id');
            $batch = CohortBatch::where('id', $batchId);
            $startTime = $batch->value('start_time');
            $endTime = $batch->value('end_time');
            $startHour = intval($startTime[0] . $startTime[1]);
            $startMinutes = intval($startTime[3] . $startTime[4]);

            $endHour = intval($endTime[0] . $endTime[1]);
            $endMinutes = intval($endTime[3] . $endTime[4]);
            $totalSeconds = ((60 - $startMinutes) + $endMinutes) + ($endHour - ($startHour + 1)) * 3600;
            
            if($attendance->value('attendance_time') * 100 / $totalSeconds >= $attendanceSettings) {
                $badgeId = AchievementBadge::where('title', 'Starter')->value('id');

                $student_achievement = new StudentAchievement;
                $student_achievement->student_id = $student;
                $student_achievement->badge_id =  $badgeId;
                $student_achievement->is_achieved = true;
                $student_achievement->save();

                $topicsCount = Topic::where('course_id', $courseId)->count();
            $trackers = AttendanceTracker::where('student', $student)->get();
            foreach($trackers as $tracker) {
                $session = LiveSession::where('live_session_id', $tracker->live_session_id);
                if($session->value('course_id') == $courseId) {
                    $attendedSessions = $attendedSessions + 1;
                }
            }

            $percent = $attendedSessions * 100 / $topicsCount;

            $progress = EnrolledCourse::where('course_id', $courseId)->where('user_id', $student)->update(['progress' => $percent]);

                $attendance->update(['attendance_Status' => true ]);
            } else {
                $attendance->update(['attendance_Status' => false ]);
            }

            return response()->json(['status' => 'success', 'msg' => 'Student closed window', 'course_id' => $courseId]);
        }
    }

    public function getAttendanceList(Request $request) {
            
            $session = $request->session;
            $html = "";

            $attendanceRec = AttendanceTracker::where('live_session_id', $session)->get();
            
            foreach($attendanceRec as $rec) {
                $student = User::where('id', $rec->student);
                $studentName = $student->value('firstname') . ' ' . $student->value('lastname');
                    $html = $html . '<p style="color:black;margin-top:25px;">' . $studentName . '<span style="margin-left:220px;"><span style="color:green;">●</span> Online</span></p>';
               
                
            }
            return response()->json(['status' => 'success', 'html' => $html]);
    }
}