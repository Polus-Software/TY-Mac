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
        $studentDatas = $this->paginate($studentDetailsObj);
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

            return view('Auth.Admin.AdminSettings', [
                'userType' => $userType,
                'filters' => $filters
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
        $value = $request->value;
        $setting = GeneralSetting::where('setting', 'recommendation_threshold')->get();
        if(count($setting)) {
            $settingId = GeneralSetting::where('setting','recommendation_threshold')->value('id');
            $setting = GeneralSetting::find($settingId);
            $setting->value = $value;
            $setting->save();
            return response()->json(['status' => 'success', 'message' => 'Updated threshold successfully']);
        } else {
            $newSettings = new GeneralSetting;
            $newSettings->setting = 'recommendation_threshold';
            $newSettings->value = $value;
            $newSettings->save();
            return response()->json(['status' => 'success', 'message' => 'Added threshold successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Something went wrong!']);
        
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
        return view('Student.allCourses', ['courseDatas' => $courseDatas, 'allCourseCategory' => $allCourseCategory, 'filters' => $filters, 'instructors' => $instructors]);

    }
}
