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
use App\Models\Topic;
use App\Models\CohortBatch;
use App\Models\TopicContent;
use App\Models\LiveSession;
use Illuminate\Support\Facades\DB;

require_once "AccessToken.php";

class RtmTokenGeneratorController extends Controller
{
    const RoleAttendee = 0;
    const RolePublisher = 1;
    const RoleSubscriber = 2;
    const RoleAdmin = 101;
    const appId = "88a4d4d0cb874afd82ada960cdcc1b1f";
    const appCertificate = "3b0fc46ccb5c4fc68fd98bd0d9e60131";


    public function index(Request $request) {
        $userObj = Auth::user();
        
        if($userObj) {
            return view('Agora.SessionScreen.live_session_screen');
        } else {
            return redirect('/403');
        }
    }

    public function buildToken(Request $request) {
        
        $userObj = Auth::user();
        $user = "1005" . strval($userObj->id);
        
        if($userObj->role_id == 2) {
            $role = self::RoleSubscriber;
            $roleName = $userObj->firstname;
        } else {
            $role = self::RolePublisher;
            $roleName = "Instructor";
        }
        
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        return response()->json(['token' => $generatedToken, 'appId' => self::appId, 'uid' => $user, 'rolename' => $roleName, 'roomid' => strval(rand(101, 500)), 'channel' => 'Live Session', 'role' => $role , 'duration' => $expireTimeInSeconds]);
        
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
        $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
        return view('Agora.ScheduleScreens.schedule_session', [
            'courses' => $courses,
            'instructors' => $instructors,
            'sessions' => $sessions,
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
            $batchHtml = $batchHtml . "<option value=" . $batch->id . ">" . $batch->batchname . "</option>";
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
}