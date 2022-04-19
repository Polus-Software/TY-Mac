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
use App\Models\GeneralLiveSessionFeedback;
use App\Models\LiveSessionChat;
use App\Models\SingleSessionPushRecord;
use App\Models\SingleSession;
use App\Models\SingleSessionUser;
use App\Models\SingleSessionChat;
use App\Models\CustomTimezone;
use Carbon\Carbon;
use App\Models\Notification;
use Illuminate\Support\Facades\Mail;
use App\Mail\InstructorMailAfterLiveSessionScheduled;
use App\Mail\RecommendationMail;
use App\Mail\OneOnOneMail;
use App\Mail\RecommendationMailInstructor;
use App\Mail\MailAfterLiveSessionScheduled;
use App\Mail\mailAfterCourseCompletion;

require_once "AccessToken.php";

class RtmTokenGeneratorController extends Controller
{
    
    const RoleAttendee = 0;
    const RolePublisher = 1;
    const RoleSubscriber = 2;
    const RoleAdmin = 101;
    const appId = "70df359f3a72437eb52c93b2de43be84";
    const appCertificate = "0d91d0e8b1954f249beab1c1b73c8797";



    public function index(Request $request, $session) {
        
        $userObj = Auth::user();
        $batchId = $request->batchId;
        $sessionObj = LiveSession::where('live_session_id', $session);
        $courseId = $sessionObj->value('course_id');
        $topicId = $sessionObj->value('topic_id');
        $topic = Topic::where('topic_id', $topicId)->value('topic_title');

        $participants = [];
        $contents = TopicContent::where('topic_id', $topicId)->get();

        $feedbackQ1 = GeneralSetting::where('setting', 'feedback_question_1')->value('value');
        $feedbackQ2 = GeneralSetting::where('setting', 'feedback_question_2')->value('value');
        $feedbackQ3 = GeneralSetting::where('setting', 'feedback_question_3')->value('value');
        
        if($userObj) {

            $userId = $userObj->id;
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
                'userType' => $userTypeLoggedIn,
                'courseId' => $courseId,
                'userId' => $userId,
                'feedbackQ1' => $feedbackQ1,
                'feedbackQ2' => $feedbackQ2,
                'feedbackQ3' => $feedbackQ3,
                'batchId' => $batchId
            ]);
        } else {
            return redirect('/403?session=true&sessionId=' . $session);
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

        if(strlen($sessionTitle) > 60) {
            $sessionTitle = substr($sessionTitle, 0, 55) . '..';
        } else {
            $sessionTitle = $sessionTitle;
        }
        $userObj = Auth::user();
        $user = "1005" . strval($userObj->id);
        
        if($userObj->role_id == 2) {
            $role = self::RoleSubscriber;
            $roleName = $userObj->firstname;

            $attendanceRec = AttendanceTracker::where('live_session_id', $session)->where('student', $userObj->id);
            if(!$attendanceRec->count()) {
                $attendance = New AttendanceTracker;
                $attendance->live_session_id = $session;
                $attendance->student = $userObj->id;
                $attendance->start_time = (new DateTime("now", new DateTimeZone('UTC')));
                $attendance->attendance_Status = true;
                $attendance->is_present = true;
                $attendance->save();
            } else {
                $attendanceRec->update(['attendance_Status' => true, 'is_present' => true]);
            }
        } else {
            $role = self::RolePublisher;
            $roleName = "Instructor";
            $sessionObj->update(['is_instructor_present' => true]);
        }
        
        $expireTimeInSeconds = $totalSeconds + 1200;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds + 1800;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        return response()->json(['token' => $generatedToken, 'appId' => self::appId, 'uid' => $user, 'rolename' => $roleName, 'roomid' => '22' . $session, 'channel' => $sessionTitle, 'role' => $role , 'duration' => ($expireTimeInSeconds + 1800)]);
        
    }

    

    public function scheduleSession(Request $request) {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $courses = Course::where('is_published', true)->get();
        $sessions = LiveSession::all();
        $sessionsArray = [];
        $slNo = 1;
        foreach($sessions as $session) {
            $batchId = $session->batch_id;
            $cohortBatch = CohortBatch::where('id', $batchId);
            $cohortTimezone = $cohortBatch->value('time_zone');

            // Time zone
            $offset = CustomTimezone::where('name', $cohortTimezone)->value('offset');
                        
            $offsetHours = intval($offset[1] . $offset[2]);
            $offsetMinutes = intval($offset[4] . $offset[5]);
                        
            if($offset[0] == "+") {
                $sTime = strtotime($session->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                $eTime = strtotime($session->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
            } else {
                $sTime = strtotime($session->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                $eTime = strtotime($session->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
            }
                        
            $startTime = date("h:i A", $sTime);
            $endTime = date("h:i A", $eTime);
            $date = new DateTime("now");
            $time_zone = $date->setTimeZone(new DateTimeZone($cohortTimezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($cohortTimezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($cohortTimezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($cohortTimezone))->format('T');
            $instructor = User::find($session->instructor)->firstname . ' ' . User::find($session->instructor)->lastname;
            $batchObj = CohortBatch::where('id', $session->batch_id);
            $batch = CohortBatch::where('id', $session->batch_id)->value('title');
            $sessionCourse = Course::where('id', $session->course_id)->value('course_title');
            $sesionTitle = $session->session_title;

            
            //Timezone calculations
            
            $batchTimeZone = $batchObj->value('time_zone');
            $batchDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d H:i:s'), 'UTC')->setTimezone($batchTimeZone)->format('Y-m-d');
            $currentUTC = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d H:i:s'), 'UTC')->format('Y-m-d');

            if($batchDate > $currentUTC) {
                $startDate = Carbon::createFromFormat('Y-m-d', $session->start_date, 'UTC')->addDays(1)->format('Y-m-d');
            } elseif($batchDate < $currentUTC) {
                $startDate = Carbon::createFromFormat('Y-m-d', $session->start_date, 'UTC')->subDays(1)->format('Y-m-d');
            } elseif($batchDate == $currentUTC) {
                $startDate = $session->start_date;
            }


            $time = Carbon::createFromFormat('Y-m-d', $session->start_date, 'UTC')->format('m-d-Y') . ' - ' . $startTime .' '. $time_zone. ' - ' . $endTime . ' ' . $time_zone;

            array_push($sessionsArray, array (
                'slNo' => $slNo,
                'id' => $session->live_session_id,
                'session' => $sesionTitle,
                'sessionCourse' => $sessionCourse,
                'time' => $time,
                'batch' => $batch
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
        $instructorHtml = '';
        $assigned = DB::table('assigned_courses')->where('course_id', $course )->value('user_id');
        $user = User::where('id', $assigned);
        $instructorId = $user->value('id');
        $instructorfirstname = $user->value('firstname');
        $instructorlastname = $user->value('lastname');
        $instructor = $instructorfirstname. ' '.$instructorlastname;
        $current_date = Carbon::now()->format('Y-m-d');
        $batches = CohortBatch::where('course_id', $course)->where('end_date', '>=', $current_date)->get();

        foreach($batches as $batch) {
            $batchHtml = $batchHtml . "<option value=" . $batch->id . ">" . $batch->title . "</option>";
        }
    
        $instructorHtml = $instructorHtml . "<option value=" .$instructorId . ">" . $instructor . "</option>";

        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'batches' => $batchHtml, 'instructor' => $instructorHtml]);
    }

    public function saveSessionDetails(Request $request) {

        $sessionCourse = $request->sessionCourse;
        $sessionBatch = $request->sessionBatch;
        $sessionInstructor = $request->sessionInstructor;
        $topicsCounter = 0;

        $liveSessionExists = LiveSession::where('batch_id', $sessionBatch)->get();
        if(count($liveSessionExists) > 0) {
            return response()->json(['status' => 'error', 'message' => 'Sessions already scheduled for this batch!']);
        }
        $instructor = User::where('id', $sessionInstructor);
        $instructorName = $instructor->value('firstname').' '.$instructorlastname = $instructor->value('lastname');
        $instructorEmail = $instructor->value('email');
        $courseTitle = Course::where('id', $sessionCourse)->value('course_title');
        
        $topics = Topic::where('course_id', $sessionCourse)->get();
        $selectedBatchObj = CohortBatch::where('id', $sessionBatch);

        //Timezone calculations

        $batchTimeZone = $selectedBatchObj->value('time_zone');
        $batchDate = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d H:i:s'), 'UTC')->setTimezone($batchTimeZone)->format('Y-m-d');
        $currentUTC = Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now()->format('Y-m-d H:i:s'), 'UTC')->format('Y-m-d');
        if($batchDate > $currentUTC) {
            $startDate = Carbon::createFromFormat('Y-m-d', $selectedBatchObj->value('start_date'), 'UTC')->subDays(1)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('Y-m-d', $selectedBatchObj->value('end_date'), 'UTC')->subDays(1)->format('Y-m-d');
        } elseif($batchDate < $currentUTC) {
            $startDate = Carbon::createFromFormat('Y-m-d', $selectedBatchObj->value('start_date'), 'UTC')->addDays(1)->format('Y-m-d');
            $endDate = Carbon::createFromFormat('Y-m-d', $selectedBatchObj->value('end_date'), 'UTC')->addDays(1)->format('Y-m-d');
        } elseif($batchDate == $currentUTC) {
            $startDate = $selectedBatchObj->value('start_date');
            $endDate = $selectedBatchObj->value('end_date');
        }

        $batchname = $selectedBatchObj->value('batchname');
        $occurrences = $selectedBatchObj->value('occurrence');
        if($occurrences == "Daily") {
            // $startDate = $selectedBatchObj->value('start_date');
            // $endDate = $selectedBatchObj->value('end_date');
            // $batchStartTime = $start_time = Carbon::createFromFormat('H:i:s',$selectedBatchObj->value('start_time'))->format('h A');
            $batchStartTime = $selectedBatchObj->value('start_time');
            
            $date = $startDate;
            while($date <= $endDate) {
                if(isset($topics[$topicsCounter])) {
                    // Save schedules here
                    $liveSession = new LiveSession;
                    $liveSession->course_id = $sessionCourse;
                    $liveSession->topic_id = $topics[$topicsCounter]->topic_id;
                    $liveSession->session_title = 'Session ' . ($topicsCounter + 1) . ": " . $topics[$topicsCounter]->topic_title;
                    $liveSession->batch_id = $sessionBatch;
                    $liveSession->instructor = $sessionInstructor;
                    $liveSession->start_date = Carbon::parse($date)->format('Y-m-d');
                    $liveSession->start_time = $selectedBatchObj->value('start_time');
                    $liveSession->end_time = $selectedBatchObj->value('end_time');
                    $liveSession->startdatetime = Carbon::parse($date)->format('Y-m-d') .' '. $selectedBatchObj->value('start_time');
                    $liveSession->enddatetime = Carbon::parse($date)->format('Y-m-d') .' '. $selectedBatchObj->value('end_time');
                    $liveSession->save();
                    $date = date('Y-m-d',strtotime($date . "+1 days"));
    
    
                    $batchStartDate = Carbon::createFromFormat('Y-m-d', $date)->format('m/d/Y');
                    $batchEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('m/d/Y');
                   
                    $cohortTimezone = $selectedBatchObj->value('time_zone');

                    // Time zone
                    $offset = CustomTimezone::where('name', $instructor->value('timezone'))->value('offset');
                                
                    $offsetHours = intval($offset[1] . $offset[2]);
                    $offsetMinutes = intval($offset[4] . $offset[5]);
                                
                    if($offset[0] == "+") {
                        $sTime = strtotime($batchStartTime) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                    } else {
                        $sTime = strtotime($batchStartTime) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                    }
                                
                    $startTime = date("H:i A", $sTime);

                    $details = [
                        'courseTitle' => $courseTitle,
                        'instructorName'=> $instructorName,
                        'batchname' =>$batchname,
                        'startDate' => $liveSession->start_date,
                        'endDate' => $batchEndDate,
                        'startTime' => $startTime,
                        'sessionTitle'=> $topics[$topicsCounter]->topic_title
                     ];
                     
                    Mail::mailer('infosmtp')->to($instructorEmail)->send(new InstructorMailAfterLiveSessionScheduled($details));
    
                    $notification = new Notification; 
                    $notification->user = $sessionInstructor;
                    $notification->notification = "Hi ". $instructorName.", Your live session " .$topics[$topicsCounter]->topic_title." is scheduled for ". $batchStartDate.".";
                    $notification->is_read = false;
                    $notification->save();
    
                    $students = EnrolledCourse::where('batch_id', $sessionBatch)->get();
                   
                    foreach($students as $student){
                       
                        $studentName = User::find($student->user_id)->firstname.' '.User::find($student->user_id)->lastname;
                        $studentEmail = User::find($student->user_id)->email;
                       
                        $data = [
                            'courseTitle' => $courseTitle,
                            'instructorName'=> $instructorName,
                            'studentName' => $studentName,
                            'startDate' => $liveSession->start_date,
                            'endDate' => $batchEndDate,
                            'sessionTitle'=> $topics[$topicsCounter]->topic_title
                        ];
                    
                        Mail::mailer('infosmtp')->to($studentEmail)->send(new MailAfterLiveSessionScheduled($data));
                        
                        $notification = new Notification; 
                        $notification->user = $student->user_id;
                        $notification->notification = "Dear ".$studentName." , Thank you for your interest in ".$courseTitle.". Live sessions for".$courseTitle." have been scheduled from ". $batchStartDate." to " .$batchEndDate.". We're excited to have you join our live session.";
                        $notification->is_read = false;
                        $notification->save();
                    }
    
    
                    $topicsCounter++;
                } else {
                    $date = date('Y-m-d',strtotime($date . "+1 days"));
                } 
            }
        } else {
            $occArr = explode(',', $occurrences);

            // $startDate = $selectedBatchObj->value('start_date');
            // $endDate = $selectedBatchObj->value('end_date');
            $batchStartTime = $selectedBatchObj->value('start_time');
    
            $date = $startDate;
            while($date <= $endDate) {
                if(in_array(Carbon::createFromFormat('Y-m-d',$date)->format('l'), $occArr) && isset($topics[$topicsCounter])) {
                    // Save schedules here
                    $liveSession = new LiveSession;
                    $liveSession->course_id = $sessionCourse;
                    $liveSession->topic_id = $topics[$topicsCounter]->topic_id;
                    $liveSession->session_title = 'Session ' . ($topicsCounter + 1) . ": " . $topics[$topicsCounter]->topic_title;
                    $liveSession->batch_id = $sessionBatch;
                    $liveSession->instructor = $sessionInstructor;
                    $liveSession->start_date = Carbon::parse($date)->format('Y-m-d');
                    $liveSession->start_time = $selectedBatchObj->value('start_time');
                    $liveSession->end_time = $selectedBatchObj->value('end_time');
                    $liveSession->startdatetime = Carbon::parse($date)->format('Y-m-d') .' '. $selectedBatchObj->value('start_time');
                    $liveSession->enddatetime = Carbon::parse($date)->format('Y-m-d') .' '. $selectedBatchObj->value('end_time');
                    $liveSession->save();
                    
                    $date = date('Y-m-d',strtotime($date . "+1 days"));
    
    
                    $batchStartDate = Carbon::createFromFormat('Y-m-d', $startDate)->format('m/d/Y');
                    $batchEndDate = Carbon::createFromFormat('Y-m-d', $endDate)->format('m/d/Y');
                    $link = base_path() . '/session-view/' . $liveSession->live_session_id;
                    $details=[
                        'courseTitle' => $courseTitle,
                        'instructorName'=> $instructorName,
                        'batchname' =>$batchname,
                        'startDate' => Carbon::parse($date)->format('Y-m-d'),
                        'endDate' => $batchEndDate,
                        'startTime' => $batchStartTime,
                        'sessionTitle'=> $topics[$topicsCounter]->topic_title,
                        'link' => $link
                     ];
                     
                    Mail::mailer('infosmtp')->to($instructorEmail)->send(new InstructorMailAfterLiveSessionScheduled($details));
    
                    $notification = new Notification; 
                    $notification->user = $sessionInstructor;
                    $notification->notification = "Hi ". $instructorName.", Your live session " .$topics[$topicsCounter]->topic_title." is scheduled for".
                                                   $batchStartDate.".";
                    $notification->is_read = false;
                    $notification->save();
    
                    $students = EnrolledCourse::where('batch_id', $sessionBatch)->get();
                   
                    foreach($students as $student){
                       
                        $studentName = User::find($student->user_id)->firstname.' '.User::find($student->user_id)->lastname;
                        $studentEmail = User::find($student->user_id)->email;
                       
                        $data = [
                        'courseTitle' => $courseTitle,
                        'instructorName'=> $instructorName,
                        'studentName' => $studentName,
                        'startDate' => $batchStartDate,
                        'endDate' => $batchEndDate,
                        'link' => $link
                        ];
                    
                        Mail::mailer('infosmtp')->to($studentEmail)->send(new MailAfterLiveSessionScheduled($data));
                        
                        $notification = new Notification; 
                        $notification->user = $student->user_id;
                        $notification->notification = "Dear ".$studentName." , Thank you for your interest in ".$courseTitle.". Live sessions for".$courseTitle." have been scheduled from ". $batchStartDate." to " .$batchEndDate.". We're excited to have you join our live session.";
                        $notification->is_read = false;
                        $notification->save();
                    }
    
    
                    $topicsCounter++;
                } else {
                    $date = date('Y-m-d',strtotime($date . "+1 days"));
                }
            }
        }
        
        
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
        $contentOrder = $request->contentOrder;
        $startSecond = $request->timestamp;
    
        $content = TopicContent::where('topic_content_id', $contentId);
        $topic = Topic::where('topic_id', $content->value('topic_id'));

        $liveSession = LiveSession::where('topic_id', $topic->value('topic_id'))->value('live_session_id');
        $previousPushes = LiveFeedbacksPushRecord::where('topic_id', $topic->value('topic_id'))->where('live_session', $liveSession)->update(['is_expired' => true]);
        $alreadyExists = LiveFeedbacksPushRecord::where('topic_content_id', $contentId)->where('live_session', $liveSession)->count();
        
        if(!$alreadyExists) {
            $pushRecord = new LiveFeedbacksPushRecord;
            $pushRecord->topic_content_id = $contentId;
            $pushRecord->topic_id = $content->value('topic_id');
            $pushRecord->course_id = $topic->value('course_id');
            $pushRecord->live_session = $liveSession;
            $user = Auth::user();
            $instructor =  $user->id;
            $pushRecord->instructor = $instructor;
            $pushRecord->is_pushed = true;
            $pushRecord->is_expired = false;
            $pushRecord->presenting = true;
            $pushRecord->start_second = $startSecond;
            $pushRecord->order = $contentOrder;
            $pushRecord->save();
        }
        return response()->json(['status' => 'success']);
    }

    public function stopPresenting(Request $request) {
        $contentId = $request->content_id;
        $pushRecord = LiveFeedbacksPushRecord::where('topic_content_id', $contentId)->update(['presenting' => false]);
        return response()->json(['status' => 'success']);
    }

    public function showHideContent(Request $request) {
        $contentId = $request->content_id;
        $pushRecord = LiveFeedbacksPushRecord::where('topic_content_id', $contentId);
        if($pushRecord->value('minimized') == true) {
            $pushRecord = LiveFeedbacksPushRecord::where('topic_content_id', $contentId)->update(['minimized' => false]);
        } else {
            $pushRecord = LiveFeedbacksPushRecord::where('topic_content_id', $contentId)->update(['minimized' => true]);
        }
        return response()->json(['status' => 'success']);
    }

    public function getLiveRecord(Request $request) {
        $flag = 0;
        
        $session = LiveSession::where('live_session_id', $request->session);

        $topicId = $session->value('topic_id');
        $presenting = $session->value('presenting');
        $push = LiveFeedbacksPushRecord::where('topic_id', $topicId)->where('live_session', $request->session)->where('is_expired', false);
        $topicContentId = $push->value('topic_content_id');

        $user = Auth::user();
        $student =  $user->id;
        
        $feedbackRecord = StudentFeedbackCount::where('content_id', $topicContentId)->where('live_session', $request->session)->where('student', $student)->get();

        if(count($feedbackRecord) != 0) {
            $flag = 1;
        }

        $content = TopicContent::where('topic_content_id', $topicContentId);
        
        $contentTitle = $content->value('topic_title');

        $presentingContent = LiveFeedbacksPushRecord::where('topic_id', $topicId)->where('live_session', $request->session)->where('presenting', true);
        $presentingContentId = $presentingContent->value('topic_content_id');
        $minimized = $presentingContent->value('minimized');
        return response()->json(['content_id' => $topicContentId, 'content_title' => $contentTitle, 'flag' => $flag, 'presentingContentId' => $presentingContentId, 'minimized' => $minimized, 'screenShare' => $presenting]);
    }

    public function pushFeedbacks(Request $request) {

        $contentId = $request->content_id;
        $session = $request->session;
        $type = $request->type;
        $user = Auth::user();
        $feedbackCountExists = StudentFeedbackCount::where('content_id', $contentId)->where('student', $user->id)->where('live_session', $session)->get();
        if(count($feedbackCountExists)) {
            $feedbackCountExists = StudentFeedbackCount::where('content_id', $contentId)->where('live_session', $session);
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

            $enrolledCourse = EnrolledCourse::where('user_id', $user->id)->where('course_id', $courseId);
            $batchId = $enrolledCourse->value('batch_id');

            $student =  $user->id;
            $feedbackCount->content_id = $contentId;
            $feedbackCount->topic_id = $topicId;
            $feedbackCount->course_id = $courseId;
            $feedbackCount->student = $student;
            $feedbackCount->batch_id = $batchId;
            $feedbackCount->live_session = $session;
            if($type == "positive") {
                $feedbackCount->positive = 1;
                $feedbackCount->negative = 0;
            } else {
                $feedbackCount->positive = 0;
                $feedbackCount->negative = 1;
            }

            $feedbackCount->save();
        }
        $finalCounts = StudentFeedbackCount::where('content_id', $contentId)->where('live_session', $session);
        $positiveCount = $finalCounts->value('positive');
        $negativeCount = $finalCounts->value('negative');
        return response()->json(['positive' => $positiveCount, 'negative' => $negativeCount]);
    }

    public function studentExitAfterFeedback($sessionId, $newTime) {
        
        $attendedSessions = 0;
        $user = Auth::user();
        if($user) {
            $courseId = LiveSession::where('live_session_id', $sessionId)->value('course_id');
            $student =  $user->id;
            $attendance = AttendanceTracker::where('student', $student)->where('live_session_id', $sessionId);
            // if($attendance) {
            //     $timer = $attendance->value('attendance_time') == NULL ? $newTime : $attendance->value('attendance_time') + $newTime;
            // }

            // $attendance->update(['attendance_time' => $timer, 'is_present' => false]);

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

                $existing = StudentAchievement::where('student_id', $student)->where('course_id', $courseId)->where('badge_id', $badgeId)->count();
                if(!$existing) {
                    $student_achievement = new StudentAchievement;
                    $student_achievement->student_id = $student;
                    $student_achievement->badge_id =  $badgeId;
                    $student_achievement->course_id = $courseId;
                    $student_achievement->is_achieved = true;
                    $student_achievement->save();
                }
                

                $topicsCount = Topic::where('course_id', $courseId)->count();
                $trackers = AttendanceTracker::where('student', $student)->get();
                foreach($trackers as $tracker) {
                    $session = LiveSession::where('live_session_id', $tracker->live_session_id);
                    if($session->value('course_id') == $courseId) {
                        $attendedSessions = $attendedSessions + 1;
                    }
                }

            $percent = $attendedSessions * 100 / $topicsCount;

            $percent = $percent > 100 ? 100 : $percent;
            $progress = EnrolledCourse::where('course_id', $courseId)->where('user_id', $student)->update(['progress' => $percent]);
           

            }
                $attendance->update(['attendance_Status' => true ]);
                 
                $liveSessionObj = LiveSession::where('live_session_id', $sessionId);
                $topicId = $liveSessionObj->value('topic_id');
                $existingFeedbacks = StudentFeedbackCount::where('topic_id', $topicId)->where('student', $user->id)->where('live_session', $sessionId)->where('negative', true)->get();

                $topicContents = TopicContent::where('topic_id', $topicId)->get();

                $totalContents = count($topicContents);
                
                $feedbackCounts = count($existingFeedbacks);
                
                $recSettings = GeneralSetting::where('setting', 'recommendation_threshold')->value('value');
                
                $notUnderstoodPercent = 0;
                if($totalContents != 0) {
                    $notUnderstoodPercent = $feedbackCounts * 100 / $totalContents;
                }
                
                if($notUnderstoodPercent > $recSettings) {
                    foreach($topicContents as $cont) {
                        $exists = StudentFeedbackCount::where('content_id', $cont->topic_content_id)->where('student', $user->id)->where('live_session', $sessionId);
                        
                        if($exists->count() == 0) {
                            $feedbackCount = new StudentFeedbackCount;
                            $feedbackCount->content_id = $cont->topic_content_id;
                            $feedbackCount->topic_id = $topicId;
                            $feedbackCount->course_id = $courseId;
                            $feedbackCount->student = $user->id;
                            $feedbackCount->batch_id = $batchId;
                            $feedbackCount->live_session = $sessionId;
                            $feedbackCount->positive = false;
                            $feedbackCount->negative = true;
                            $feedbackCount->save();
                        } else {
                            if($exists->value('positive') == 1) {
                                
                                $exists->delete();
                                $feedbackCount = new StudentFeedbackCount;
                                $feedbackCount->content_id = $cont->topic_content_id;
                                $feedbackCount->topic_id = $topicId;
                                $feedbackCount->course_id = $courseId;
                                $feedbackCount->student = $user->id;
                                $feedbackCount->batch_id = $batchId;
                                $feedbackCount->live_session = $sessionId;
                                $feedbackCount->positive = false;
                                $feedbackCount->negative = true;
                                $feedbackCount->save();
                            } elseif($exists->value('negative') == 1) {

                            }
                        }
                    }
                }
            } else {
                $attendance->update(['attendance_Status' => false ]);
            }

            // Send recommendation mail
            $instructor = AssignedCourse::where('course_id', $courseId)->value('user_id');
            $instructorObj = User::where('id', $instructor);
            $instructorName = $instructorObj->value('firstname') . ' ' . $instructorObj->value('lastname');

            $topicTitle = LiveSession::where('live_session_id', $sessionId)->value('session_title');

            $recDetails = [
                'topic' => $topicTitle,
                'studentName' => $user->firstname .' '. $user->lastname,
                'instructorName' => $instructorName
            ];
            
            Mail::mailer('infosmtp')->to($user->email)->send(new RecommendationMail($recDetails));
            
            Mail::mailer('infosmtp')->to($instructorObj->value('email'))->send(new RecommendationMailInstructor($recDetails));
            return response()->json(['status' => 'success', 'msg' => 'Student closed window', 'course_id' => $courseId]);
        }
    

    public function studentExit(Request $request) {
        $attendedSessions = 0;
        $sessionId = $request->session;
        $newTime = $request->timer;
        
        $user = Auth::user();
        
        if($user) {

            $courseId = LiveSession::where('live_session_id', $sessionId)->value('course_id');

            $student =  $user->id;

            $attendance = AttendanceTracker::where('student', $student)->where('live_session_id', $sessionId);
            if($attendance->count() != 0) {
                $timer = $attendance->value('attendance_time') == NULL ? $newTime : $attendance->value('attendance_time') + $newTime;
            }
            
            $attendance->update(['attendance_time' => $timer, 'is_present' => false]);

            $attendanceSettings = GeneralSetting::where('setting', 'attendance_timer')->value('value');

            $batchId = LiveSession::where('live_session_id', $sessionId)->value('batch_id');
            $batch = CohortBatch::where('id', $batchId);
            $startTime = $batch->value('start_time');
            $endTime = $batch->value('end_time');
            // $startHour = intval($startTime[0] . $startTime[1]);
            // $startMinutes = intval($startTime[3] . $startTime[4]);

            // $endHour = intval($endTime[0] . $endTime[1]);
            // $endMinutes = intval($endTime[3] . $endTime[4]);
            // $totalSeconds = ((60 - $startMinutes) + $endMinutes) + ($endHour - ($startHour + 1)) * 3600;
            
            $firstTime=strtotime($startTime);
            $lastTime=strtotime($endTime);
            $timeDiff=$lastTime-$firstTime;
            $totalSeconds = $timeDiff;

            if(intval($attendance->value('attendance_time')) * 100 / $timeDiff >= intval($attendanceSettings)) {
                $badgeId = AchievementBadge::where('title', 'Starter')->value('id');
                $existing = StudentAchievement::where('student_id', $student)->where('course_id', $courseId)->where('badge_id', $badgeId)->count();
                if(!$existing) {
                    $student_achievement = new StudentAchievement;
                    $student_achievement->student_id = $student;
                    $student_achievement->badge_id =  $badgeId;
                    $student_achievement->course_id =  $courseId;
                    $student_achievement->is_achieved = true;
                    $student_achievement->save();
                }

            $topicsCount = Topic::where('course_id', $courseId)->count();
            $trackers = AttendanceTracker::where('student', $student)->get();
            foreach($trackers as $tracker) {
                $session = LiveSession::where('live_session_id', $tracker->live_session_id);
                if($session->value('course_id') == $courseId) {
                    $attendedSessions = $attendedSessions + 1;
                }
            }

            $percent = $attendedSessions * 100 / $topicsCount;

            $percent = $percent > 100 ? 100 : $percent;

            $progress = EnrolledCourse::where('course_id', $courseId)->where('user_id', $student)->update(['progress' => $percent]);

            if($percent >= 95){
				$current_time = (new DateTime("now", new DateTimeZone('UTC')));
				$completion_date = EnrolledCourse::where('course_id', $courseId)->where('user_id', $student)->update(['course_completion_date' => $current_time]);
                $studentName = $user->firstname.' '.$user->lastname;
                $studentEmail = $user->email;
                $url = base_path() . "/enrolled-course/" . $courseId . "?feedback=true";
                $courseTitle = Course::where('course_title', $courseId)->value('course_title');
                $mailData = [
                    'courseTitle' => $courseTitle,
                    'studentName' => $studentName,
                    'url' => $url
                ];
               
                Mail::mailer('infosmtp')->to($studentEmail)->send(new mailAfterCourseCompletion($mailData));
                
                $notification = new Notification; 
                $notification->user = $user->id;
                $notification->notification = "Hello ". $studentName.", Thank you for completing the course .".$courseTitle." Please feel free to share your feedback by reviewing the course.";
                $notification->is_read = false;
                $notification->save();

                $badgeId = AchievementBadge::where('title', 'Completion')->value('id');
                $existing = StudentAchievement::where('student_id', $student)->where('course_id', $courseId)->where('badge_id', $badgeId)->count();
                if(!$existing) {
                    $student_achievement = new StudentAchievement;
                    $student_achievement->student_id = $student;
                    $student_achievement->badge_id =  $badgeId;
                    $student_achievement->course_id =  $courseId;
                    $student_achievement->is_achieved = true;
                    $student_achievement->save();
                }
            }   
                $attendance->update(['attendance_Status' => true ]);
            } else {
                $attendance->update(['attendance_Status' => false ]);
            }

            return response()->json(['status' => 'success', 'msg' => 'Student closed window', 'course_id' => $courseId]);
        }
    }

    public function getAttendanceList(Request $request) {
            
            $session = $request->session;
            $sharing = $request->sharing;
            $html = "";

            //Instructors name

            if($sharing == "true") {
                $liveSession = LiveSession::where('live_session_id', $session)->update(['presenting' => false]);
            } else {
                $liveSession = LiveSession::where('live_session_id', $session)->update(['presenting' => true]);
            }

            $liveSession = LiveSession::where('live_session_id', $session);

            if($liveSession->value('is_instructor_present')) {
                $instructor = User::where('id', $liveSession->value('instructor'));
                $instructorName = $instructor->value('firstname') . ' ' . $instructor->value('lastname');
                $html = $html . '<div class="think-participant-container"><span class="think-participant-wrapper"><span class="img-container"><img src="/storage/images/'. $instructor->value('image') .'" alt="error">';
                $html = $html . '</span>';
                $html = $html . '<span class="think-participant-name">'. $instructorName .'</span><img style="height:18px;width:15px;margin-bottom:5px;margin-left:10px;" class="me-1 think-w-14_5" src="/storage/icons/icon-feather-user.svg" alt="error"><span class="status-container-outer"><span class="think-online-status-light-container online-status-green"></span>online</span></div>';
            }
            
            $attendanceRec = AttendanceTracker::where('live_session_id', $session)->where('attendance_Status', true)->where('is_present', true)->get();
            
            foreach($attendanceRec as $rec) {
                $student = User::where('id', $rec->student);
                $studentName = $student->value('firstname') . ' ' . $student->value('lastname');
                $html = $html . '<div class="think-participant-container"><span class="think-participant-wrapper"><span class="img-container"><img src="/storage/images/'. $student->value('image') .'" alt="error">';
                $html = $html . '</span>';
                $html = $html . '<span class="think-participant-name">'. $studentName .'</span><span class="status-container-outer"><span class="think-online-status-light-container online-status-green"></span>online</span></div>'; 
            }
            return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function submitSessionFeedback(Request $request) {
        
        $question1 = $request->input('question1');
        $question2 = $request->input('question2');
        $question3 = $request->input('question3');
        $otherFeedback = $request->input('other_feedbacks');
        $studentId = $request->input('student_id');
        $session = $request->input('live_session_id');
        $timer = $request->input('timer');
        $courseId = $request->input('course_id');
        $generalLiveSessionFeedBack = new GeneralLiveSessionFeedback;
        $generalLiveSessionFeedBack->question_1 = $question1;
        $generalLiveSessionFeedBack->question_2 = $question2;
        $generalLiveSessionFeedBack->question_3 = $question3;
        $generalLiveSessionFeedBack->other_feedback = $otherFeedback;
        $generalLiveSessionFeedBack->live_session = $session;
        $generalLiveSessionFeedBack->student = $studentId;

        $generalLiveSessionFeedBack->save();

        
        $this->studentExitAfterFeedback($session, $timer);
        
        return redirect('/enrolled-course' . '/' . $courseId);
    }

    public function saveSessionChat(Request $request) {

        $html = "";

        $message = $request->message;
        $session = $request->session;

        $user = Auth::user();

        if($user) {
            $userId = $user->id;
            $userName = $user->firstname . ' ' . $user->lastname;

            $liveSessionChat = new LiveSessionChat;

            $liveSessionChat->live_session = $session;
            $liveSessionChat->student = $userId;
            $liveSessionChat->user_name = $userName;
            $liveSessionChat->message = $message;

            $liveSessionChat->save();
        }

        $chats = LiveSessionChat::where('live_session', $session)->get();

        foreach($chats as $chat) {
            $html = $html . "<p class='chat-message-body'><b>". $chat->student ."</b><span>" . $chat->message . "</span></p>";
        }

        return $html;
    }

    public function getSessionChat(Request $request) {
        $html = "";
        $user = Auth::user();
        $session = $request->sessionId;
        $chats = LiveSessionChat::where('live_session', $session)->get();
        $chatCount = LiveSessionChat::where('live_session', $session)->where('student', '!=', $user->id)->get();
        $messageCount = count($chatCount);

        foreach($chats as $chat) {
            $sameUser = $user->id == $chat->student ? 'same_user' :  '';
            $html = $html . "<p class='chat-message-body ". $sameUser ."'><b class='participant-name'>". $chat->user_name .": </b><span class='participant-msg'>" . $chat->message . "</span></p>";
        }
        return response()->json(['html' => $html, 'messageCount' => $messageCount]);
    }

    public function getSessionChart(Request $request) {

        $html = "";
        $slNo = 0;
        $session = $request->session;
        $graphData = [];

        $topicId = LiveSession::where('live_session_id', $session)->value('topic_id');

        $topicContentsCount = TopicContent::where('topic_id', $topicId)->count();

        $attendanceTracker = AttendanceTracker::where('live_session_id', $session)->where('attendance_Status', true)->get();

        foreach($attendanceTracker as $data) {
            $likes = 0;
            $dislikes = 0;
            $slNo++;
            $student = User::where('id', $data->student);
            $studentFN = $student->value('firstname');
            $studentLN = $student->value('lastname');

            $studentFeedbackCounts = StudentFeedbackCount::where('student', $data->student)->where('topic_id', $topicId)->get();

            foreach($studentFeedbackCounts as $count) {
                if($count->positive == 1) {
                    $likes++;
                } elseif($count->negative == 1) {
                    $dislikes++;
                }
            }

            $understood = round(($likes * 100) / $topicContentsCount, 1);

            $html = $html . '<tr><td scope="col">' . $slNo . '</td>';
            $html = $html . '<td scope="col" colspan="2">' . $studentFN . '</td>';
            $html = $html . '<td scope="col">' . $studentLN . '</td>';
            $html = $html . '<td scope="col" style="text-align:center;">' . $likes . '</td>';
            $html = $html . '<td scope="col" style="text-align:center;">' . $dislikes . '</td>';
            $html = $html . '<td scope="col" style="text-align:center;">' . $understood . '</td>';
        }

        $topicContents = TopicContent::where('topic_id', $topicId)->get();

        foreach($topicContents as $topicContent) {
            $totalLikes = 0;
            $totalDislikes = 0;
            $contentName = $topicContent->topic_title;
            $feedbacks = StudentFeedbackCount::where('content_id', $topicContent->topic_content_id)->get();
            foreach($feedbacks as $feedback) {
                if($feedback->positive == 1) {
                    $totalLikes++;
                } elseif($feedback->negative == 1) {
                    $totalDislikes++;
                }
            }
            
            array_push($graphData, [$contentName, $totalLikes, $totalDislikes]);
        } 
        
        return response()->json(['status' => 'success', 'msg' => '', 'html' => $html, 'graphData' => $graphData]);
    }

    public function createRecommendationSession(Request $request, $student, $topic) {
        
        $userObj = Auth::user();
        $batchId = $request->batchId;
        $topicId = $topic;
        
        $courseId = Topic::where('topic_id', $topicId)->value('course_id');

        $instructor = AssignedCourse::where('course_id', $courseId)->value('user_id');

        $topicContent = TopicContent::where('topic_content_id', $topicId)->value('topic_title');
        
        $participants = [];
        $content = TopicContent::where('topic_content_id', $topicId)->get();

        $feedbackQ1 = GeneralSetting::where('setting', 'feedback_question_1')->value('value');
        $feedbackQ2 = GeneralSetting::where('setting', 'feedback_question_2')->value('value');
        $feedbackQ3 = GeneralSetting::where('setting', 'feedback_question_3')->value('value');
        
        if($userObj) {
            if($userObj->role_id == 2) {
                $userId = $userObj->id;

                $singleSessionUser = SingleSessionUser::where('student', $userId)->where('instructor', $instructor)->update(['student_present' => true]);
            } else {
                $userId = $student;
                $singleSession = SingleSession::where('topic_content_id', $topicId)->where('student', $student);
                
                if($singleSession->count() == 0) {
                    $singleSession = new SingleSession;
                    $singleSession->topic_content_id = $topicId;
                    $singleSession->student = $student;
                    $singleSession->is_screen_shared = false;
                    $singleSession->save();
                }
                
                
                $singleSessionUser = SingleSessionUser::where('session', $singleSession->value('id'))->get();
                if(count($singleSessionUser) == 0) {
                    $singleSessionUser = new SingleSessionUser;
                    $singleSessionUser->session = $singleSession->value('id');
                    $singleSessionUser->student = $userId;
                    $singleSessionUser->instructor = $userObj->id;
                    $singleSessionUser->instructor_present = true;
                    $singleSessionUser->save();
                } else {
                    $singleSessionUser = SingleSessionUser::where('session', $singleSession->value('id'))->update(['instructor_present' => true]); 
                }
            }
            
            $userTypeLoggedIn =  UserType::find($userObj->role_id)->user_role;
            

            return view('Instructor.SessionScreen.1_on_1_session_screen', [
                'topic_title' => $topicContent,
                'contents' => $content,
                'userType' => $userTypeLoggedIn,
                'courseId' => $courseId,
                'userId' => $userId,
                'topicId' => $topicId,
                'feedbackQ1' => $feedbackQ1,
                'feedbackQ2' => $feedbackQ2,
                'feedbackQ3' => $feedbackQ3,
                'batchId' => $batchId
            ]);
        } else {
            return redirect('/403');
        }
    }

    public function buildToken1v1(Request $request, $topic, $user) {
        
        $session = $topic . '010' . $user;
        $studentGeneratedId = $request->user;
        
        $sessionTitle = TopicContent::where('topic_content_id', $topic)->value('topic_title');

        if(strlen($sessionTitle) > 60) {
            $sessionTitle = substr($sessionTitle, 0, 55) . '..';
        } else {
            $sessionTitle = $sessionTitle;
        }

        $userObj = Auth::user();
        $user = "1005" . strval($userObj->id);
        
        
        if($userObj->role_id == 2) {
            $role = self::RoleSubscriber;
            $roleName = $userObj->firstname;
            
        } else {
            $role = self::RolePublisher;
            $roleName = "Instructor";

            $userObj = User::where('id', $studentGeneratedId);
            $studentEmail = $userObj->value('email');
            
            $topicId = TopicContent::where('topic_content_id', $topic)->value('topic_id');
            $courseId = Topic::where('topic_id', $topicId)->value('course_id');
            $course = Course::where('id', $courseId);
            $courseTitle = $course->value('course_title');

            $assignedInstructor = AssignedCourse::where('course_id', $courseId)->value('user_id');
            $instructorObj = User::where('id', $assignedInstructor);
            $instructorName = $instructorObj->value('firstname') . ' ' . $instructorObj->value('lastname');

            $enrolledBatch = EnrolledCourse::where('course_id', $courseId)->where('user_id', $userObj->value('id'))->value('batch_id');

            $url = url('/') . "/1-on-1/" . $userObj->value('id') . "/" . $topic . "?batchId=" . $enrolledBatch;

            $details = [
                'name' => $userObj->value('firstname') . ' ' . $userObj->value('lastname'),
                'session' => $sessionTitle,
                'email' => $studentEmail,
                'course' => $courseTitle,
                'instructorName' => $instructorName,
                'url' => $url
            ];
            
            Mail::mailer('infosmtp')->to($studentEmail)->send(new OneOnOneMail($details));
        }
        
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds + 1800;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        
        return response()->json(['token' => $generatedToken, 'appId' => self::appId, 'uid' => $user, 'rolename' => $roleName, 'roomid' => strval('101' . $session), 'channel' => $sessionTitle, 'role' => $role , 'duration' => $expireTimeInSeconds]);
    
    }

    public function startScreenshare(Request $request) {
        $topic = $request->topicId;
        $student = $request->student;

        $singleSession = SingleSession::where('topic_content_id', $topic)->where('student', $student)->update(['is_screen_shared' => true]);

        return response()->json(['status' => 'success']);
    }

    public function getSessionLiveRecord(Request $request) {
        $topic = $request->topicId;
        $student = $request->student;

        $singleSession = SingleSession::where('topic_content_id', $topic)->where('student', $student);

        $pushRecord = SingleSessionPushRecord::where('topic_content_id', $topic)->where('student', $student)->value('is_presenting');

        $isScreenShared = $singleSession->value('is_screen_shared');

        $docUrl = public_path() . "\storage\study_material\\" . TopicContent::where('topic_content_id', $topic)->value('document');
       
        return response()->json(['screenShare' => $isScreenShared, 'is_presenting' => $pushRecord, 'docUrl' => $docUrl]);
    }

    public function pushSessionLiveRecord(Request $request) {
        $topicId = $request->topicId;
        $student = $request->student;

        $pushRecord = SingleSessionPushRecord::where('topic_content_id', $topicId)->where('student', $student)->get();
        if(count($pushRecord) == 0) {
            $pushRecord = new SingleSessionPushRecord;
            $pushRecord->topic_content_id = $topicId;
            $pushRecord->student = $student;
            $pushRecord->is_presenting = true;
            $pushRecord->save();
        } else {
            $pushRecord = SingleSessionPushRecord::where('topic_content_id', $topicId)->where('student', $student)->update(['is_presenting' => true]);
        }

        return response()->json(['status' => 'success']);
    }

    public function stopContentPresenting(Request $request) {
        $topicId = $request->topicId;
        $student = $request->student;

        $pushRecord = SingleSessionPushRecord::where('topic_content_id', $topicId)->where('student', $student)->update(['is_presenting' => false]);

        return response()->json(['status' => 'success']);
    }

    public function getSessionAttendanceList(Request $request) {
        $topic = $request->topic;
        $student = $request->student;
        $html = "";

        $singleSession = SingleSession::where('topic_content_id', $topic)->where('student', $student)->get();
        $singleSessionUser = SingleSessionUser::where('session', $singleSession[0]->id)->get();
            
        if($singleSessionUser[0]->instructor_present == true) {
            $user = User::where('id', $singleSessionUser[0]->instructor);
            $name = $user->value('firstname') . ' ' . $user->value('lastname');
            $html = $html . '<div class="think-participant-container instructor"><span class="think-participant-wrapper"><span class="img-container"><img src="/storage/images/'. $user->value('image') .'" alt="error">';
            $html = $html . '</span>';
            $html = $html . '<span class="think-participant-name">'. $name .'</span><img style="height:18px;width:15px;margin-bottom:5px;margin-left:10px;" src="/storage/icons/icon-feather-user.svg" alt="error"><span class="status-container-outer"><span class="think-online-status-light-container online-status-green"></span>online</span></div>'; 
        }
        if($singleSessionUser[0]->student_present == true) {
            $user = User::where('id', $singleSessionUser[0]->student);
            $name = $user->value('firstname') . ' ' . $user->value('lastname');
            $html = $html . '<div class="think-participant-container"><span class="think-participant-wrapper"><span class="img-container"><img src="/storage/images/'. $user->value('image') .'" alt="error">';
            $html = $html . '</span>';
            $html = $html . '<span class="think-participant-name">'. $name .'</span><span class="status-container-outer"><span class="think-online-status-light-container online-status-green"></span>online</span></div>'; 
        }
        return response()->json(['status' => 'success', 'html' => $html]);
    }

    public function saveSingleSessionChat(Request $request) {
        $topic = $request->topic;
        $student = $request->student;
        $message = $request->message;

        $singleSession = SingleSession::where('topic_content_id', $topic)->where('student', $student)->get();
        $sessionId = $singleSession[0]->id;
        $userObj = Auth::user();

        if($userObj) {
            $sessionMessage = new SingleSessionChat;
            $sessionMessage->session = $sessionId;
            $sessionMessage->sender = $userObj->id;
            $sessionMessage->message = $message;
            $sessionMessage->save();
        }

        return response()->json(['status' => 'success']);
    }

    public function getSingleSessionChat(Request $request) {
        
        $html = "";
        $loggedInUser = Auth::user();
        $topic = $request->topic;
        $student = $request->student;

        $singleSession = SingleSession::where('topic_content_id', $topic)->where('student', $student)->get();
        
        $chats = SingleSessionChat::where('session', $singleSession[0]->id)->get();
        
        foreach($chats as $chat) {
            $sameUser = $loggedInUser->id == $chat->sender ? 'same_user' :  '';
            $user = User::find($chat->sender);

            $name = $user->firstname . " " . $user->lastname;
            $html = $html . "<p class='chat-message-body ". $sameUser ."'><b class='participant-name'>". $name .": </b><span class='participant-msg'>" . $chat->message . "</span></p>";
        }
        
        return response()->json(['html' => $html]);
    }

    public function viewVideoAgain(Request $request, $session) {

        $recommendation = $request->recommendation;
        $recContent = $request->content;

        $loggedInUser = Auth::user();
        $studentId = $loggedInUser->id;

        $recStartTime = 0;
        
        $contentsArray = [];
        $liveSession = LiveSession::where('live_session_id', $session);

        $topicId = $liveSession->value('topic_id');
        $courseId = $liveSession->value('course_id');
        $topic = Topic::where('topic_id', $topicId)->value('topic_title');

        if($recContent == null) {
            $topicContents = TopicContent::where('topic_id', $topicId)->get();
        } else {
            $recStartTime = LiveFeedbacksPushRecord::where('topic_content_id', $recContent)->value('start_second');
            $topicContents = TopicContent::where('topic_content_id', $recContent)->get();
        }

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
        
        $course = Course::where('id', $courseId)->value('course_title');
        $session = "22" . $session;
        $userObj = Auth::user();
        $user = "1005" . strval($userObj->id);
        $expireTimeInSeconds = 1800;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds + 1800;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        return view('view_again', [
           'session' => $session,
           'appId' => self::appId,
           'token' => $generatedToken,
           'uid' => $user,
           'topic' => $topic,
           'course' => $course,
           'courseId' => $courseId,
           'contents' => $contentsArray,
           'recommendation' => $recommendation,
           'recStartTime' => $recStartTime
        ]);
    }

    public function deleteSession(Request $request) {
        $session = $request->sessionId;
        $liveSession = LiveSession::where('live_session_id', $session)->delete();
        return response()->json(['status' => 'success']);
    }
}