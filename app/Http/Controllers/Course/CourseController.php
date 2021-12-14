<?php

namespace App\Http\Controllers\Course;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;
use App\Models\AssignedCourse;
use App\Models\Topic;
use App\Models\CohortBatch;
use App\Models\TopicContent;
use App\Models\TopicAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $user = Auth::user();
        $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
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
            'instructors' => $instructors,
            'userType' => $userTypeLoggedIn
        ]);
    }

    public function addCourse(){
        $courseCategories = CourseCategory::all();
        $instructors = DB::table('users')->where('role_id', '=', 3) ->get();

        return view('Course.admin.create_course',[
            'courseCategories' => $courseCategories,
            'instructors' => $instructors,
        ]);
    }

    public function createSubtopic(Request $request){
        $course_id = $request->input('course_id');
        return view('Course.admin.create_subtopic', [
            'course_id' => $course_id
        ]);
    }

    public function saveCourse(Request $request) {

        $courseTitle = $request->input('course_title');
        $courseDesc = $request->input('description');
        $courseCategory = $request->input('course_category');
        $courseDifficulty = $request->input('course_difficulty');
        $instructorName = $request->input('instructor_name');
        $courseDuration = $request->input('course_duration');
       
        $what_learn = "";
        $what_learn_points_count = $request->input('what_learn_points_count');
 
        for($index = 1; $index <= $what_learn_points_count; $index++) {
           $what_learn_temp = $request->input('what_learn_' . $index);
           $what_learn = $what_learn . $what_learn_temp . ";";
        }
 
        $whoLearnDescription = $request->input('who_learn_description');

        $who_learn ="";
        $who_learn_points_count = $request->input('who_learn_points_count');
   
        for($i =1;  $i <= $who_learn_points_count; $i++){
          $who_learn_temp = $request->input('who_learn_points_'. $i);
          $who_learn = $who_learn . $who_learn_temp . ";";
        }
        if($request->file()){
        $courseFile = $request->course_image->getClientOriginalName();
        $courseThumbnailFile = $request->course_thumbnail_image->getClientOriginalName();

        $request->course_image->storeAs('courseImages',$courseFile,'public');
        $request->course_thumbnail_image->storeAs('courseThumbnailImages',$courseThumbnailFile,'public');
        }
        
        $user = Auth::user();
        $userId = $user->id;
        $course = new Course;
        $course->course_title = $courseTitle;
        $course->description = $courseDesc;
        $course->category = $courseCategory;
        $course->course_difficulty = $courseDifficulty;
        $course->course_duration = $courseDuration;
        $course->short_description = $what_learn ;
        $course->course_details = $whoLearnDescription;
        $course->course_details_points = $who_learn;
        $course->course_image = $courseFile;
        $course->course_thumbnail_image = $courseThumbnailFile;
        $course->created_by = $userId;
        $course->save();

        $assignedCourse = new AssignedCourse;
        $assignedCourse->course_id = $course->id;
        $assignedCourse->user_id = $instructorName;
        $assignedCourse->save();

        // Session::put('course_id', $course->id);
        // Session::save();
        return redirect()->route('create-subtopic', ['course_id' => $course->id]);
    }

    public function viewCourse(Request $request) {
        try {
            $courseId = $request->input('course_id');
            if ($courseId) {
                $course = Course::where('id', $courseId);
                if ($course) {
                    $categoryName = CourseCategory::where('id', $course->value('category'))->value('category_name');
                    
                    $data = ['course_name' => $course->value('course_title'), 
                    'course_category' => $categoryName,
                    'course_description' => $course->value('description'), 
                    'course_difficulty' => $course->value('course_difficulty'),
                    'course_duration' => (int)$course->value('course_duration'),
                    'short_description' => explode(";", $course->value('short_description')),
                    'course_details' => $course->value('course_details'),
                    'course_details_points' => explode(";", $course->value('course_details_points')),
                    // 'course_image' => $course->value('course_image'),
                    // 'course_thumbnail_image' => $course->value('course_thumbnail_image'),
                   
                    ];
                    return response()->json(['status' => 'success', 'message' => '', 'courseDetails' => $data]);
                }
            }
            return response()->json(['status' => 'failed', 'message' => 'Some error']);
        } catch (Exception $exception) {
            return($exception->getMessage());
        }
        
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

    // public function createSubtopic(){
    //     return view('Course.admin.create_subtopic');
    // }
    // public function saveSubTopic(Request $request) {
    //     $topic = new Topic;
    //     $topic->topic_title = $request->topic_title;
    //     $topic->course_id = $request->course;
    //     $topic->description = $request->topic_description;
    //     $topic->save();
    //     if($request->hasFile('study_material')){
    //         $filename = $request->study_material->getClientOriginalName();
    //         $request->study_material->storeAs('study_material',$filename,'public');
    //         $content = new TopicContent;
    //         $content->topic_title = $request->topic_title;
    //         $content->topic_id = $topic->id;
    //         $content->description = $request->topic_description;
    //         $content->content_type = $request->study_material->extension();
    //         $content->document = $filename;
    //         $content->save();
    //     }
    //     return redirect()->back();
    // }

    public function saveSubTopic(Request $request) {
        $external_links = '';
        $topic_count  = $request->topic_count;
        $course_id = $request->course_id;
        for($i = 1; $i<= $topic_count; $i++) {
            $topic = new Topic;
            $topic->topic_title = $request->input('topic_title'.$i);
            $topic->course_id = $course_id;
            $topic->description = "test";
            $topic->save();
            $content_count = $request->input('content_count_topic_'.$i);            
            for($j = 1; $j<=$content_count; $j++) {
                if($request->missing('externalLink_count_topic_'.$i.'_content_'.$j)) {
                    continue;
                }
                $external_link_count = $request->input('externalLink_count_topic_'.$i.'_content_'.$j);
                for($k =1; $k <= $external_link_count; $k++) {
                    $external_link = $request->input('external_topic'.$i.'_content_'.$j.'_link_'.$k);
                    $external_links = $external_links . $external_link.';';
                }
                $content = new TopicContent;
                $content->topic_title = $request->input('content_title_'.$i.'_'.$j);
                $content->topic_id = $topic->id;
                $content->description = $external_links;
                $content->content_type = 'test';
                $content->document = 'test';
                $content->save();
            }
        }

        return redirect()->route('create-assignment', ['course_id' => $course_id]);
    }

    public function saveBatch(Request $request) {
        $course = $request->batchCourse;
        $batchName = $request->batchname;
        $startDate = $request->startDate;
        $startTime = $request->startTime;
        $endTime = $request->endTime;
        $batchDuration = $request->batch_duration;
        $zone = $request->zone;
        $batch = new CohortBatch;
        $batch->course_id = $course;
        $batch->batchname = $batchName;
        $batch->start_date = $startDate;
        $batch->start_time = $startTime;
        $batch->end_time = $endTime;
        $batch->duration = $batchDuration;
        $batch->region = $zone;
        $batch->save();
        return response()->json(['status' => 'success', 'message' => 'Updated successfully']);
    }

    // To view sub topics
    public function viewSubTopic($id){
        try{
            $subTopics = DB::table('topics')->where('course_id', $id)->paginate(2);

            return view('Course.view_sub_topics',[
             'subTopics' => $subTopics,
            ]);
        }catch (Exception $exception) {
            return($exception->getMessage());
        }
    }


    //Adding assignments
    public function addAssignment(Request $request){
      $topicId =intval($request->assignment_topic_id);

      $courseId = DB::table('topics')->where('topic_id', $topicId)->value('course_id');
      $instructorId = DB::table('assigned_courses')->where('course_id', $courseId)->value('user_id');


      $topicAssignment = new TopicAssignment;
      $topicAssignment->assignment_title= $request->assignment_title;
      $topicAssignment->assignment_description= $request->assignment_description;
      $topicAssignment->topic_id = $topicId;
      $topicAssignment->course_id = $courseId ;
      $topicAssignment->instructor_id = $instructorId;

      
        $filename = $request->assignment_attachments->getClientOriginalName();
        $request->assignment_attachments->storeAs('assignmentAttachments',$filename,'public');
        $topicAssignment->document = $filename;
        $topicAssignment->save();
        return redirect()->back();
    }

    public function createAssignment(Request $request){
        $course_id = $request->input('course_id');
        $subTopics = DB::table('topics')->where('course_id', $course_id)->get();
        return view('Course.admin.create_assignment', [
            'course_id' => $course_id,
            'subTopics' => $subTopics
        ]);
    }

    public function editAssignment(Request $request){
        if(Session::has('course_id')){
            $course_id = Session::get('course_id');
        }
        $assignment_id = $request->get('assignment_id');
        $assignment_details = DB::table('topic_assignments')->where('id', $assignment_id);
        $subTopics = DB::table('topics')->where('course_id', $course_id)->get();
        $assignment = [
            'id' => $assignment_details->value('id'),
            'topic_id' => $assignment_details->value('topic_id'),
            'instructor_id' => $assignment_details->value('instructor_id'),
            'course_id' => $assignment_details->value('course_id'),
            'assignment_title' => $assignment_details->value('assignment_title'),
            'assignment_description' => $assignment_details->value('assignment_description'),
            'document' => $assignment_details->value('document')
        ];
        return view('Course.admin.edit_assignment', [
            'course_id' => $course_id,
            'subTopics' => $subTopics,
            'assignment_details' => $assignment
        ]);
    }

    public function viewAssignment(Request $request){
        $course_id = $request->input('course_id');
        $assignments = DB::table('topic_assignments')
        ->join('topics', 'topic_assignments.topic_id', '=', 'topics.topic_id')
        ->where('topic_assignments.course_id', $course_id)
        ->get();
        return view('Course.admin.view_assignment', [
            'assignments' => $assignments
        ]);
    }

    /**
     * Saving assignments to db
     */
    public function saveAssignment(Request $request) {
        $topicId =intval($request->input('assignment_topic_id'));
        $course_id = $request->input('course_id');
        // $courseId = DB::table('topics')->where('topic_id', $topicId)->value('course_id');
        $instructorId = DB::table('assigned_courses')->where('course_id', $course_id)->value('user_id');

        $topicAssignment = new TopicAssignment;
        $topicAssignment->assignment_title= $request->input('assignment_title');
        $topicAssignment->assignment_description= $request->input('assignment_description');
        $topicAssignment->topic_id = $topicId;
        $topicAssignment->course_id = $course_id ;
        $topicAssignment->instructor_id = $instructorId;

        //TODO: Assignment due date
        if($request->file()){
            $filename = $request->assignment_attachments->getClientOriginalName();
            $request->assignment_attachments->storeAs('assignmentAttachments',$filename,'public');
            $topicAssignment->document = $filename;
        }
        
        $topicAssignment->save();
        return redirect()->route('view-assignment', ['course_id' => $course_id]);
    }

    /**
     * Saving assignments to db
     */
    public function updateAssignment(Request $request) {
        $topicId =intval($request->input('assignment_topic_id'));
        $assignment_id = intval($request->input('assignment_id'));
        $course_id = $request->input('course_id');

        $assignment_title= $request->input('assignment_title');
        $assignment_description= $request->input('assignment_description');
        
        TopicAssignment::where('id', 'like',$assignment_id)->update([
            'topic_id' => $topicId,
            'assignment_title' => $assignment_title,
            'assignment_description' => $assignment_description

        ]);
        return redirect('view-assignment');
    }

    /**
     * delete assignments from db
     */
    public function deleteAssignment(Request $request) {
        $assignment_id = $request->input('assignment_id');
        if ($assignment_id) {
            DB::table('topic_assignments')->where('id', '=', $assignment_id)->delete();
        }
        return redirect()->back();
    }

    public function createCohort() {
        
    }
}
