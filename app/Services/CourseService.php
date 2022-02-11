<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Topic;
use App\Models\TopicContent;
use App\Models\CourseCategory;
use App\Models\CustomTimezone;
use App\Models\LiveSession;
use App\Models\EnrolledCourse;
use Carbon\Carbon;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;


class CourseService {

    /**
     * Get instructor id by course id
     * @param - courseId
     * @output - instructorId
     */
    public static function getInstructorByCourse(int $courseId) {
        return DB::table('assigned_courses')->where('course_id',  $courseId)->value('user_id');
    }

    /**
     * Get course details by course id
     * @param - courseId
     * @output - course details
     */
    public static function getCourseInfo(int $courseId) {
        return Course::findOrFail($courseId)->first();
    }

    /**
     * convert time to hours and minutes
     * @param - time
     * @output - time in hours and minutes
     */
    public static function convertTime($time) {
        $hours = intval($time);
        $minutesDecimal = $time - $hours;
        $minutes = ($minutesDecimal/100) * 6000;
        return $hours . 'h ' . $minutes . 'm';
    }

    /**
     * Get course details by course id
     * @param - courseId
     * @output - course details
     */
    public static function getCohortBatchesByCourse(int $courseId) {
        return DB::table('cohort_batches')->where('course_id', $courseId)->get();
    }

    /**
     * Get topics by course id
     * @param - courseId
     * @output - topics
     */
    public static function getTopicsByCourse(int $courseId) {
        return Topic::where('course_id', $courseId)->get();
    }

    /**
     * Get topics by course id
     * @param - courseId
     * @output - topics
     */
    public static function getContentsByTopic(int $topicId) {
        return TopicContent::where('topic_id', array($topicId))->get();
    }

    /**
     * Get topics content data by course id
     * @param - courseId
     * @output - content data
     */
    public static function getContentsData($id) {
        $contentsData = [];
        $courseContents = [];
        $topics = self::getTopicsByCourse($id);        
         foreach($topics as $topic){
             $topicId = $topic->topic_id;
             $topic_title =  $topic->topic_title;
             $topicContentArray= self::getContentsByTopic($topicId);
             $contentsData = $topicContentArray->toArray();
             array_push($courseContents, array(
                 'topic_id' => $topicId,
                 'topic_title' =>$topic_title,
                 'contentsData' => $contentsData
             ));
         }
         return $courseContents;
    }

    /**
     * Get course Category by Category id
     * @param - Category id
     * @output - category_name
     */
    public static function getCategoryName(int $categoryId) {
        return CourseCategory::where('id', $categoryId)->value('category_name');
    }

    /**
     * Get course Category by Category id
     * @param - Category id
     * @output - category_name
     */
    public static function getLiveSessionDetails(int $batchId) {
        $current_date = Carbon::now()->format('Y-m-d');
        return LiveSession::where('batch_id', $batchId)->where('start_date', '>', $current_date)->orderby('start_date', 'asc')->get();
    }

    /**
     * Get topics content data by course id
     * @param - courseId
     * @output - content data
     */
    public static function getBatchDetails($id) {
        $user = Auth::user();
        $batchDetails = [];
        $batches = self::getCohortBatchesByCourse($id);
        foreach($batches as $batch){
            $batchname = $batch->batchname;
            $batch_start_date = $batch->start_date;
            $batch_start_time = $batch->start_time;
            $batch_end_time = $batch->end_time;
            $batch_end_date = $batch->end_date;
            $batch_time_zone = $batch->time_zone;

            $offset = CustomTimezone::where('name', $user->timezone)->value('offset');
                        
            $offsetHours = intval($offset[1] . $offset[2]);
            $offsetMinutes = intval($offset[4] . $offset[5]);
                    
            if($offset[0] == "+") {
                $sTime = strtotime($batch_start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                $eTime = strtotime($batch_end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
            } else {
                $sTime = strtotime($batch_start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                $eTime = strtotime($batch_end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
            }
                    
            $startTime = date("H:i A", $sTime);
            $endTime = date("H:i A", $eTime);
            $date = new DateTime("now");
            $time_zone = $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "+" || $date->setTimeZone(new DateTimeZone($user->timezone))->format('T')[0] == "-" ? "(UTC " .$date->setTimeZone(new DateTimeZone($user->timezone))->format('T') . ")": $date->setTimeZone(new DateTimeZone($user->timezone))->format('T');
            
            $liveSession = self::getLiveSessionDetails($batch->id);
            if(count($liveSession)) {
               $latest = $liveSession[0];               
               array_push($batchDetails, array(
                    'batchname' => $batchname,
                    'batch_start_date' => Carbon::createFromFormat('Y-m-d',$batch_start_date)->format('m/d/Y'),
                    'batch_start_time' => $startTime,
                    'batch_end_time' => $endTime,
                    'batch_end_date' =>  Carbon::createFromFormat('Y-m-d',$batch_end_date)->format('m/d/Y'),
                    'batch_time_zone' => $time_zone,
                    'latest' =>  $latest
                ));
            }
        }
        return $batchDetails;
    }

    /**
     * Get course Category by Category id
     * @param - Category id
     * @output - category_name
     */
    public static function getEnrolledCourseInfo(int $userId, int $courseId) {
        return EnrolledCourse::where('user_id', $userId)->where('course_id', $courseId)->get();
    }


    /**
     * Get course Category by Category id
     * @param - Category id
     * @output - category_name
     */
    public static function getGeneralCourseFeedback(int $courseId) {
        return DB::table('general_course_feedback')->where([['course_id',$courseId],['is_moderated',1]])->get();
    }

    /**
     * Get course Category by Category id
     * @param - Category id
     * @output - category_name
     */
    public static function getSingleCourseFeedback(int $courseId) {
        $singleCourseFeedbacks = [];
        $generalCourseFeedbacks = self::getGeneralCourseFeedback($courseId);
        foreach($generalCourseFeedbacks as $generalCourseFeedback){
            $studentFullname = UserService::getUserFullName($generalCourseFeedback->user_id);
            $studentProfilePhoto = UserService::getUserProfilePhoto($generalCourseFeedback->user_id);
            array_push($singleCourseFeedbacks, array(
                'user_id' => $generalCourseFeedback->user_id,
                'rating' => $generalCourseFeedback->rating,
                'comment' => $generalCourseFeedback->comment,
                'created_at' => Carbon::parse($generalCourseFeedback->created_at)->diffForHumans(),
                'studentFullname' => $studentFullname,
                'studentProfilePhoto' => $studentProfilePhoto,
                ));
        }
        return $singleCourseFeedbacks;
    }

    /**
     * Get course Category by Category id
     * @param - Category id
     * @output - category_name
     */
    public static function getsingleCourseDetails(int $courseId) {
        $singleCourseDetails= [];
        $course = self::getCourseInfo($courseId);
        $courseCategory = self::getCategoryName($course->category);
        $duration = self::convertTime($course->course_duration);
        $assigned = self::getInstructorByCourse($course->id);
        $instructorInfo = UserService::getUserInfo($assigned);
        $short_description = explode(";",$course->short_description);
        $course_details_points = $course->course_details_points;
        $singleCourseData =  array (
            'id' => $course->id,
            'course_title' => $course->course_title,
            'course_category' => $courseCategory,
            'description' => $course->description,
            'course_difficulty' => $course->course_difficulty,
            'course_details' => $course->course_details,
            'course_image' => $course->course_image,
            'instructorId' => $assigned,
            'instructor_firstname' => $instructorInfo->firstname,
            'instructor_lastname' => $instructorInfo->lastname,
            'profile_photo' => $instructorInfo->image,
            'designation' => $instructorInfo->designation,
            'institute' => $instructorInfo->institute,
            'instructorDescription' => $instructorInfo->description,
            'instructorTwitter' => $instructorInfo->twitter_social,
            'instructorLinkedin' => $instructorInfo->linkedIn_social,
            'instructorYoutube' => $instructorInfo->youtube_social,
            'duration' => $duration,
            'short_description' => $short_description,
            'course_details_points' => $course_details_points
        );
        array_push($singleCourseDetails, $singleCourseData);
        return $singleCourseDetails;
    }

    /**
     * Get BookedSlots
     * @param - courseId, batchId
     * @output - 
     */
    public static function getBookedSlots(int $courseId, int $batchId) {
        return DB::table('enrolled_courses')
        ->where([['course_id','=', $courseId],['batch_id','=', $batchId]])
        ->get();
    }

    /**
     * check whether cohort is full
     * @param - courseId
     * @output - true/false
     */
    
    public static function isCohortFull(int $courseId) {
        $batches = self::getCohortBatchesByCourse($courseId);
        $cohort_full = true;
        foreach($batches as $batch){
            $available_count = $batch->students_count;
            $booked_slotes = self::getBookedSlots($courseId, $batch->id);
            $booked_slotes_count = count($booked_slotes);
            $available_count = $available_count-$booked_slotes_count;
            if($available_count > 0){
                $cohort_full = false;
            }
        }
        return $cohort_full;
    }
}