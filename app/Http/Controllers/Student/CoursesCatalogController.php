<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\User;
use App\Models\Filter;
use App\Models\UserType;
use App\Models\CohortBatch;
use App\Models\LiveSession;
use App\Models\CourseCategory;
use App\Models\EnrolledCourse;
use App\Models\CustomTimezone;
use App\Models\GeneralCourseFeedback;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentMailAfterEnrolling;
use App\Mail\InstructorMailAfterEnrolling;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Models\StudentAchievement;
use App\Models\AchievementBadge;
use App\Models\AssignedCourse;
use Config;
use App\Mail\InstructorMailAfterStudentConcern;
use App\Services\CourseService;
use App\Services\UserService;
use App\Mail\AdminMailAfterStudentEnrolling;
use App\Models\Notification;
use DateTime;
use DateTimeZone;

class CoursesCatalogController extends Controller
{
    public function viewAllCourses(Request $request) {
        $courseDetails = [];
        $allCourseCategory = CourseCategory::all();
        $courses = Course::where('is_published', true)->get();
        $loggedInUserRole = Auth::user();
        if($loggedInUserRole) {
            $uRole = $loggedInUserRole->role_id;
            $loggedInUserType = UserType::where('id', $uRole)->value('user_role');
            if ($loggedInUserType == Config::get('common.ROLE_NAME_ADMIN') || $loggedInUserType == Config::get('common.ROLE_NAME_CONTENT_CREATOR')) {
                return redirect('/dashboard');
            }
        }
        
        $filters = Filter::all();
        $userType =  UserType::where('user_role', Config::get('common.ROLE_NAME_INSTRUCTOR'))->value('id');
        
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
            $ratings = $course->course_rating;
            $duration = $hours . 'h ' . $minutes . 'm';
            
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_thumbnail_image' => $course->course_thumbnail_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
                'rating' => $ratings,
                'use_custom_ratings' => $course->use_custom_ratings,
                'ratingsCount' => $ratingsCount,
                'duration' => $duration                
            );
            array_push($courseDetails, $courseData);
        }
        $courseDetailsObj = collect($courseDetails);
        return view('Student.allCourses', ['courseDatas' => $courseDetailsObj, 'allCourseCategory' => $allCourseCategory, 'filters' => $filters, 'instructors' => $instructors, 'searchTerm' => '']);
        
    }
        
    

    public function paginate($items, $perPage = 6, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function showCourse($id) {
        $currentURL = url()->current();
        $singleCourseDetails =[];
        $enrolledFlag = false;
        $singleCourseFeedbacks = [];
        $courseContents = [];
        $batchDetails = [];
        $completedFlag = false;
        if(Auth::user()) {
            $userId = Auth::user()->id;
            $progress = EnrolledCourse::where('user_id', $userId)->where('course_id', $id)->value('progress');
            $completedFlag = $progress == 100 || $progress == "100" ? true : false;
        } else {
            $userId = "";
        }
        $batchDetails = CourseService::getBatchDetails($id, $userId);
        $courseContents = CourseService::getContentsData($id);
        $user = UserService::getCurrentUserInfo();
        $userType = "";
        if($user){
            $userType =  UserService::getRoleName($user->role_id);
        }
        if ($userType == Config::get('common.ROLE_NAME_ADMIN') || $userType == Config::get('common.ROLE_NAME_CONTENT_CREATOR')) {
            return redirect('dashboard');
        }
        if($userType == "student") {
            $enrollment = CourseService::getEnrolledCourseInfo($user->id, $id);
            $enrolledFlag = (count($enrollment) != 0) ? true : false;
        }
        
        $singleCourseFeedbacks = CourseService::getSingleCourseFeedback($id);
        $singleCourseDetails = CourseService::getsingleCourseDetails($id);
        $cohort_full = CourseService::isCohortFull($id);
        return view('Student.showCourse', [
            'singleCourseDetails' => $singleCourseDetails,
            'singleCourseFeedbacks' => $singleCourseFeedbacks,
            'courseContents' => $courseContents,
            'batchDetails' => $batchDetails,            
            'userType' => $userType,
            'enrolledFlag' => $enrolledFlag,
            'currenturl' => $currentURL,
            'cohort_full_status' => $cohort_full,
            'completedFlag' => $completedFlag
        ]);
    }

    public function enrollCourse(){
        if (Auth::check() == true) {
            return response()->json(['status' => 'success', 'message' => 'User logged in !']);
        } else {
            return response()->json(['status' => 'failed', 'message' => 'Not Logged in']);
       }
    }
    
    public function loginModalProcess(Request $request) {

        $request->validate([
            'email' => 'required',
            'password' => 'required', 
        ]);
        
        $credentials = $request->only('email', 'password');
        $remember_me = ( !empty( $request->remember_me) ) ? TRUE :FALSE ;
        if (Auth::attempt($credentials)) {
           $user = Auth::user();
           $userType =  UserType::find($user->role_id)->user_role;
           $token = $user->createToken('token')->plainTextToken;
           Auth::login($user, $remember_me);
    
           if($userType == 'instructor'){
            return redirect('/');
        }else{
            return redirect()->back()->with(['success' => 'Successfully logged in!']);
            }
        }
        return redirect('/');
    }

    public function registerCourse(Request $request){

        $user = Auth::user();
        $singleCourseDetails =[];
        $course = Course::findOrFail($request->id);
        $alreadyEnrolled = EnrolledCourse::where('user_id', $user->id)->where('course_id', $request->id)->get();
        if(count($alreadyEnrolled) > 0) {
            return redirect()->route('student.course.enrolled', [$request->id]);
        }
        $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');
        $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
        $instructorfirstname = User::where('id', $assigned)->value('firstname');
        $instructorlastname = User::where('id', $assigned)->value('lastname');

        $current_date = Carbon::now()->format('Y-m-d');
        $batches = DB::table('cohort_batches')->where('course_id', $course->id)->where('start_date', '>=', $current_date)->get();

        $offset = CustomTimezone::where('name', $user->timezone)->value('offset');

        $offsetHours = intval($offset[1] . $offset[2]);
        $offsetMinutes = intval($offset[4] . $offset[5]);
            
        $date = new DateTime("now");
        $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');

        foreach($batches as $batch){
            $available_count = $batch->students_count;
            if($offset[0] == "+") {
                $sTime = strtotime($batch->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                $eTime = strtotime($batch->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
            } else {
                $sTime = strtotime($batch->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                $eTime = strtotime($batch->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
            }
                    
            $startTime = date("H:i A", $sTime);
            $endTime = date("H:i A", $eTime);

            $booked_slotes = DB::table('enrolled_courses')
                               ->where([['course_id','=',$course->id],['batch_id','=',$batch->id]])
                               ->get();
            $booked_slotes_count = count($booked_slotes);
            $available_count = $available_count-$booked_slotes_count;
            
            $singleCourseData =  array (
                'batch_id' => $batch->id,
                'batchname' => $batch->batchname,
                'title' => $batch->title,
                'start_date' => Carbon::createFromFormat('Y-m-d',$batch->start_date)->format('M d'),
                'start_time'=> $startTime,
                'end_time' => $endTime,
                'time_zone' => $time_zone,
                'available_count' => $available_count
            );
        
        array_push($singleCourseDetails, $singleCourseData);
      }

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
      $ratings = $course->course_rating;
      $studentCount = EnrolledCourse::where('course_id', $course->id)->count();

      $courseDetails = array (
        'course_id' => $course->id,
        'course_title' => $course->course_title,
        'course_category' => $courseCategory,
        'description' => $course->description,
        'course_difficulty' => $course->course_difficulty,
        'instructor_firstname' => $instructorfirstname,
        'instructor_lastname' => $instructorlastname,
        'course_thumbnail_image' => $course->course_thumbnail_image,
        'rating' => $ratings,
        'studentCount' => $studentCount,
        'use_custom_ratings' => $course->use_custom_ratings,
        'ratingsCount' => $ratingsCount,
        'duration' => $duration
      );
     
        return view('Student.registerCourse', [
            'singleCourseDetails' => $singleCourseDetails,
            'courseDetails' => $courseDetails
        ]);

    }

    public function registerCourseProcess(Request $request){
      
    try {
       $courseId = $request->course_id;
       $course_title = Course::where('id',  $courseId)->value('course_title');
       $batchId = $request->batch_id;
       $user = Auth::user();
       $userId = $user->id;
       $userType = UserType::all();
       $user_type = UserType::where('user_role', 'Admin')->value('id');
       $admins = User::where('role_id', $user_type)->get();
       $studentEmail= $user->email;
       $assigned = DB::table('assigned_courses')->where('course_id',  $courseId)->value('user_id');
       $instructor = User::where('id', $assigned);
       $instructorEmail =  $instructor->value('email');
       $instructorName =  $instructor->value('firstname') .' '.$instructor->value('lastname');
    
       $alreadyEnrolled = EnrolledCourse::where('user_id', $userId)->where('course_id', $courseId)->get();
       if(count($alreadyEnrolled) == 0) {
        $enrolledCourse = new EnrolledCourse;
        $enrolledCourse->user_id = $userId;
        $enrolledCourse->batch_id = $batchId;
        $enrolledCourse->course_id = $courseId;
        $enrolledCourse->progress = 0;
        $enrolledCourse->save();
       
       $badgeId = AchievementBadge::where('title', 'Joinee')->value('id');

       $badgeAlreadyExists = StudentAchievement::where('student_id', $userId)->where('course_id', $courseId)->where('badge_id', $badgeId)->get();
       
       if(count($badgeAlreadyExists) == 0) {
            $student_achievement = new StudentAchievement;
            $student_achievement->student_id = $userId;
            $student_achievement->badge_id =  $badgeId;
            $student_achievement->course_id =  $courseId;
            $student_achievement->is_achieved = true;
            $student_achievement->save();
       }

       $mailDetails = [
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'instructor_name' => $instructorName,
            'course' => $course_title
        ];
        Mail::mailer('infosmtp')->to($studentEmail)->send(new StudentMailAfterEnrolling($mailDetails));

        $data = [
            'instructor_name' => $instructorName,
            'course_title' => $course_title
        ];

        Mail::mailer('infosmtp')->to($instructorEmail)->send(new InstructorMailAfterEnrolling($data));

        foreach($admins as $admin) {
            $mailData=[
                'adminFirstName' => $admin->firstname,
                'adminLastName' => $admin->lastname,
                'course_title' => $course_title
             ];
            Mail::mailer('infosmtp')->to($admin->email)->send(new AdminMailAfterStudentEnrolling($mailData));
            $notification = new Notification; 
            $notification->user = $admin->id;
            $notification->notification = "Hello ".$admin->firstname." " .$admin->lastname.", You have got a new student enrolled in your ".$course_title." course.";
            $notification->is_read = false;
            $notification->save();
        }
       
        $notification = new Notification; 
        $notification->user = $user->id;
        $notification->notification = "Welcome to the ". $course_title ." course, hope you have a great learning experience!";
        $notification->is_read = false;
        $notification->save();

        $notification = new Notification; 
        $notification->user = $assigned;
        $notification->notification = "Great news! A new student just enrolled to the course - ". $course_title;
        $notification->is_read = false;
        $notification->save();
    }

        $courseObj = Course::where('id', $courseId);
        $enrollmentsCount = $courseObj->value('enrollments');
        $courseObj = $courseObj->update(['enrollments' => $enrollmentsCount + 1]);

        return response()->json([
            'status' => 'success', 
            'message' => 'Enrolled successfully'
            ]);
        
       }catch (Exception $exception){

        return response()->json([
            'status' => 'success', 
            'message' => 'Enrolled successfully'
         ]);
        }
    }


    public function filterCourse(Request $request) {
     
     $html = '';
     $categoryFlag = 0;
     $levelsFlag = 0;
     $ratingsFlag = 0;
     $durationFlag = 0;
     $instructorFlag = 0;
     $instructors = $request->instructors;
     $categories = $request->categories;
     $levels = $request->levels;
     $ratings = $request->ratings;
     $duration = $request->duration;
     
     $courses = DB::table('courses')->where('is_published', true);
     
     if($instructors) {
        $instructorsArr = explode(",", $instructors);
        
        foreach($instructorsArr as $instructor) {
           $instructorPair = explode('=', $instructor);
           
           if($instructorFlag == 0) {
               $courses = $courses->where('instructor_id', $instructorPair[1]);
               $instructorFlag = 1;
           } else {
               $courses = $courses->orWhere('instructor_id', $instructorPair[1]);
           }
        }
    }

     if($categories) {
         $categoriesArr = explode(",", $categories);
         foreach($categoriesArr as $category) {
            $categoryPair = explode('=', $category);
            if($categoryFlag == 0) {
                $courses = $courses->where('category', $categoryPair[1]);
                $categoryFlag = 1;
            } else {
                $courses = $courses->orWhere('category', $categoryPair[1]);
            }
         }
     }

     if($levels) {
        $levelsArr = explode(",", $levels);
        foreach($levelsArr as $level) {
           $levelPair = explode('=', $level);
           
            if($levelPair[1] == "all") {
                $courses = $courses->where('course_difficulty', 'beginner')->orWhere('course_difficulty', 'intermediate')->orWhere('course_difficulty', 'advanced');
                break;
            }
            if($levelsFlag == 0) {
                if($categoryFlag == 1) {
                    $courses = $courses->where('course_difficulty', $levelPair[1]);
                    dd($courses->count());
                }
                $levelsFlag = 1;
            } else {
                $courses = $courses->orWhere('course_difficulty', $levelPair[1]);
            }
        }
    }

    if($ratings) {
        $ratingsArr = explode(",", $ratings);
        foreach($ratingsArr as $rating) {
           $ratingPair = explode('=', $rating);
            if($ratingsFlag == 0) {
                $courses = $courses->where('course_rating', '>=' , $ratingPair[1]);
                $ratingsFlag = 1;
            } else {
                $courses = $courses->orWhere('course_rating', '>=' , $ratingPair[1]);
            }
        }
    }

    if($duration) {
        $durationArr = explode(",", $duration);
        foreach($durationArr as $durationFil) {
            $durationPair = explode('=', $durationFil);
            if($durationFlag == 0) {
                $durationFlag = 1;
                if($durationPair[1] == "less_than_1") {
                    $courses = $courses->where('course_duration', '<', 1);
                } else if($durationPair[1] == "less_than_2") {
                    $courses = $courses->where('course_duration', '<', 2);
                } else if($durationPair[1] == "less_than_5") {
                    $courses = $courses->where('course_duration', '<', 5);
                } else if($durationPair[1] == "greater_than_5") {
                    $courses = $courses->where('course_duration', '>', 5);
                }  
            } else {
                if($durationPair[1] == "less_than_1") {
                    $courses = $courses->orWhere('course_duration', '<', 1);
                } else if($durationPair[1] == "less_than_2") {
                    $courses = $courses->orWhere('course_duration', '<', 2);
                } else if($durationPair[1] == "less_than_5") {
                    $courses = $courses->orWhere('course_duration', '<', 5);
                } else if($durationPair[1] == "greater_than_5") {
                    $courses = $courses->orWhere('course_duration', '>', 5);
                }  
            }
        }
    }


     $courses = $courses->get();
     if(count($courses)) {
           foreach($courses as $course) {
				
				// $ratingsCount = 0;
				// if($course->use_custom_ratings) {
				// 	$ratings = $course->course_rating;
				// } 
				// else{
				// 	$generalCourseFeedbacks = GeneralCourseFeedback::where('course_id', $course->id)->get();
				// 	foreach($generalCourseFeedbacks as $generalCourseFeedback) {
				// 		$ratingsCount++;
				// 	}
				// }
                $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');     
                $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
                $instructorfirstname = User::where('id', $assigned)->value('firstname');
                $instructorlastname = User::where('id', $assigned)->value('lastname');
                
                $duration = $course->course_duration;
                $hours = intval($duration);
                $minutesDecimal = $duration - $hours;
                $minutes = ($minutesDecimal/100) * 6000;
    
                $duration = $hours . 'h ' . $minutes . 'm';
                $html = $html . '<div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4"><div class="card-1">';
                if(!$course->course_thumbnail_image) {
                    $html = $html . '<img src="/storage/courseThumbnailImages/defaultImage.png" class="card-img-top" alt="'. $course->course_title .'"><div class="card-body pb-0 fs-14">';
                } else {
                    $html = $html . '<img src="/storage/courseThumbnailImages/'. $course->course_thumbnail_image .'" class="card-img-top" alt="'. $course->course_title .'"><div class="card-body pb-0 fs-14">';
                }

                // ratings

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
                $ratings = $course->course_rating;
                $html = $html . '<h5 class="card-title text-center text-truncate fs-16 fw-bold">'. $course->course_title .'</h5>';
                $html = $html . '<p class="card-text text-sm-start text-truncate">'. $course->description .'</p>';
                $html = $html . '<div class="row mb-3"><div class="col-lg-6 col-sm-6 col-6">';
                for($i=1;$i<=5;$i++) {
                    if($i <= $ratings) {
                        $html = $html . '<i class="fas fa-star rateCourse"></i>';
                    } else {
                        $html = $html . '<i class="far fa-star rateCourse"></i>';
                    }
                } 
				if($course->use_custom_ratings == false) {
					$html = $html . '('.$ratingsCount.')</div>';  
				} else {
					$html = $html . '(10)</div>'; 
				}
                
                $html = $html . '<div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">';  
                $html = $html . '<img class="me-1 think-w-14_5" src="/storage/icons/category__icon.svg" alt="error">'. $courseCategory .'</div></div>';
                $html = $html . '<ul class="list-group list-group-flush"><li class="list-group-item"><div class="row">'; 
                $html = $html . '<div class="col-auto item-1 px-0"><i class="far fa-clock pe-1"></i>'. $duration .'</div>';
                $html = $html . '<div class="col item-2 px-0 text-center"><p class="think-text-color-grey fw-bold"><i class="far fa-user pe-1"></i>'. $instructorfirstname .' '. $instructorlastname .'</p></div>';
                $html = $html . '<div class="col-auto item-3 px-0 d-flex"><p class="think-text-color-grey fw-bold text-end"><img src="/storage/icons/level__icon.svg" class="me-1">'. $course->course_difficulty .'</p></div></div></li></ul>';
                $html = $html . '<div class="row py-2"><div class="text-center border-top">'; 
                $html = $html . '<a href="/show-course/' . $course->id . '" class="card-link btn d-inline-block w-100 px-0">Go to details</a>'; 
                $html = $html . '</div></div></div></div></div>';        
            }
        } else {
            $html = '<div class="think-nodata-box px-4 py-5 my-5 text-center mh-100"><img class="mb-3" src="/storage/icons/no_data_available.svg" alt="No courses to be shown!"><h4 class="fw-bold">No courses to be shown!</h4></div>';
        }
     return response()->json([
        'status' => 'success', 
        'message' => 'submitted successfully',
        'html' => $html
     ]);
    
    }

    public function courseDropDown(Request $request) {
        $html = "";
        $filterValue = $request->filterValue;
        if($filterValue == "most_popular") {
            $courses = Course::where('is_published', true)->orderBy('enrollments', 'DESC')->get();
        } elseif ($filterValue == "most_reviewed") {
            $courses = Course::where('is_published', true)->orderBy('ratings_count', 'DESC')->get();
        }

        if(count($courses)) {
            foreach($courses as $course) {
                 
                 $ratingsCount = 0;
                 if($course->use_custom_ratings) {
                     $ratings = $course->course_rating;
                 } 
                 else{
                     $generalCourseFeedbacks = GeneralCourseFeedback::where('course_id', $course->id)->get();
                     foreach($generalCourseFeedbacks as $generalCourseFeedback) {
                         $ratingsCount++;
                     }
                 }
                 $courseCategory = CourseCategory::where('id', $course->category)->value('category_name');     
                 $assigned = DB::table('assigned_courses')->where('course_id', $course->id)->value('user_id');
                 $instructorfirstname = User::where('id', $assigned)->value('firstname');
                 $instructorlastname = User::where('id', $assigned)->value('lastname');
                 
                 $duration = $course->course_duration;
                 $hours = intval($duration);
                 $minutesDecimal = $duration - $hours;
                 $minutes = ($minutesDecimal/100) * 6000;
     
                 $duration = $hours . 'h ' . $minutes . 'm';
                 $html = $html . '<div class="col-lg-6 col-md-6 col-sm-6 col-12 mb-4"><div class="card-1">';
                 if(!$course->course_thumbnail_image) {
                     $html = $html . '<img src="/storage/courseThumbnailImages/defaultImage.png" class="card-img-top" alt="'. $course->course_title .'"><div class="card-body pb-0 fs-14">';
                 } else {
                     $html = $html . '<img src="/storage/courseThumbnailImages/'. $course->course_thumbnail_image .'" class="card-img-top" alt="'. $course->course_title .'"><div class="card-body pb-0 fs-14">';
                 }
 
                 // ratings
 
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
                 $ratings = $course->course_rating;
                 $html = $html . '<h5 class="card-title text-center text-truncate fs-16 fw-bold">'. $course->course_title .'</h5>';
                 $html = $html . '<p class="card-text text-sm-start text-truncate">'. $course->description .'</p>';
                 $html = $html . '<div class="row mb-3"><div class="col-lg-6 col-sm-6 col-6">';
                 for($i=1;$i<=5;$i++) {
                     if($i <= $ratings) {
                         $html = $html . '<i class="fas fa-star rateCourse"></i>';
                     } else {
                         $html = $html . '<i class="far fa-star rateCourse"></i>';
                     }
                 } 
                 if($course->use_custom_ratings == false) {
                     $html = $html . '('.$ratingsCount.')</div>';  
                 } else {
                     $html = $html . '(10)</div>'; 
                 }
                 
                 $html = $html . '<div class="col-lg-6 col-sm-6 col-6 tech d-flex justify-content-end">';  
                 $html = $html . '<img class="me-1 think-w-14_5" src="/storage/icons/category__icon.svg" alt="error">'. $courseCategory .'</div></div>';
                 $html = $html . '<ul class="list-group list-group-flush"><li class="list-group-item"><div class="row">'; 
                 $html = $html . '<div class="col-auto item-1 px-0"><i class="far fa-clock pe-1"></i>'. $duration .'</div>';
                 $html = $html . '<div class="col item-2 px-0 text-center"><p><i class="far fa-user pe-1"></i>'. $instructorfirstname .' '. $instructorlastname .'</p></div>';
                 $html = $html . '<div class="col-auto item-3 px-0 d-flex"><p class="text-end"><img src="/storage/icons/level__icon.svg" class="me-1">'. $course->course_difficulty .'</p></div></div></li></ul>';
                 $html = $html . '<div class="row py-2"><div class="text-center border-top">'; 
                 $html = $html . '<a href="/show-course/' . $course->id . '" class="card-link btn d-inline-block w-100 px-0">Go to details</a>'; 
                 $html = $html . '</div></div></div></div></div>';        
             }
         } else {
             $html = '<div class="think-nodata-box px-4 py-5 my-5 text-center mh-100"><img class="mb-3" src="/storage/icons/no_data_available.svg" alt="No courses to be shown!"><h4 class="fw-bold">No courses to be shown!</h4></div>';
         }

         return response()->json([
            'status' => 'success', 
            'message' => 'submitted successfully',
            'html' => $html
         ]);
    }

    public static function getAllCourses() {

        $courseDetails = [];

        $courses = Course::where('is_published', true)->get();

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
            $ratings = $course->course_rating;
            $duration = $hours . 'h ' . $minutes . 'm';
       
            $courseData =  array (
                'id' => $course->id,
                'course_title' => $course->course_title,
                'course_category' => $courseCategory,
                'description' => $course->description,
                'course_thumbnail_image' => $course->course_thumbnail_image,
                'course_difficulty' => $course->course_difficulty,
                'instructor_firstname' => $instructorfirstname,
                'instructor_lastname' => $instructorlastname,
                'rating' => $ratings,
                'use_custom_ratings' => $course->use_custom_ratings,
                'ratingsCount' => $ratingsCount,
                'duration' => $duration
            );
            array_push($courseDetails, $courseData);
        }
        return $courseDetails;
    }

    public function haveAnyQuestion(Request $request) {
        
        try {
            $name = $request->name;
            $phone = $request->phone;
            $message = $request->message;
            $email = $request->email;
            $courseId = $request->course_id;

            $assigned = CourseService::getInstructorByCourse($courseId);
            $instructorName = UserService::getUserFullName($assigned);
            $instructorEmail = UserService::getUserEmail($assigned);
     
            $details = [
                'name' => $name,
                'message' => $message,
                'email' => $email,
                'instructorName' => $instructorName
            ];
            
            Mail::mailer('infosmtp')->to($instructorEmail)->send(new InstructorMailAfterStudentConcern($details));

            $notification = new Notification; 
            $notification->user =  $assigned;
            $notification->notification = "Hi ".$instructorName.", You have got a new concern from a student.".$name."Details as follows," .$message.".";
            $notification->is_read = false;
            $notification->save();

    
            return redirect()->back()->with('message', 'Message sent successfully!');
        } catch (Exception $exception) {
            return redirect()->back()->with('message', 'Message sent successfully!');
        }
        
    }
}
