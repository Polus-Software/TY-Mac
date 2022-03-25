<?php

namespace App\Http\Controllers\Course;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserType;
use App\Models\User;
use App\Models\AssignedCourse;
use App\Models\Topic;
use App\Models\CohortBatch;
use App\Models\TopicContent;
use App\Models\TopicAssignment;
use App\Models\CohortNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Throwable;
use Carbon\Carbon;
use DateTimeZone;
use App\Models\CustomTimezone;
use Illuminate\Support\Facades\Mail;
use App\Mail\InstructorMailAfterassigningCourse;
use App\Mail\mailAfterCourseCreation;
use App\Models\Notification;

class CourseController extends Controller
{
    public function index() {
        $userType = UserType::where('user_role', 'instructor')->value('id');
        $user = Auth::user();
        if($user){
            $userTypeLoggedIn =  UserType::find($user->role_id)->user_role;
        $instructors = DB::table('users')
                ->where('role_id', '=', $userType)
                ->get();
        $courseDetails = [];
        $courseCategories = CourseCategory::all();
        $courses = Course::all();
        foreach ($courses as $course) {
            $courseStatus = DB::table('courses')->where('id', $course->id)->value('is_published');
            $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
            $instructorfirstname = User::where('id', $assigned)->value('firstname');
            $instructorlastname = User::where('id', $assigned)->value('lastname');
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
                'courseStatus' => $courseStatus,
                'updated_at' => Carbon::createFromFormat('Y-m-d H:i:s', $course->updated_at)->format('m/d/Y'),
               
              );
              array_push($courseDetails, $courseData);
        }

        $courseDetailsObj = collect($courseDetails);
        $courseDatas = $this->paginate($courseDetailsObj);
        $courseDatas->withPath('');

        return view('Course.manage_courses', [
             'courseDatas' => $courseDatas,
            'courseCategories' => $courseCategories,
            'instructors' => $instructors,
            'userType' => $userTypeLoggedIn
        ]);
    }else {
        return redirect('login');
       }
    }


    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function addCourse(){
        $courseCategories = CourseCategory::all();
        $instructors = DB::table('users')->where('role_id', '=', 3) ->get();
        
        return view('Course.admin.create.create_course',[
            'courseCategories' => $courseCategories,
            'instructors' => $instructors,
            'courseStatus' => 0,
            'course_id' => ''
        ]);
    }

    public function createSubtopic(Request $request){
        
        $course_id = $request->input('course_id');
        $course = Course::where('id', $course_id);
        $course_title = $course->value('course_title');
        $courseStatus = $course->value('is_published');
        return view('Course.admin.create_subtopic', [
            'course_id' => $course_id,
            'course_title' => $course_title,
            'courseStatus' => $courseStatus
        ]);
    }

    public function saveCourse(Request $request) {
        try{
        $request->validate([
            'course_title'=>'required',
            'description' => 'required',
            'course_category' =>'required',
            'difficulty' => 'required',
            'instructor' =>'required',
            'course_duration' =>'required',
            'course_rating' =>'required',
            'what_learn_1' =>'required',
            'who_learn_points' => 'required',
            'course_image' =>'required| mimes:jpeg,jpg,png,.svg| max:50000',
            'course_thumbnail_image' =>'required| mimes:jpeg,jpg,png,.svg| max:10000',
            //'course_image' =>'required| dimensions:width=604,height=287| mimes:jpeg,jpg,png,.svg| max:500000',
            //'course_thumbnail_image' =>'required| dimensions:width=395,height=186| mimes:jpeg,jpg,png,.svg| max:100000',
        ]);

        $courseTitle = $request->input('course_title');
        $courseDesc = $request->input('description');
        $courseCategory = $request->input('course_category');
        $courseDifficulty = $request->input('difficulty');
        $instructorId = $request->input('instructor');
        $courseDuration = $request->input('course_duration');
        $course_rating = $request->input('course_rating');
        $use_custom_ratings = $request->input('use_custom_ratings') == "on" ? true : false;
        
        $what_learn = "";
        $what_learn_points_count = $request->input('what_learn_points_count');
 
        for($index = 1; $index <= $what_learn_points_count; $index++) {
           $what_learn_temp = $request->input('what_learn_' . $index);
           $what_learn = $what_learn . $what_learn_temp . ";";
        }
        $what_learn = rtrim($what_learn, ';');
        $whoLearnDescription = $request->input('who_learn_description');

        $who_learn ="";
        $courseFile = "";
        $courseThumbnailFile = "";
        if($request->file()){
            $courseFile = $request->course_image;
            $courseFileName = $courseFile->getClientOriginalName();
            $destinationPath = public_path().'/storage/courseImages';
            $courseFile->move($destinationPath,$courseFileName);
          
            $courseThumbnailFile = $request->course_thumbnail_image;
            $courseThumbnailFileName = $courseThumbnailFile->getClientOriginalName();
            $destinationPath = public_path().'/storage/courseThumbnailImages';
            $courseThumbnailFile->move($destinationPath,$courseThumbnailFileName);
        }
        
        $user = Auth::user();
        $userId = $user->id;
        $instructorName = User::where('id',$instructorId)->value('firstname').' '.User::where('id',$instructorId)->value('lastname');
        $instructorEmail = User::where('id',$instructorId)->value('email');
        $course = new Course;
        $course->course_title = $courseTitle;
        $course->description = $courseDesc;
        $course->category = $courseCategory;
        $course->course_difficulty = $courseDifficulty;
        $course->course_duration = $courseDuration;
        $duration_filter_label = "";
        if($courseDuration < 1) {
            $duration_filter_label = "less_than_1";
        } else if($courseDuration >= 1 && $courseDuration < 2) {
            $duration_filter_label = "less_than_2";
        } else if($courseDuration >= 2.5 && $courseDuration < 5) {
            $duration_filter_label = "less_than_5";
        } else if($courseDuration >= 5) {
            $duration_filter_label = "greater_than_5";
        }
        $course->duration_filter_label = $duration_filter_label;
        $course->short_description = $what_learn;
        $course->course_details = $whoLearnDescription;
        $course->course_details_points = $request->input('who_learn_points');
        $course->course_image = $courseFileName;
        $course->course_thumbnail_image = $courseThumbnailFileName;
        $course->created_by = $userId;
        $course->is_published = false;
        $course->instructor_id = $instructorId;
        $course->course_rating = $course_rating;
        $course->use_custom_ratings = $use_custom_ratings;
        $course->save();

        $assignedCourse = new AssignedCourse;
        $assignedCourse->course_id = $course->id;
        $assignedCourse->user_id = $instructorId;
        $assignedCourse->save();

        $userType = UserType::where('user_role', 'content_creator')->value('id');
        $user_type = UserType::where('user_role', 'Admin')->value('id');
        $admins = User::where('role_id', $user_type)->get();
        $name = $user->firstname.' '.$user->lastname;

        if($user->role_id == $userType){
            foreach($admins as $admin) {
                $data=[
                    'adminFirstName' => $admin->firstname,
                    'adminLastName' => $admin->lastname,
                    'courseTitle' => $courseTitle,
                    'name' => $name
                 ];

                Mail::mailer('infosmtp')->to($admin->email)->send(new mailAfterCourseCreation($data));
                $notification = new Notification; 
                $notification->user = $admin->id;
                $notification->notification = "Hi " .$admin->firstname ." ".$admin->lastname.", A new course has been created by the content creator ".$name." The following course has been added : ".$courseTitle;
                $notification->is_read = false;
                $notification->save();
            }
            
        }

        $datas = [
            'instructorName' => $instructorName,
            'courseTitle' => $courseTitle
         ];

         Mail::mailer('infosmtp')->to($instructorEmail)->send(new InstructorMailAfterassigningCourse($datas));
         
         $notification = new Notification; 
         $notification->user = $instructorId;
         $notification->notification = "Hi ".$instructorName.", You have been assigned a new course " .$courseTitle;
         $notification->is_read = false;
         $notification->save();
         

        return redirect()->route('create-subtopic', ['course_id' => $course->id]);

        }catch (Exception $exception){
            return redirect()->route('create-subtopic', ['course_id' => $course->id]);
        }
    }

    /**
     * For viewing a course details
     */
    public function viewCourse(Request $request) {
        try {
            $course_id = $request->input('course_id');
            if($course_id) {
                $data = DB::table('courses')
                            ->join('course_category', 'courses.category', '=', 'course_category.id')
                            ->join('assigned_courses', 'courses.id', '=', 'assigned_courses.course_id')
                            ->join('users', 'assigned_courses.user_id', '=', 'users.id')
                            ->where('courses.id', $course_id);
                $whatlearn = explode(';', $data->value('courses.short_description'));
                $whothis = explode(';', $data->value('courses.course_details_points'));
                $course_details = [
                    'instructor' => $data->value('users.firstname').' '.$data->value('users.lastname'),                  
                    'title' => $data->value('courses.course_title'),
                    'description' => $data->value('courses.description'),
                    'difficulty' => $data->value('courses.course_difficulty'),
                    'category' => $data->value('course_category.category_name'),
                    'duration' => $data->value('courses.course_duration'),
                    'whatlearn' => $whatlearn,
                    'whothis' => $whothis,
                    'image' => $data->value('course_image'),
                    'thumbnail' => $data->value('course_thumbnail_image')
                ];

                $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');

                return view('Course.admin.view.view_course', [
                    'course_details' => $course_details,
                    'course_id' => $course_id,
                    'courseStatus' => $courseStatus
                ]);
            }

        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }

    

    /**
     * For editing a course
     */
    public function editCourse(Request $request) {
        try {
            
            $course_id = $request->input('course_id');
            if ($course_id) {
                $course = Course::where('id', $course_id);
                if ($course) {
                    $userType = UserType::where('user_role', 'instructor')->value('id');
                    $instructors = DB::table('users')->where('role_id', '=', $userType)->get();
                    $courseCategories = CourseCategory::all();
                    $data = DB::table('courses')
                            ->join('course_category', 'courses.category', '=', 'course_category.id')
                            ->join('assigned_courses', 'courses.id', '=', 'assigned_courses.course_id')
                            ->join('users', 'assigned_courses.user_id', '=', 'users.id')
                            ->where('courses.id', $course_id);
                $course_details = [
                    'instructor' => $data->value('users.firstname'),
                    'instructor_id' => $data->value('assigned_courses.user_id'),
                    'title' => $data->value('courses.course_title'),
                    'description' => $data->value('courses.description'),
                    'short_description' => $data->value('courses.short_description'),
                    'difficulty' => $data->value('courses.course_difficulty'),
                    'category_id' => $data->value('courses.category'),
                    'category' => $data->value('course_category.category_name'),
                    'duration' => $data->value('courses.course_duration'),
                    'course_rating' => $data->value('courses.course_rating'),
                    'use_custom_ratings' => $data->value('courses.use_custom_ratings'),
                    // 'whatlearn' => explode(';', $data->value('courses.course_details')),
                     'course_details_points' => $data->value('courses.course_details_points'),
                    'image' => $data->value('courses.course_image'),
                    'thumbnail' => $data->value('courses.course_thumbnail_image')
                ];

                $whatLearn = explode(';', $data->value('courses.short_description'));
                //$whoThis = explode(';', $data->value('courses.course_details_points'));
                $whoThis = $data->value('courses.course_details_points');


                $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');

                    return view('Course.admin.create.create_course', [
                        'course_details' => $course_details,
                        'course_id' => $course_id,
                        'courseCategories' => $courseCategories,
                        'instructors' => $instructors,
                        'courseStatus' => $courseStatus,
                        'whatLearn' => $whatLearn,
                        'whoThis' => $whoThis
                    ]);
                }
            }
        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
        
    }

   

    public function updateCourse(Request $request) {        
        try{

            $request->validate([
                'course_title'=>'required',
                'description' => 'required',
                'course_category' =>'required',
                'difficulty' => 'required',
                'instructor' =>'required',
                'course_duration' =>'required',
                'course_rating' =>'required',
                'what_learn_1' =>'required',
                'who_learn_points'=>'required',
                //'course_image' =>'required| dimensions:width=604,height=287| mimes:jpeg,jpg,png,.svg| max:500000',
                //'course_thumbnail_image' =>'required| dimensions:width=395,height=186| mimes:jpeg,jpg,png,.svg| max:100000',
            ]);
            
            if($request->isMethod('post')){
           
                $course_title = $request->input('course_title');
                $description = $request->input('description');
                $category = $request->input('course_category');
                $instructor = $request->input('instructor');
                $course_id = $request->input('course_id');
                $difficulty = $request->input('difficulty');
                $course_rating = $request->input('course_rating');
                $use_custom_ratings = $request->input('use_custom_ratings') == "on" ? true : false;
                $courseDuration = $request->input('course_duration');       
                $what_learn = "";
                $what_learn_points_count = $request->input('what_learn_points_count');
                
                for($index = 1; $index <= $what_learn_points_count; $index++) {
                    $what_learn_temp = $request->input('what_learn_' . $index);
                    if($index == $what_learn_points_count) {
                        $what_learn = $what_learn . $what_learn_temp;
                    } else {
                        $what_learn = $what_learn . $what_learn_temp . ";";
                    }
                    
                }
                $whoLearnDescription = $request->input('who_learn_description');
                $who_learn = $request->input('who_learn_points');
                
                
                $user = Auth::user();
                $userId = $user->id;
                $course = Course::find($course_id);
                $course->course_title = $course_title;
                $course->description = $description;
                $course->category = $category;
                $course->course_difficulty = $difficulty;
                $course->short_description = $what_learn ;
                $course->course_duration = $courseDuration;
                $duration_filter_label = "";
                if($courseDuration < 1) {
                    $duration_filter_label = "less_than_1";
                } else if($courseDuration >= 1 && $courseDuration < 2) {
                    $duration_filter_label = "less_than_2";
                } else if($courseDuration >= 2.5 && $courseDuration < 5) {
                    $duration_filter_label = "less_than_5";
                } else if($courseDuration >= 5) {
                    $duration_filter_label = "greater_than_5";
                }
                $course->duration_filter_label = $duration_filter_label;
                $course->course_details = $whoLearnDescription;
                $course->course_details_points = $who_learn;
                $course->instructor_id = $instructor;
                if($use_custom_ratings) {
                    $course->course_rating = $course_rating;
                } else {
                    $course->course_rating = $course->students_ratings;
                }
                $course->use_custom_ratings = $use_custom_ratings;

                if($request->file()) {
                    if($request->course_image != null) {
                        $courseFile = $request->course_image;
                        $courseFileName = $courseFile->getClientOriginalName();
                        $destinationPath = public_path().'/storage/courseImages';
                        $courseFile->move($destinationPath,$courseFileName);
                        $course->course_image = $courseFileName;
                    }
                    if($request->course_thumbnail_image != null) {
                        $courseThumbnailFile = $request->course_thumbnail_image;
                        $courseThumbnailFileName = $courseThumbnailFile->getClientOriginalName();
                        $destinationPath = public_path().'/storage/courseThumbnailImages';
                        $courseThumbnailFile->move($destinationPath,$courseThumbnailFileName);
                        $course->course_thumbnail_image = $courseThumbnailFileName;
                    }
                }                      
               
                $course->save();
                $assignedCourse = AssignedCourse::where('course_id', 'like', $course_id)->update(['course_id' => $course->id, 'user_id' => $instructor]);
                return redirect()->route('view-course', ['course_id' => $course->id]);
            }
        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
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
                    $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
                    $instructorfirstname = User::where('id', $assigned)->value('firstname');
                    $instructorlastname = User::where('id', $assigned)->value('lastname');
                    $categoryName = CourseCategory::where('id', $course->category)->value('category_name');
                    $html = $html . '<tr id="' . $course->id .'">';
                    $html = $html . '<th class="align-middle" scope="row">' . $slNo .'</th>';
                    $html = $html . '<td class="align-middle">' . $course->course_title . '</td>';
                    $html = $html . '<td class="align-middle">' . $instructorfirstname .' '. $instructorlastname . '</td>';
                    $html = $html . '<td class="align-middle">' . Carbon::createFromFormat('Y-m-d H:i:s', $course->updated_at)->format('m/d/Y') . '</td>';
                    if($course->is_published == 1)
                        $html = $html . '<td style="vertical-align: middle;"><span class="badge bg-success text-dark">Published</span></td>';
                    else
                        $html = $html . '<td style="vertical-align: middle;"><span id="publish-badge" class="badge bg-warning text-dark">Draft</span></td>';
                    $html = $html . '<td class="text-center align-middle"><a href="" title="View course"><i class="fas fa-eye"></i></a>';
                    $html = $html . '<a title="Delete course" data-bs-toggle="modal" data-bs-target="#delete_course_modal" data-bs-id="' . $course->id . '"><i class="fas fa-trash-alt"></i></a></td></tr>';
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
        
        $external_links = '';
        $topic_count  = $request->topic_count;
        $course_id = $request->course_id;
        
        if(isset($request->topic_id) && !empty($request->topic_id)){
            $validate_array = [];
            for($i = 1; $i<= $request->topic_count; $i++) {
                $validate_array['topic_title'. $i] = 'required';
                for($j=0; $j < $request->input('content_count_topic_' .$i);$j++){
                    $validate_array['content_title_'.$i.'_'. $j] = 'required';
                    if($request->file('content_upload_'.$i.'_'.$j) != null) {
                        $validate_array['content_upload_'.$i.'_'.$j] = 'mimes:pdf,doc,docx,ppt,pptx,bin|max:10240';
                    }
                }
            }
            $this->validate($request, $validate_array);
            for($i = 1; $i<= $topic_count; $i++) {
                $updateDetails = [
                    'topic_title' => $request->input('topic_title'.$i),
                    'course_id' => $course_id,
                    'description'=>''
                ];
                Topic::where('topic_id', $request->topic_id)
                    ->update($updateDetails);
                $content_count = $request->input('content_count_topic_'.$i);
                for($j = 0; $j<$content_count; $j++) {
                    $TopicFileName = $extension = $external_links = '';
                    if($request->file() && !empty($request->file('content_upload_'.$i.'_'.$j))){
                        $subtopicFile = $request->file('content_upload_'.$i.'_'.$j);
                        $extension = $subtopicFile->extension();
                        $TopicFileName = $subtopicFile->getClientOriginalName();
                        $destinationPath = public_path().'/storage/study_material';
                        $subtopicFile->move($destinationPath,$TopicFileName);
                    }
                    $external_link_count = $request->input('externalLink_count_topic_'.$i.'_content_'.$j);
                    for($k =0; $k <= $external_link_count; $k++) {
                        $external_link = $request->input('external_topic'.$i.'_content_'.$j.'_link_'.$k);
                        $external_links = $external_links . $external_link.';';
                    }
                    if($request->input('content_topic_'.$i.'_'.$j) != ''){
                        if($request->input('content_status_'.$i.'_'.$j) == '0'){
                            TopicContent::where('topic_content_id',$request->input('content_topic_'.$i.'_'.$j))->delete();
                        }
                        else{
                            $content= TopicContent::where('topic_content_id',$request->input('content_topic_'.$i.'_'.$j) )->first();
                            if($extension == '')
                                $extension = $content['content_type'];
                            if($TopicFileName == '')
                                $TopicFileName = $content['document'];
                            $updateDetails = [
                                'topic_title' => $request->input('content_title_'.$i.'_'.$j),
                                'content_type' => $extension,
                                'external_link'=>$external_links,
                                'document'=>$TopicFileName,
                            ];
                            TopicContent::where('topic_content_id', $request->input('content_topic_'.$i.'_'.$j))
                                        ->update($updateDetails);
                        }
                    }
                    else{
                        if($request->input('content_status_'.$i.'_'.$j) != '0' && $request->input('content_title_'.$i.'_'.$j) != ''){
                            $content = new TopicContent;
                            $content->topic_title = $request->input('content_title_'.$i.'_'.$j);
                            $content->topic_id = $request->topic_id;
                            $content->description = "";
                            $content->content_type = $extension;
                            $content->external_link = $external_links;
                            $content->document = $TopicFileName;
                            $content->save();
                        }
                    }
                }
            }
        } else {
            $validate_array = [];
            for($i = 1; $i<= $request->topic_count; $i++) {
                $validate_array['topic_title'. $i] = 'required';
                for($j=1; $j <= $request->input('content_count_topic_' .$i);$j++){
                    $validate_array['content_title_'.$i.'_'. $j] = 'required';
                    if($request->file('content_upload_'.$i.'_'.$j) != null) {
                        $validate_array['content_upload_'.$i.'_'.$j] = 'required|mimes:pdf,doc,docx,ppt,pptx,bin|max:10240';
                    }
                    
                }
            }
            $this->validate($request, $validate_array);
            for($i = 1; $i<= $topic_count; $i++) {
                // $request->validate([
                //     'topic_title' . $i => 'required',
                //     'content_count_topic_'.$i => 'required'
                // ]);
                
                $topic = new Topic;
                $topic->topic_title = $request->input('topic_title'.$i);
                $topic->course_id = $course_id;
                $topic->description = "";
                $topic->save();
                $content_count = $request->input('content_count_topic_'.$i);            
                for($j = 1; $j<=$content_count; $j++) {
                    // $request->validate([
                    //     'content_title_'.$i.'_'.$j => 'required',
                    //     'content_upload['.$i.']['.$j.']' => 'required'
                    // ]);
                    $external_links = $extension = $TopicFileName = '';
                    if($request->file() && !empty($request->file('content_upload_'.$i.'_'.$j))){
                        $subtopicFile = $request->file('content_upload_'.$i.'_'.$j);
                        $extension = $subtopicFile->extension();
                        $TopicFileName = $subtopicFile->getClientOriginalName();
                        $destinationPath = public_path().'/storage/study_material';
                        $subtopicFile->move($destinationPath,$TopicFileName);
                    }
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
                    $content->description = "";
                    $content->content_type = $extension;
                    $content->external_link = $external_links;
                    $content->document = $TopicFileName;
                    $content->save();
                }
            }
        }
        //exit;
        return redirect()->route('view-subtopics', ['course_id' => $course_id]);
    }


    /**
     * For viewing a subTopics details
     */
    public function viewSubTopics(Request $request) {
    try {
        $courseContents = [];
        $course_id = $request->input('course_id');
        
        if($course_id) {
            $course_title = DB::table('courses')->where('id', $course_id)->value('course_title');
            
        $subtopics = Topic::where('course_id', $course_id)->get();
        foreach($subtopics as $topics){

            $topicId = $topics->topic_id;
            $topic_title =  $topics->topic_title;
            $topicContentArray= TopicContent::where('topic_id', array($topicId))->get();
            $contentsData = $topicContentArray->toArray();

            array_push($courseContents, array(
                'topic_id' => $topicId,
                'topic_title' =>$topic_title,
                'contentsData' => $contentsData
            ));
            }
        }
        $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
            return view('Course.admin.view.view_subtopics', [
                'courseContents' => $courseContents,
                'course_id' => $course_id,
                'course_title' => $course_title,
                'courseStatus' => $courseStatus
            ]);
        
        }catch (Exception $exception) {
                return ($exception->getMessage());
            }
    }

    // public function editSubTopics(Request $request, $topicId){

    //     $courseContents = [];
    //     $course_id = $request->input('course_id');
    //     if($course_id) {
    //         $course_title = DB::table('courses')->where('id', $course_id)->value('course_title');
    //     $subtopics = Topic::where('course_id', $course_id)->get();
    //     foreach($subtopics as $topics){

    //         $topicId = $topics->topic_id;
    //         $topic_title =  $topics->topic_title;
    //         $topicContentArray= TopicContent::where('topic_id', array($topicId))->get();
    //         $contentsData = $topicContentArray->toArray();

    //         array_push($courseContents, array(
    //             'topic_id' => $topicId,
    //             'topic_title' =>$topic_title,
    //             'contentsData' => $contentsData
    //         ));
    //         }

    //     }
    //     return view('Course.admin.edit_subtopic', [
    //         'courseContents' => $courseContents,
    //         'course_id' => $course_id,
    //         'course_title' => $course_title
    //     ]);

    // }

    public function editSubTopics(Request $request, $topicId) {
		$courseContents = [];
        if($topicId) {
			$subtopics = Topic::where('topic_id', $topicId)->first();
			$topicContentArray= TopicContent::where('topic_id', array($topicId))->get();
			$totalCount = $topicContentArray->count();
			$contentsData = $topicContentArray->toArray();
			if($contentsData){
				foreach($contentsData as $data){
					$linksArray = array();
					if(!empty($data['external_link'])){
						$linksArray = explode(';', $data['external_link']);
					}
					array_push($courseContents, array(
						'topic_content_id' => $data['topic_content_id'],
						'topic_id' =>$data['topic_id'],
						'topic_title' => $data['topic_title'],
						'topic_content_id' => $data['topic_content_id'],
						'description' =>$data['description'],
						'content_type' => $data['content_type'],
						'document' => $linksArray,
                        'uploaded_file_path' => public_path().'/storage/study_material/'.$data['document'],
						'uploaded_file' => $data['document'],
						'created_at' =>$data['created_at'],
						'updated_at' => $data['updated_at']
					));
				}
			}
			$course_id = $subtopics['course_id'];
			$course_title = DB::table('courses')->where('id', $course_id)->value('course_title');
			$courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
			//var_dump($courseContents);exit;
			return view('Course.admin.edit_subtopic', [
				'courseContents' => $courseContents,
				'course_id' => $course_id,
				'course_title' => $course_title,
				'courseStatus' => $courseStatus,
				'topic_title' =>$subtopics['topic_title'],
				'topic_id' => $topicId,
				'totalCount'=>$totalCount
			]);
        }
    }
    public function deleteSubTopics(Request $request, $topicId) {
       $courseContents = [];
		try {
            if($topicId) {
                $subtopics = Topic::where('topic_id', $topicId)->first();
                if($subtopics){
                    $course_id = $subtopics->course_id;
                    $subtopics = Topic::where('topic_id', $topicId)->delete();
                    return redirect()->route('view-subtopics', ['course_id' => $course_id]);
                }
            }
        }
        catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }


    public function createAssignment(Request $request){
        $course_id = $request->input('course_id');
        $course_title = DB::table('courses')->where('id', $course_id)->value('course_title');
        $subTopics = DB::table('topics')->where('course_id', $course_id)->get();
        $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
        return view('Course.admin.create_assignment', [
            'course_id' => $course_id,
            'subTopics' => $subTopics,
            'course_title' => $course_title,
            'courseStatus' => $courseStatus
        ]);
    }

    public function editAssignment(Request $request){
     
        $assignment_id = $request->get('assignment_id');
        $assignment_details = DB::table('topic_assignments')->where('id', $assignment_id);
        $subTopics = DB::table('topics')->where('course_id', $request->course_id)->get();
        $assignment = [
            'id' => $assignment_details->value('id'),
            'topic_id' => $assignment_details->value('topic_id'),
            'instructor_id' => $assignment_details->value('instructor_id'),
            'course_id' => $assignment_details->value('course_id'),
            'assignment_title' => $assignment_details->value('assignment_title'),
            'assignment_description' => $assignment_details->value('assignment_description'),
            'document' => $assignment_details->value('document'),
            'due_date' => Carbon::createFromFormat('Y-m-d', $assignment_details->value('due_date'))->format('m-d-Y'),
        ];

        $courseStatus = DB::table('courses')->where('id', $request->course_id)->value('is_published');
      
        return view('Course.admin.edit_assignment', [
            'course_id' => $request->course_id,
            'subTopics' => $subTopics,
            'assignment_details' => $assignment,
            'courseStatus' => $courseStatus
        ]);
    }

    /**
     * For viewing a assignments
     */
    public function viewAssignments(Request $request) {
        try {
            $course_id = $request->get('course_id');
            if($course_id){
                $course_title = DB::table('courses')->where('id', $course_id)->value('course_title');
              
                $assignments = DB::table('topic_assignments')
                                ->join('topics', 'topic_assignments.topic_id', '=', 'topics.topic_id')
                                ->where('topic_assignments.course_id', $course_id)
                                ->get();
                $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
                return view('Course.admin.view.view_assignment', [
                    'assignments' => $assignments,
                    'course_id' => $course_id,
                    'course_title' => $course_title,
                    'courseStatus' => $courseStatus
                ]);
            }

        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }

    /**
     * Saving assignments to db
     */
    public function saveAssignment(Request $request) {

        $request->validate([
            'assignment_title'=>'required',
            'assignment_description' => 'required',
            'document' =>'max:10240|mimes:pdf,doc,docx,ppt,pptx,bin',
            'due-date' =>'required',
            'assignment_topic_id' =>'required'
        ]);
        $externalLink = $request->input('external-link');
        $topicId =intval($request->input('assignment_topic_id'));
        $course_id = $request->input('course_id');
        $courseId = DB::table('topics')->where('topic_id', $topicId)->value('course_id');
        $instructorId = DB::table('assigned_courses')->where('course_id', $course_id)->value('user_id');
        
        $topicAssignment = new TopicAssignment;
        $topicAssignment->assignment_title= $request->input('assignment_title');
        $topicAssignment->assignment_description= $request->input('assignment_description');
        $topicAssignment->due_date = Carbon::createFromFormat('m-d-Y', $request->input('due-date'))->format('Y-m-d');
        
        $topicAssignment->topic_id = $topicId;
        $topicAssignment->course_id = $course_id ;
        $topicAssignment->instructor_id = $instructorId;
        $topicAssignment->external_link = $externalLink;

        if($request->file()){
            $timestamp = time();
            $doc = $request->document;

            $tFileName = $_FILES['document']['name'];
            $dotPos = strpos($tFileName,'.');
            $name = substr($tFileName, 0, $dotPos - 1);
            $ext = substr($tFileName, $dotPos + 1, strlen($tFileName));
            $filename = $name . $timestamp . '.' . $ext;

            // $filename = $request->document->getClientOriginalName() . $timestamp;
            $destinationPath = public_path().'/storage/assignmentAttachments';
            $doc->move($destinationPath,$filename);
            $topicAssignment->document = $filename;
        }
        
        $topicAssignment->save();
        return redirect('/view-assignments/?course_id=' .$course_id);
    }

    /**
     * Saving assignments to db
     */
    public function updateAssignment(Request $request) {
        $request->validate([
            'assignment_title'=>'required',
            'assignment_description' => 'required',
            'document' =>'max:10240|mimes:pdf,doc,docx,ppt,pptx,bin',
            'due-date' =>'required',
            'assignment_topic_id' =>'required'
        ]);
        $topicId =intval($request->input('assignment_topic_id'));
        $assignment_id = intval($request->input('assignment_id'));
        $course_id = $request->input('course_id');
        $instructorId = DB::table('assigned_courses')->where('course_id', $course_id)->value('user_id');
        $topicAssignment = TopicAssignment::find($assignment_id);
        
        $topicAssignment->assignment_title = $request->input('assignment_title');
        $topicAssignment->assignment_description = $request->input('assignment_description');
        // $topicAssignment->due_date = Carbon::parse($request->input('due-date'))->format('Y-m-d'); 
        
        $topicAssignment->due_date = Carbon::createFromFormat("m-d-Y", $request->input('due-date'))->format("Y-m-d");
        $topicAssignment->topic_id = $topicId;
        $topicAssignment->course_id = $course_id ;
        $topicAssignment->instructor_id = $instructorId;

        if($request->file()){
            $timestamp = time();
            $doc = $request->document;

            $tFileName = $_FILES['document']['name'];
            $dotPos = strpos($tFileName,'.');
            $name = substr($tFileName, 0, $dotPos - 1);
            $ext = substr($tFileName, $dotPos + 1, strlen($tFileName));
            $filename = $name . $timestamp . '.' . $ext;

            // $filename = $request->document->getClientOriginalName() . $timestamp;
            $destinationPath = public_path().'/storage/assignmentAttachments';
            $doc->move($destinationPath,$filename);
            $topicAssignment->document = $filename;
        }
        $topicAssignment->save();
        return redirect('/view-assignments/?course_id=' .$course_id);    
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

    public function createCohortBatch(Request $request) {
        $course_id = $request->input('course_id');
        $notifications = CohortNotification::all();
        $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
        return view('Course.admin.create_cohortbatch', [
            'course_id'=> $course_id,
            'notifications' => $notifications,
            'courseStatus' => $courseStatus
        ]);
    }

    public function saveCohortBatch(Request $request) {
        
        $validatedData = $request->validate([
            'cohortbatch_title'=>'required',
            'batchname' => 'required',
            'cohortbatch_startdate' =>'required',
            'cohortbatch_enddate' => 'required',
            'starttime_hour' =>'required',
            'starttime_minutes' =>'required',
            'endtime_hour' =>'required',
            'endtime_minutes' =>'required',
            'cohortbatch_timezone' =>'required',
            'students_count' =>'required',  
            'cohortbatch_batchname' => 'required'
        ],
        [
         'cohortbatch_enddate.after_or_equal'=> 'Date should be after start date'
        ]
     );
     // Start time
        $startHour = "";
        $startMin = "";
        
        if($request->input('starttime_ampm') == "PM") {
            if($request->input('starttime_hour') != 12) {
                $startHour = 12 + intval($request->input('starttime_hour'));
                if ($startHour < 10) {
                    $startHour = "0" . $startHour;
                }
            } else {
                $startHour = 12;
            }
        } else if($request->input('starttime_ampm') == "AM") {
            if($request->input('starttime_hour') == 12) {
                $startHour = "0" . 0;
            } else {
                if ($request->input('starttime_hour') < 10) {
                    $startHour = "0" . $request->input('starttime_hour');
                } else {
                    $startHour = $request->input('starttime_hour');
                }
            }
        }
        if($request->input('starttime_minutes') < 10) {
            $startMin = "0" . $request->input('starttime_minutes');
        } else {
            $startMin = $request->input('starttime_minutes');
        }
        $finalStartTime = $startHour . ":" . $startMin . ":00"; 

        // End time


        $endHour = "";
        $endMin = "";
        
        if($request->input('endtime_ampm') == "PM") {
            if($request->input('endtime_hour') != 12) {
                $endHour = 12 + intval($request->input('endtime_hour'));
                if ($endHour < 10) {
                    $endHour = "0" . $endHour;
                }
            } else {
                $endHour = 12;
            }
        } else if($request->input('endtime_ampm') == "AM") {
            if($request->input('endtime_hour') == 12) {
                $endHour = "0" . 0;
            }
        }
        if($request->input('endtime_minutes') < 10) {
            $endMin = "0" . $request->input('endtime_minutes');
        } else {
            $endMin = $request->input('endtime_minutes');
        }
        $finalEndTime = $endHour . ":" . $endMin . ":00";

        
        $offset = CustomTimezone::where('name', $request->input('cohortbatch_timezone')) ->value('offset');
        $offsetHours = intval($offset[1] . $offset[2]);
        $offsetMinutes = intval($offset[4] . $offset[5]);
      
        if($offset[0] == "-") {
            $sTime = strtotime($finalStartTime) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
            $eTime = strtotime($finalEndTime) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
        } else {
            $sTime = strtotime($finalStartTime) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
            $eTime = strtotime($finalEndTime) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
        }

        $startTime = date("H:i:s", $sTime);
        $endTime = date("H:i:s", $eTime);

        $cohortbatch = new CohortBatch();
        $cohortbatch->title = $request->input('cohortbatch_title');
        $cohortbatch->batchname = $request->input('batchname');
        $cohortbatch->course_id = $request->input('course_id');  
        $cohortbatch->start_date = Carbon::parse($request->input('cohortbatch_startdate'))->format('Y-m-d');
        $cohortbatch->end_date = Carbon::parse($request->input('cohortbatch_enddate'))->format('Y-m-d');
        $cohortbatch->duration = (new Carbon($request->input('cohortbatch_starttime')))->diff(new Carbon($request->input('cohortbatch_endtime')))->format('%h');
		// $cohortbatch->duration = round((strtotime($request->input('cohortbatch_enddate')) - strtotime($request->input('cohortbatch_startdate')))/3600, 1);
		$cohortbatch->occurrence = $request->input('cohortbatch_batchname');
        $cohortbatch->start_time = $startTime;
        $cohortbatch->end_time = $endTime;
        $cohortbatch->time_zone = $request->input('cohortbatch_timezone');
        $cohortbatch->students_count = $request->input('students_count');
        $cohortbatch->cohort_notification_id = $request->input('cohortbatch_notification');
        $cohortbatch->save();

        $courseStatus = DB::table('courses')->where('id', $request->input('course_id'))->value('is_published');
     
        return redirect()->route('view_cohortbatches', ['course_id' => $request->input('course_id'), 'courseStatus' => $courseStatus]);
    }

    /**
     * For viewing a Cohortbatches
     */
    public function viewCohortbatches(Request $request) {
        try {
            $course_id = $request->input('course_id');
            $course_title = DB::table('courses')->where('id', $course_id)->value('course_title');
            if($course_id) {
                $cohortbatches = DB::table('cohort_batches')
                                ->where('cohort_batches.course_id', $course_id)
                                ->get();
                $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
                                
                return view('Course.admin.view.view_cohortbatches', [
                    'cohortbatches' => $cohortbatches,
                    'course_id' => $course_id,
                    'course_title' => $course_title,
                    'courseStatus' => $courseStatus
                ]);
            }

        } catch (Exception $exception) {
            return ($exception->getMessage());
        }
    }

    public function deleteCohortbatch(Request $request){
     
        $cohort_batch_id = $request->input('cohort_batch_id');
        if ($cohort_batch_id) {
            DB::table('cohort_batches')->where('id', '=', $cohort_batch_id)->delete();
        }
        return redirect()->back();
    }


    public function editCohortbatch(Request $request){

        $cohortbatches = DB::table('cohort_batches')
                            ->where('id', $request->cohort_batch_id)
                            ->get();
                          
        $course_id = $cohortbatches[0]->course_id;
        $notifications = CohortNotification::all();
        $courseStatus = DB::table('courses')->where('id', $course_id)->value('is_published');
        return view('Course.admin.edit_cohortbatch',[
            'course_id' => $course_id,
            'cohortbatches' => $cohortbatches,
            'notifications' => $notifications,
            'courseStatus' => $courseStatus
        ]);
    }

    public function updateCohortbatches(Request $request){
        $validatedData = $request->validate([
            'cohortbatch_title'=>'required',
            'batchname' => 'required',
            'cohortbatch_startdate' =>'required',
            'cohortbatch_enddate' => 'required',
            'starttime_hour' =>'required',
            'starttime_minutes' =>'required',
            'endtime_hour' =>'required',
            'endtime_minutes' =>'required',
            'cohortbatch_timezone' =>'required',
            'students_count' =>'required',  
            'cohortbatch_batchname' => 'required'
        ],
        [
            'cohortbatch_enddate.after_or_equal'=> 'Date should be after start date',
        ]
     );

     // Start time
     $startHour = "";
     $startMin = "";
     
     if($request->input('starttime_ampm') == "PM") {
         if($request->input('starttime_hour') != 12) {
             $startHour = 12 + intval($request->input('starttime_hour'));
             if ($startHour < 10) {
                 $startHour = "0" . $startHour;
             }
         } else {
            $startHour = 12;
         }
     } else if($request->input('starttime_ampm') == "AM") {
         if($request->input('starttime_hour') == 12) {
             $startHour = "0" . 0;
         } else {
             if ($request->input('starttime_hour') < 10) {
                 $startHour = "0" . $request->input('starttime_hour');
             } else {
                 $startHour = $request->input('starttime_hour');
             }
         }
     }
     if($request->input('starttime_minutes') < 10) {
         $startMin = "0" . $request->input('starttime_minutes');
     } else {
         $startMin = $request->input('starttime_minutes');
     }
     $finalStartTime = $startHour . ":" . $startMin . ":00"; 

     // End time


     $endHour = "";
     $endMin = "";
     
     if($request->input('endtime_ampm') == "PM") {
         if($request->input('endtime_hour') != 12) {
             $endHour = 12 + intval($request->input('endtime_hour'));
             if ($endHour < 10) {
                 $endHour = "0" . $endHour;
             }
         } else {
            $endHour = 12;
         }
     } else if($request->input('endtime_ampm') == "AM") {
         if($request->input('endtime_hour') == 12) {
             $endHour = "0" . 0;
         }
     }
     if($request->input('endtime_minutes') < 10) {
         $endMin = "0" . $request->input('endtime_minutes');
     } else {
         $endMin = $request->input('endtime_minutes');
     }
     $finalEndTime = $endHour . ":" . $endMin . ":00";

        $offset = CustomTimezone::where('name', $request->input('cohortbatch_timezone')) ->value('offset');
        $offsetHours = intval($offset[1] . $offset[2]);
        $offsetMinutes = intval($offset[4] . $offset[5]);
        
        if($offset[0] == "-") {
            $sTime = strtotime($finalStartTime) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
            $eTime = strtotime($finalEndTime) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
        } else {
            $sTime = strtotime($finalStartTime) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
            $eTime = strtotime($finalEndTime) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
        }

        $startTime = date("H:i:s", $sTime);
        $endTime = date("H:i:s", $eTime);
        
        $cohort_batch_id = intval($request->input('cohort_batch_id'));
        $course_id = $request->input('course_id');
  
        $cohortbatch = CohortBatch::find($cohort_batch_id);
        $cohortbatch->course_id = $course_id;
        $cohortbatch->title = $request->input('cohortbatch_title');
        $cohortbatch->batchname = $request->input('batchname');
  
        $cohortbatch->course_id = $course_id;  
        
        $cohortbatch->start_date = Carbon::createFromFormat('m-d-Y', $request->input('cohortbatch_startdate'))->format('Y-m-d');
        $cohortbatch->end_date = Carbon::createFromFormat('m-d-Y', $request->input('cohortbatch_enddate'))->format('Y-m-d');
        $cohortbatch->duration = (new Carbon($request->input('cohortbatch_starttime')))->diff(new Carbon($request->input('cohortbatch_endtime')))->format('%h');
		// $cohortbatch->duration = round((strtotime($request->input('cohortbatch_enddate')) - strtotime($request->input('cohortbatch_startdate')))/3600, 1);
        $cohortbatch->occurrence = $request->input('cohortbatch_batchname');
        $cohortbatch->start_time = $startTime;
        $cohortbatch->end_time = $endTime;
        $cohortbatch->time_zone = $request->input('cohortbatch_timezone');
        $notifications = "";
        
        for($i=1;$i<=3;$i++){
            
            if($request->input('cohortbatch_notification_' . $i) != null) {
                    $notifications = $notifications . $request->input('cohortbatch_notification_' . $i) . ";";
            }
        }
        $notifications = substr($notifications, 0, strlen($notifications) - 1);
        $cohortbatch->cohort_notification_id = $notifications;
        $cohortbatch->students_count = $request->input('students_count');
        $cohortbatch->save();

        return redirect()->route('view_cohortbatches', ['course_id' => $course_id]);
    }

    public function publishCourse(Request $request) {
        $courseId = $request->course_id;
        
        $course = Course::find($courseId);
        if($course->is_published) {
            $course->is_published = false;
            $course->save();
    
            return response()->json(['status' => 'unpublished', 'message' => 'Unpublished successfully']);
        } else {
            $course->is_published = true;
            $course->save();
    
            return response()->json(['status' => 'published', 'message' => 'Published successfully']);
        }
        
    }
}
