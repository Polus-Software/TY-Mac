<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\EnrolledCourse;
use App\Models\Filter;
use App\Models\UserType;
use App\Models\GeneralSetting;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\CohortBatch;
use App\Models\LiveSession;
use App\Models\AttendanceTracker;


class AdminController extends Controller
{
    public function viewAllStudents()
    {
        $studentDetails = [];

        $students = User::where('role_id', 2)->get();
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;

        foreach ($students as $student) {
            $enrolledCourses = EnrolledCourse::where('user_id', $student->id)->get();
            $enrolledCourseCount = count($enrolledCourses);

            $studentData = array(
                'id' => $student->id,
                'firstname' => $student->firstname,
                'lastname' => $student->lastname,
                'email' => $student->email,
                'image' => $student->image,
                'enrolledCourseCount' => $enrolledCourseCount
            );
            array_push($studentDetails, $studentData);
        }
        $studentDetailsObj = collect($studentDetails);
        $studentDatas = $this->paginate($studentDetailsObj, 10);
        $studentDatas->withPath('');

        return view('Auth.Admin.AdminDashboard', [
            'studentDatas' => $studentDatas,
            'userType' => $userType
        ]);
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function viewStudent(Request $request)
    {
        try {
            $studentId = $request->input('student_id');
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($studentId) {
                $student = User::where('id', $studentId);
                $enrolled_courses = DB::table('enrolled_courses')
                    ->join('courses', 'enrolled_courses.course_id', '=', 'courses.id')
                    ->where('enrolled_courses.user_id', $studentId)
                    ->get();
                if ($student) {
                    $data = [
                        'id' => $student->value('id'),
                        'firstname' => $student->value('firstname'),
                        'lastname' => $student->value('lastname'),
                        'email' => $student->value('email')
                    ];
                }
            }
            return view('Auth.Admin.student.view_student', [
                'student_id' => $studentId,
                'studentDetails' => $data,
                'userType' => $userType,
                'enrolled_courses' => $enrolled_courses
            ]);
        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }

    public function editStudent(Request $request)
    {
        try {
            $studentId = $request->input('student_id');
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($studentId) {
                $student = User::where('id', $studentId);
                $enrolled_courses = DB::table('enrolled_courses')
                    ->join('courses', 'enrolled_courses.course_id', '=', 'courses.id')
                    ->where('enrolled_courses.user_id', $studentId)
                    ->get();
                if ($student) {
                    $data = [
                        'id' => $student->value('id'),
                        'firstname' => $student->value('firstname'),
                        'lastname' => $student->value('lastname'),
                        'email' => $student->value('email')
                    ];
                }
            }
            return view('Auth.Admin.student.edit_student', [
                'student_id' => $studentId,
                'studentDetails' => $data,
                'userType' => $userType,
                'enrolled_courses' => $enrolled_courses
            ]);
        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }


    

    public function updateStudent(Request $request)
    {
        $updateData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|'
        ]);
        $studentId = $request->input('student_id');
        $student = User::findOrFail($studentId);
        $student->firstname = $request['firstname'];
        $student->lastname = $request['lastname'];
        $student->email = $request['email'];
        $student->save();
        return redirect()->route('view-student', ['student_id' => $studentId]);
    }


    public function destroyStudent(Request $request)
    {

        $studentId = $request->studentId;
        $students = user::find($studentId);
        $students->delete();

        return response()->json(['status' => 'success', 'message' => ' Record Deleted successfully']);
    }

    public function adminSettings(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $userType =  UserType::find($user->role_id)->user_role;
            $filters = Filter::all();

            $recSettings = GeneralSetting::where('setting', 'recommendation_threshold')->value('value');
            $f1Settings = GeneralSetting::where('setting', 'feedback_question_1')->value('value');
            $f2Settings = GeneralSetting::where('setting', 'feedback_question_2')->value('value');
            $f3Settings = GeneralSetting::where('setting', 'feedback_question_3')->value('value');
            $attendanceSettings = GeneralSetting::where('setting', 'attendance_timer')->value('value');

            return view('Auth.Admin.AdminSettings', [
                'userType' => $userType,
                'filters' => $filters,
                'rec' => $recSettings,
                'f1Question' => $f1Settings,
                'f2Question' => $f2Settings,
                'f3Question' => $f3Settings,
                'attendanceSetting' => $attendanceSettings
            ]);
        } else {
            return redirect('/403');
        }
    }

    public function changeFilterStatus(Request $request)
    {
        $filterId = $request->filter_id;
        $isEnabled = $request->is_enabled;

        $filter = Filter::find($filterId);
        if ($isEnabled == "true") {
            $filter->is_enabled = true;
        } else {
            $filter->is_enabled = false;
        }
        $filter->save();
        return response()->json(['status' => 'success', 'message' => ' Changed status successfully']);
    }

    public function saveThreshold(Request $request) {
        $threshold = $request->threshold;
        $feedback1 = $request->feedback1;
        $feedback2 = $request->feedback2;
        $feedback3 = $request->feedback3;
        $attendance = $request->attendance;
        $settingRec = GeneralSetting::where('setting', 'recommendation_threshold')->get();
        $settingFQ1 = GeneralSetting::where('setting', 'feedback_question_1')->get();
        $settingFQ2 = GeneralSetting::where('setting', 'feedback_question_2')->get();
        $settingFQ3 = GeneralSetting::where('setting', 'feedback_question_3')->get();
        $settingAttendance = GeneralSetting::where('setting', 'attendance_timer')->get();

        if(count($settingRec)) {
            $settingId = GeneralSetting::where('setting','recommendation_threshold')->value('id');
            $setting = GeneralSetting::find($settingId);
            $setting->value = $threshold;
            $setting->save();
        } else {
            $newSettings = new GeneralSetting;
            $newSettings->setting = 'recommendation_threshold';
            $newSettings->value = $threshold;
            $newSettings->save();
        }

        if(count($settingFQ1)) {
            $settingId = GeneralSetting::where('setting','feedback_question_1')->value('id');
            $setting = GeneralSetting::find($settingId);
            $setting->value = $feedback1;
            $setting->save();
        } else {
            $newSettings = new GeneralSetting;
            $newSettings->setting = 'feedback_question_1';
            $newSettings->value = $feedback1;
            $newSettings->save();
        }

        if(count($settingFQ2)) {
            $settingId = GeneralSetting::where('setting','feedback_question_2')->value('id');
            $setting = GeneralSetting::find($settingId);
            $setting->value = $feedback2;
            $setting->save();
        } else {
            $newSettings = new GeneralSetting;
            $newSettings->setting = 'feedback_question_2';
            $newSettings->value = $feedback2;
            $newSettings->save();
        }

        if(count($settingFQ3)) {
            $settingId = GeneralSetting::where('setting','feedback_question_3')->value('id');
            $setting = GeneralSetting::find($settingId);
            $setting->value = $feedback3;
            $setting->save();
        } else {
            $newSettings = new GeneralSetting;
            $newSettings->setting = 'feedback_question_3';
            $newSettings->value = $feedback3;
            $newSettings->save();
        }

        if(count($settingAttendance)) {
            $settingId = GeneralSetting::where('setting','attendance_timer')->value('id');
            $setting = GeneralSetting::find($settingId);
            $setting->value = $attendance;
            $setting->save();
        } else {
            $newSettings = new GeneralSetting;
            $newSettings->setting = 'attendance_timer';
            $newSettings->value = $attendance;
            $newSettings->save();
        }

        return response()->json(['status' => 'success', 'message' => 'Updated settings successfully']);
        
        
    }

    public function courseSearch(Request $request) {

        $courseDetails = [];
        $searchTerm = $request->search;
        $allCourseCategory = CourseCategory::all();
        $courses = Course::where('course_title', 'LIKE', '%' . $searchTerm . '%')->get();

        $filters = Filter::all();
        $userType =  UserType::where('user_role', 'instructor')->value('id');

        $instructors = User::where('role_id', $userType)->get();

        foreach($courses as $course)
        {
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
            $duration = $course->course_duration . "h";
       
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_thumbnail_image' => $course->course_thumbnail_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
                'rating' => $course->course_rating,
                'duration' => $duration
            );
            array_push($courseDetails, $courseData);
        }
        $courseDetailsObj = collect($courseDetails);
        $courseDatas = $this->paginate($courseDetailsObj);
        $courseDatas->withPath('');
        return view('Student.allCourses', ['courseDatas' => $courseDatas, 'allCourseCategory' => $allCourseCategory, 'filters' => $filters, 'instructors' => $instructors, 'searchTerm' => $searchTerm]);

    }
    
    public function attendanceTrackerView(Request $request) {

        $courses = Course::all();
        $user = Auth::user();
        if($user) {
            $userType =  UserType::find($user->role_id)->user_role;
            return view('Auth.Admin.attendance_tracker_view', ['userType' => $userType, 'courses' => $courses]);
        }   
    }

    public function getAttendanceData(Request $request) {
        $user = Auth::user();
        if($user) {
            $userType =  UserType::find($user->role_id)->user_role;
            return view('Auth.Admin.attendance_tracker_view', ['userType' => $userType]);
        }   
    }

    public function getAttendanceBatches(Request $request) {
        $courseId = $request->courseId;

        $batches = CohortBatch::where('course_id', $courseId)->get();

        return response()->json(['status' => 'success', 'msg' => 'Batches retrieved', 'batches' => $batches]);
    }

    public function getAttendanceSessions(Request $request) {
        $batchId = $request->batchId;

        $sessions = LiveSession::where('batch_id', $batchId)->get();

        return response()->json(['status' => 'success', 'msg' => 'Batches retrieved', 'sessions' => $sessions]);

    }

    public function getAttendanceTable(Request $request) {
        $sessionId = $request->sessionId;

        $tracker = AttendanceTracker::where('live_session_id', $sessionId)->get();
        $attendanceSettings = GeneralSetting::where('setting', 'attendance_timer')->value('value');

        $session = LiveSession::where('live_session_id', $sessionId);

        $batch = CohortBatch::where('id', $session->value('batch_id'));

        $startTime = $batch->value('start_time');
        $endTime = $batch->value('end_time');
        
        $firstTime=strtotime($startTime);
        $lastTime=strtotime($endTime);
        $timeDiff=$lastTime-$firstTime;
        $totalSeconds = $timeDiff;
        
        $slNo = 0;
        $html = "";

        foreach($tracker as $data) {
            $attendanceTimer = $data->attendance_time;
            $percent = ($attendanceTimer * 100) / $totalSeconds; 

            $hours = floor($attendanceTimer / 3600);
            $minutes = floor(($attendanceTimer / 60) % 60);
            $seconds = $attendanceTimer % 60;
            $slNo = $slNo + 1;
            $student = User::where('id', $data->student);
            $studentFName = $student->value('firstname');
            $studentLName = $student->value('lastname');
            $html = $html . '<tr id=' . $data->id . '>';
            $html = $html . '<td class="align-middle text-center">' . $slNo . '</td>';
            $html = $html . '<td class="align-middle text-center">';
            $html = $html . '<img src="/storage/images/' . $student->value('image') . '" class="rounded-circle" alt="" style="width:40px; height:40px;"></td>';    
            $html = $html .  '<td class="align-middle">'. $studentFName .'</td>';
            $html = $html .  '<td class="align-middle">' . $studentLName . '</td>';
            $status = $data->attendance_Status == 1 ?  '<span class="badge rounded-pill bg-success text-dark" style="color:white !important;">Present</span>' : '<span class="badge rounded-pill bg-danger text-dark" style="color:white !important;">Absent</span>';
            
            $html = $html .  '<td class="align-middle text-center">' . $hours . ':' . $minutes . ':' . $seconds . '</td>';
            $html = $html .  '<td class="align-middle text-center">' . round($percent,2) . '%</td>';
            $html = $html .  '<td class="align-middle text-center">'. $status .'</td></tr>'; 
                
                
              
        }
        
        return response()->json(['status' => 'success', 'msg' => 'Batches retrieved', 'html' => $html]);
    }
    
}
