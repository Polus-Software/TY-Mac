<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;
use App\Models\AssignedCourse;
use App\Models\Topic;
use App\Models\TopicContent;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
        $courseDetails = [];
        $courseCategories = CourseCategory::all();
        $courses = Course::all();
        foreach ($courses as $course) {
            $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description
              );
              array_push($courseDetails, $courseData);
        }
        return view('Course.manage_courses', [
            'courseDetails' => $courseDetails,
            'courseCategories' => $courseCategories,
            'instructors' => $instructors
        ]);
    } 

    public function saveCourse(Request $request) {
        $html = '';
        $slNo = 1;
        $courseTitle = $request->input('course_title');
        $courseDesc = $request->input('course_description');
        
        $courseCategory = $request->input('course_category');
        $instructor = $request->input('instructor');
        $user = Auth::user();
        $userId = $user->id;
        $course = new Course;
        $course->course_title = $courseTitle;
        $course->description = $courseDesc;
        $course->category = $courseCategory;
        $course->created_by = $userId;
        $course->save();
        $assignedCourse = new AssignedCourse;
        $assignedCourse->course_id = $course->id;
        $assignedCourse->user_id = $instructor;
        $assignedCourse->save();

        $courses = Course::all();

        foreach($courses as $course) {
            $categoryName = CourseCategory::where('id', $course->category)->value('category_name');
            $html = $html . '<tr id="' . $course->course_id .'">';
            $html = $html . '<th class="align-middle" scope="row">' . $slNo .'</th>';
            $html = $html . ' <td class="align-middle">' . $course->course_title . '</td>';
            $html = $html . '<td class="align-middle">' . $categoryName . '</td>';
            $html = $html . '<td class="align-middle">' . $course->description . '</td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary add_new_course_btn" data-bs-toggle="modal" data-bs-target="#view_course_modal" data-bs-id="' . $course->id . '">View</button></td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-success edit_new_course_btn" data-bs-toggle="modal" data-bs-target="#edit_course_modal" data-bs-id="' . $course->id . '">Edit</button></td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger delete_new_course_btn" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="' . $course->id . '">Delete</button></td></tr>';
            $slNo = $slNo + 1;
        }

        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'html' => $html]);
    }

    public function viewCourse(Request $request) {
        $courseId = $request->input('course_id');
        if ($courseId) {
            $course = Course::where('id', $courseId);
            if ($course) {
                $categoryName = CourseCategory::where('id', $course->value('category'))->value('category_name');
                $data = ['course_name' => $course->value('course_title'), 'course_category' => $categoryName, 'course_description' => $course->value('description')];
                return response()->json(['status' => 'success', 'message' => '', 'courseDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function editCourse(Request $request) {
        $courseId = $request->input('course_id');
        if ($courseId) {
            $course = Course::where('id', $courseId);
            if ($course) {
                $instructor = AssignedCourse::where('course_id', $courseId)->value('user_id');
                $data = ['course_name' => $course->value('course_title'), 'course_category' => $course->value('category'), 'course_description' => $course->value('description'), 'instructor' => $instructor, 'id' => $courseId];
                return response()->json(['status' => 'success', 'message' => '', 'courseDetails' => $data]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function updateCourse(Request $request) {
        $html = '';
        $slNo = 1;
        $courseTitle = $request->input('course_title');
        $courseDesc = $request->input('description');
        $courseCategory = $request->input('course_category');
        $instructor = $request->input('instructor');
        $courseId = $request->input('course_id');
        $user = Auth::user();
        $userId = $user->id;
        $course = Course::find($courseId);
        $course->course_title = $courseTitle;
        $course->description = $courseDesc;
        $course->category = $courseCategory;
        $course->created_by = $userId;
        $course->save();
        $assignedCourse = AssignedCourse::where('course_id', 'like', $courseId)->update(['course_id' => $course->id, 'user_id' => $instructor]);
        $courses = Course::all();

        foreach($courses as $course) {
            $categoryName = CourseCategory::where('id', $course->category)->value('category_name');
            $html = $html . '<tr id="' . $course->id .'">';
            $html = $html . '<th class="align-middle" scope="row">' . $slNo .'</th>';
            $html = $html . ' <td class="align-middle">' . $course->course_title . '</td>';
            $html = $html . '<td class="align-middle">' . $categoryName . '</td>';
            $html = $html . '<td class="align-middle">' . $course->description . '</td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary add_new_course_btn" data-bs-toggle="modal" data-bs-target="#view_course_modal" data-bs-id="' . $course->id . '">View</button></td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-success edit_new_course_btn" data-bs-toggle="modal" data-bs-target="#edit_course_modal" data-bs-id="' . $course->id . '">Edit</button></td>';
            $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger delete_new_course_btn" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="' . $course->id . '">Delete</button></td></tr>';
            $slNo = $slNo + 1;
        }

        return response()->json(['status' => 'success', 'message' => 'Added successfully', 'html' => $html]);
    }

    public function deleteCourse(Request $request) {
        $html = '';
        $slNo = 1;
        
        $courseId = $request->input('course_id');
        if ($courseId) {
            $course = Course::find($courseId);
            if ($course) {
                $course->delete();
                $courses = Course::all();

                foreach($courses as $course) {
                    $categoryName = CourseCategory::where('id', $course->category)->value('category_name');
                    $html = $html . '<tr id="' . $course->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo .'</th>';
                    $html = $html . ' <td class="align-middle">' . $course->course_title . '</td>';
                    $html = $html . '<td class="align-middle">' . $categoryName . '</td>';
                    $html = $html . '<td class="align-middle">' . $course->description . '</td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-primary add_new_course_btn" data-bs-toggle="modal" data-bs-target="#view_course_modal" data-bs-id="' . $course->id . '">View</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-success edit_new_course_btn" data-bs-toggle="modal" data-bs-target="#edit_course_modal" data-bs-id="' . $course->id . '">Edit</button></td>';
                    $html = $html . '<td class="text-center align-middle"><button class="btn btn-danger delete_new_course_btn" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="' . $course->id . '">Delete</button></td></tr>';
                    $slNo = $slNo + 1;
                }
                return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
            }
        }
        return response()->json(['status' => 'failed', 'message' => 'Some error']);
    }

    public function loadCourse(Request $request) {
        $html = '<option value="">Please select a course</option>';
        $courses = Course::all();

        foreach($courses as $course) {
            $html = $html . '<option value="' . $course->id . '">' . $course->course_title . '</option>';
        }
        return response()->json(['status' => 'success', 'message' => 'Updated successfully', 'html' => $html]);
    }

    public function saveSubTopic(Request $request) {
        $topic = new Topic;
        $topic->topic_title = $request->topic_title;
        $topic->course_id = $request->course;
        $topic->description = $request->topic_description;
        $topic->save();
        if($request->hasFile('study_material')){
            $filename = $request->study_material->getClientOriginalName();
            $request->study_material->storeAs('study_material',$filename,'public');
            $content = new TopicContent;
            $content->topic_title = $request->topic_title;
            $content->topic_id = $topic->id;
            $content->description = $request->topic_description;
            $content->content_type = $request->study_material->extension();
            $content->document = $filename;
            $content->save();
        }

        return redirect()->back();
    }
}
