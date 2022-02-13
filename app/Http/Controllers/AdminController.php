<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\EnrolledCourse;
use App\Models\GeneralCourseFeedback;
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
use Hash;
use Illuminate\Validation\Rule;


class AdminController extends Controller
{
    public function viewAllStudents()
    {
        $current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $num_rec_per_page = 10;
        $start_from = ($current_page-1) * $num_rec_per_page+1;
        $studentDetails = [];

        //$students = User::where('role_id', 2)->get();
        $students = DB::table('users')->where('role_id', '=', 2)->get();
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
                'deleted_at' => $student->deleted_at,
                'enrolledCourseCount' => $enrolledCourseCount
            );
            array_push($studentDetails, $studentData);
        }
        $studentDetailsObj = collect($studentDetails);
        $studentDetailsObj = collect($studentDetails);
        $studentDatas = $this->paginate($studentDetailsObj, 10);
        $studentDatas->withPath('');

        return view('Auth.Admin.AdminDashboard', [
            'studentDatas' => $studentDatas,
            'userType' => $userType,
            'start_from' => $start_from
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
            //'password' => 'required'
        ]);
       
        $studentId = $request->input('student_id');
        $student = User::findOrFail($studentId);
        $student->firstname = $request['firstname'];
        $student->lastname = $request['lastname'];
        $student->email = $request['email'];
		if($request->password != '')
			$student->password = Hash::make($request->password);
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

            $duration = $course->course_duration;
            $hours = intval($duration);
            $minutesDecimal = $duration - $hours;
            $minutes = ($minutesDecimal/100) * 6000;
        
            $duration = $hours . 'h ' . $minutes . 'm';
			$ratings = 0;
            $ratingsSum = 0;
            $ratingsCount = 0;

            if($course->use_custom_ratings) {
                $ratings = $course->course_rating;
            } else {
                $generalCourseFeedbacks = GeneralCourseFeedback::where('course_id', $course->id)->get();
                foreach($generalCourseFeedbacks as $generalCourseFeedback) {
                    $ratingsSum = $ratingsSum + $generalCourseFeedback->rating;
                    $ratingsCount++;
                }

                if($ratingsCount != 0) {
                    $ratings = intval($ratingsSum/$ratingsCount);
                }
            }
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_thumbnail_image' => $course->course_thumbnail_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
				        'use_custom_ratings' => $course->use_custom_ratings,
                //'rating' => $course->course_rating,
				        'rating' => $ratings,
                'duration' => $duration,
				        'ratingsCount' => $ratingsCount
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
        
        if(count($tracker)) {
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
        } else {
            $html = '<tr><td colspan="7" class="align-middle text-center"><h6>No data to be shown.</h6></td></tr>';
        }
        
        return response()->json(['status' => 'success', 'msg' => 'Batches retrieved', 'html' => $html]);
    }
    

    public function viewAllAdmin(){

        $userType = UserType::where('user_role', 'admin')->value('id');
        $user = Auth::user();

        if($user){
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $admins = DB::table('users')
                ->where('role_id', '=', $userType)
                ->where('deleted_at', '=', NULL)
                ->paginate(10);
        
        return view('Auth.Admin.manage_admin', [
            'admins' => $admins,
            'userType' => $userTypeLoggedIn
        ]);
        }else{
            return redirect('/403');
        }
        
        
    }

    public function viewAdmin(Request $request){

        $adminId = $request->input('admin_id');
        if ($adminId) {
            $admin = User::where('id', $adminId);
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($admin) {
                $data = [
                    'admin_id' => $admin->value('id') ,
                    'firstname' => $admin->value('firstname') ,
                    'lastname' => $admin->value('lastname'),
                    'email' => $admin->value('email')];

                return view('Auth.Admin.view_admin', [
                    'adminDetails' => $data,
                    'userType' => $userType
                ]);
            }
        }

    }


    public function addAdmin() {
        $userType = 'admin';
        return view('Auth.Admin.create_admin', [
            'userType' => $userType
        ]);

    }


    public function saveAdmin(Request $request) {

        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        $userType = UserType::where('user_role', 'admin')->value('id');
        $admin = new User;
        $admin->firstname = $request->input('firstname');
        $admin->lastname = $request->input('lastname');
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->role_id = $userType;
        $admin->timezone = "UTC";
        $admin->save();
        return redirect()->route('manage-admin');
    }


    public function editAdmin(Request $request) {
        $adminId = $request->input('admin_id');
        if ($adminId) {
            $admin = User::where('id', $adminId);
            $user = Auth::user();
            $userType =  UserType::find($user->role_id)->user_role;
            if ($admin) {
                $data = [
                    'admin_id' => $admin->value('id') ,
                    'firstname' => $admin->value('firstname') ,
                    'lastname' => $admin->value('lastname'),
                    'email' => $admin->value('email')];
                return view('Auth.Admin.create_admin', [
                    'adminDetails' => $data,
                    'userType' => $userType
                ]);
            }
        }
    }


    public function updateAdmin(Request $request) {
        $adminId = $request->input('admin_id');
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => ['required', Rule::unique('users')->ignore($adminId)],
        ]);

        $userType = UserType::where('user_role', 'admin')->value('id');        
        $firstName = $request->input('firstname');
        $lastName = $request->input('lastname');
        $email = $request->input('email');
        $password = $request->input('password');
        
            if ($adminId) {
            $admin = User::find($adminId);
            if ($admin) {
                $admin->firstname = $firstName;
                $admin->lastname = $lastName;
                $admin->email = $email;
                if($password != ''){
                    $admin->password = Hash::make($request->input('password'));
                }
                $admin->save();
                return redirect()->route('view-admin', ['admin_id' => $adminId]);
            }
        }
    }


    public function deleteAdmin(Request $request) {
        $html = '';
        $slNo = 1;
        $userId = $request->input('user_id');
        $userType = UserType::where('user_role', 'admin')->value('id');
        if ($userId) {
            $admin = User::find($userId);
            if ($admin) {
                $admin->delete();

                $admins = DB::table('users')
                ->where('role_id', '=', $userType)
                ->where('deleted_at', '=', NULL)
                ->get();

                foreach($admins as $admin) {
                    $html = $html . '<tr id="' . $admin->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo . '</th>';
                    $html = $html . '<td class="align-middle" colspan="2">' . $admin->firstname . ' ' . $admin->lastname . '</td>';
                    $html = $html . '<td class="align-middle">' . $admin->email . '</th>';
                    $html = $html . '<td class="align-middle">' . Carbon::createFromFormat("Y-m-d H:i:s", $admin->created_at)->format("F d, Y") . '</td>';
                    $html = $html . '<td class="text-center align-middle"><a href="" title="View admin"><i class="fas fa-eye"></i></a>';
                    $html = $html . '<a  href="" title="Edit admin"><i class="fas fa-pen"></i></a>';
                    $html = $html . '<a data-bs-toggle="modal" data-bs-target="#delete_admin_modal" data-bs-id="' . $admin->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
                    $slNo = $slNo + 1;
                }
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error', 'html' => '']);
    }
	/* by jibi for getting user reviews starts */
	public function getUserReviews(){
        $current_page = isset($_REQUEST['page'])?$_REQUEST['page']:'1';
        $num_rec_per_page = 10;
        $start_from = ($current_page-1) * $num_rec_per_page+1;
		$userfeedbacks = [];
        $generalCourseFeedbacks = DB::table('general_course_feedback')
									->select('general_course_feedback.id', 'general_course_feedback.course_id','courses.course_title','general_course_feedback.user_id','users.firstname','users.lastname','general_course_feedback.rating','general_course_feedback.comment','general_course_feedback.is_moderated')
									->join('courses', 'general_course_feedback.course_id', '=', 'courses.id')
									->join('users', 'general_course_feedback.user_id', '=', 'users.id')
									->get();
        $user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
		$totalCount = $generalCourseFeedbacks->count();
		foreach ($generalCourseFeedbacks as $feedback) {
			$comments = strip_tags($feedback->comment);
			if (strlen($comments) > 30) {
				// truncate string
				$firstpart = substr($comments, 0, 30);
				$firstpart = $firstpart;
				$secondpart = substr($comments, 30);
			}
			else{
				$firstpart = $feedback->comment;
				$secondpart = '';
			}
            $userfeedback = array(
                'id' => $feedback->id,
                'course_id'=> $feedback->course_id,
				'course_name'=> $feedback->course_title,
				'user_id'=> $feedback->user_id,
				'user_name'=> $feedback->firstname.' '.$feedback->lastname,
				'rating'=> $feedback->rating,
				'comment'=> $feedback->comment,
				'is_moderated'=>$feedback->is_moderated,
				'firstpart' => $firstpart,
				'secondpart' => $secondpart,
            );
            array_push($userfeedbacks, $userfeedback);
        }
        $feedbackObj = collect($userfeedbacks);
        $userfeedbacks = $this->paginate($feedbackObj, 10);
		$userfeedbacks->withPath('');
		//var_dump($userfeedbacks);
		return view('Auth.Admin.view_reviews', [
            'userfeedbacks' => $userfeedbacks,
			'userType' => $userType,
			'course' => '',
			'comment' => '',
			'rating' => '',
            'totalCount' => $totalCount,
            'start_from' => $start_from
        ]);
	}
	public function getUserReviewsFilter(Request $request){
		$comment = $request->input('comment');
		$rating = $request->input('rating');
		$course = $request->input('course');
		$userfeedbacks = [];
		$matchThese = '';
		if(!empty($comment) && !empty($rating) && !empty($course)){
			$matchThese = ['rating' => $rating];
		}
		$generalCourseFeedbacks = DB::table('general_course_feedback')
									->select('general_course_feedback.id', 'general_course_feedback.course_id','courses.course_title','general_course_feedback.user_id','users.firstname','users.lastname','general_course_feedback.rating','general_course_feedback.comment','general_course_feedback.is_moderated')
									->join('courses', 'general_course_feedback.course_id', '=', 'courses.id')
									->join('users', 'general_course_feedback.user_id', '=', 'users.id')
									->where([['courses.course_title', 'like', '%' . $course . '%'],['general_course_feedback.comment', 'like', '%' . $comment . '%'],['general_course_feedback.rating', 'like', '%' . $rating . '%']])
									->get();
		$user = Auth::user();
        $userType =  UserType::find($user->role_id)->user_role;
		$totalCount = $generalCourseFeedbacks->count();
		foreach ($generalCourseFeedbacks as $feedback) {
			$comments = strip_tags($feedback->comment);
			if (strlen($comments) > 30) {
				// truncate string
				$firstpart = substr($comments, 0, 30);
				$firstpart = $firstpart;
				$secondpart = substr($comments, 30);
			}
			else{
				$firstpart = $feedback->comment;
				$secondpart = '';
			}
            $userfeedback = array(
                'id' => $feedback->id,
                'course_id'=> $feedback->course_id,
				'course_name'=> $feedback->course_title,
				'user_id'=> $feedback->user_id,
				'user_name'=> $feedback->firstname.' '.$feedback->lastname,
				'rating'=> $feedback->rating,
				'comment'=> $feedback->comment,
				'is_moderated'=>$feedback->is_moderated,
				'firstpart' => $firstpart,
				'secondpart' => $secondpart,
            );
            array_push($userfeedbacks, $userfeedback);
        }
        $feedbackObj = collect($userfeedbacks);
        $userfeedbacks = $this->paginate($feedbackObj, 10);
		$userfeedbacks->withPath('');
		//var_dump($userfeedbacks);
		return view('Auth.Admin.view_reviews', [
            'userfeedbacks' => $userfeedbacks,
			'course' => $course,
			'comment' => $comment,
			'rating' => $rating,
			'userType' => $userType,
			'totalCount' => $totalCount,
            'start_from' => 0
        ]);
	}
	public function publishReview(Request $request){
		$reviewId = $request->review_id;
		$review = DB::table('general_course_feedback')->where('id', $reviewId)->first();
		if($review->is_moderated) {
            $is_moderated = false;
			DB::table('general_course_feedback')->where('id', $reviewId)->update(['is_moderated' => $is_moderated]);
            //$review->save();
            return response()->json(['status' => 'unpublished', 'message' => 'Unpublished successfully']);
        } else {
            $is_moderated = true;
            DB::table('general_course_feedback')->where('id', $reviewId)->update(['is_moderated' => $is_moderated]);
            return response()->json(['status' => 'published', 'message' => 'Published successfully']);
        }
	}
	/* by jibi for getting user reviews ends */

}
