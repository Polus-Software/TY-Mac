<?php



namespace App\Http\Controllers\AgoraIntegrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use DateTimeZone;

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
        return view('Agora.SessionScreen.live_session_screen');
    }

    public function buildToken(Request $request) {
        $user = "1005";
        $role = self::RolePublisher;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $token = AccessToken::init(self::appId, self::appCertificate, $user, "");
        $Privileges = AccessToken::Privileges;
        $token->addPrivilege($Privileges["kRtmLogin"], $privilegeExpiredTs);
        $generatedToken = $token->build();
        return response()->json(['token' => $generatedToken, 'appId' => self::appId, 'uid' => $user, 'rolename' => 'Instructor', 'roomid' => strval(rand(101, 500)), 'channel' => 'Live Session', 'role' => $role , 'duration' => $expireTimeInSeconds]);
    }
}