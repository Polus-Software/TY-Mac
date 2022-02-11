<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Models\CohortBatch;
use App\Models\User;
use App\Models\Course;
use App\Models\AssignedCourse;
use App\Models\EnrolledCourse;
use App\Models\LiveSession;
use Illuminate\Support\Facades\Mail;
use App\Mail\LiveSessionReminderMail;
use App\Mail\AssignmentReminder;
use App\Mail\LiveSessionReminderMailInstructor;
use Carbon\Carbon;
use App\Models\CustomTimezone;
use App\Models\TopicAssignment;
use App\Models\Assignment;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $notifIds = [];
            $mailDetails = [];
            $current_date = Carbon::now()->format('Y-m-d');
            $threeDays = Carbon::now()->addDays(3)->format('Y-m-d');
            $oneDay = Carbon::now()->addDays(1)->format('Y-m-d');
            $liveSessions = LiveSession::where('start_date', '>=', $current_date)->get();
            foreach($liveSessions as $liveSession) {
                $batchId = $liveSession->batch_id;
                $batch = CohortBatch::where('id', $batchId);
               
                $notificationSettings = $batch->value('cohort_notification_id');
                $notifIds = explode(';', $notificationSettings);
               
                foreach($notifIds as $notifId) {
                    
                    if($notifId == 1) {
                        if($liveSession->start_date == $threeDays) {
                            if($liveSession->first_notification_sent == 0) {
                                $enrolledCourseData = EnrolledCourse::where('batch_id', $batchId)->get();
                                foreach($enrolledCourseData as $data) {
                                    $student = User::where('id', $data->user_id);
                                    $course = Course::where('id', $liveSession->course_id);
                                    $instructorId = AssignedCourse::where('course_id', $liveSession->course_id)->value('user_id');
                                    
                                    $instructor = User::where('id', $instructorId);
                                    

                                    $offset = CustomTimezone::where('name', $student->value('timezone'))->value('offset');
                        
                                    $offsetHours = intval($offset[1] . $offset[2]);
                                    $offsetMinutes = intval($offset[4] . $offset[5]);
                    
                                    if($offset[0] == "+") {
                                        $sTime = strtotime($liveSession->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                                        $eTime = strtotime($liveSession->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                                    } else {
                                        $sTime = strtotime($liveSession->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                                        $eTime = strtotime($liveSession->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                                    }
                    
                                    $startTime = date("H:i A", $sTime);
                                    $endTime = date("H:i A", $eTime);

                                    $details = [
                                        'firstname' => $student->value('firstname'),
                                        'lastname' => $student->value('lastname'),
                                        'session_name' => $liveSession->session_title,
                                        'instructor_name' => $instructor->value('firstname') .' '.$instructor->value('lastname'),
                                        'course_name' => $course->value('course_title'),
                                        'time' => date("m-d-Y", strtotime($liveSession->start_date)) . ', from ' . $startTime .' to '. $endTime,
                                        'reminder' => '72 hours'
                                    ];
                                    
                                    Mail::mailer('infosmtp')->to($student->value('email'))->send(new LiveSessionReminderMail($details));
                                    $session = LiveSession::where('live_session_id', $liveSession->live_session_id)->update(['first_notification_sent' => true]);
                                }
                                // Instructor Mail
                                $iDetails = [
                                    'instructorName' => $instructor->value('firstname') .' '.$instructor->value('lastname'),
                                    'sessionName' => $liveSession->session_title,
                                    'course_name' => $course->value('course_title'),
                                    'reminder' => '72 hours'
                                ];
                                Mail::mailer('infosmtp')->to($instructor->value('email'))->send(new LiveSessionReminderMailInstructor($details));
                            }
                        }
                        
                    } elseif ($notifId == 2) {
                        if($liveSession->second_notification_sent == 0) {
                            if($liveSession->start_date == $current_date) {
                                if(Carbon::now()->format('H:i') == date("H:i", strtotime($liveSession->start_time) - (60 * 60 * 8) + (60 * 0))) {
                                    $enrolledCourseData = EnrolledCourse::where('batch_id', $batchId)->get();
                                    foreach($enrolledCourseData as $data) {
                                        
                                        $student = User::where('id', $data->user_id);
                                        $course = Course::where('id', $liveSession->course_id);
                                        $instructorId = AssignedCourse::where('course_id', $liveSession->course_id)->value('user_id');
                                        
                                        $instructor = User::where('id', $instructorId);
                                        $offset = CustomTimezone::where('name', $student->value('timezone'))->value('offset');
                        
                                        $offsetHours = intval($offset[1] . $offset[2]);
                                        $offsetMinutes = intval($offset[4] . $offset[5]);
                        
                                        if($offset[0] == "+") {
                                            $sTime = strtotime($liveSession->start_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                                            $eTime = strtotime($liveSession->end_time) + (60 * 60 * $offsetHours) + (60 * $offsetMinutes);
                                        } else {
                                            $sTime = strtotime($liveSession->start_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                                            $eTime = strtotime($liveSession->end_time) - (60 * 60 * $offsetHours) - (60 * $offsetMinutes);
                                        }
                        
                                        $startTime = date("H:i A", $sTime);
                                        $endTime = date("H:i A", $eTime);
                                        $details = [
                                            'firstname' => $student->value('firstname'),
                                            'lastname' => $student->value('lastname'),
                                            'session_name' => $liveSession->session_title,
                                            'instructor_name' => $instructor->value('firstname') .' '.$instructor->value('lastname'),
                                            'course_name' => $course->value('course_title'),
                                            'time' => date("m-d-Y", strtotime($liveSession->start_date)) . ', from ' . $startTime .' to '. $endTime,
                                            'reminder' => '8 hours'
                                        ];
                                        
                                        Mail::mailer('infosmtp')->to($student->value('email'))->send(new LiveSessionReminderMail($details));
                                        $session = LiveSession::where('live_session_id', $liveSession->live_session_id)->update(['second_notification_sent' => true]);
                                    }

                                    $iDetails = [
                                        'instructorName' => $instructor->value('firstname') .' '.$instructor->value('lastname'),
                                        'sessionName' => $liveSession->session_title,
                                        'course_name' => $course->value('course_title'),
                                        'reminder' => '8 hours'
                                    ];
                                    Mail::mailer('infosmtp')->to($instructor->value('email'))->send(new LiveSessionReminderMailInstructor($details));

                                }  
                            }
                        }
                    }
                }
            }
        })->everyThirtyMinutes();

        $schedule->call(function () {
            // Assignment Cron

            $topicAssignment = TopicAssignment::all();
            foreach($topicAssignment as $assignment) {
                $courseId = $assignment->course_id;
                $course = Course::where('id', $courseId);
                $enrolledCourseData = EnrolledCourse::where('course_id', $courseId)->get();
                $instructorId = AssignedCourse::where('course_id', $liveSession->course_id)->value('user_id');
                $instructor = User::where('id', $instructorId);
                foreach($enrolledCourseData as $data) {
                    $assignmentFlag = false;
                    $student = User::where('id', $data->user_id);
                    $studentAssignment = Assignment::where('student_id', $data->user_id)
                                                ->where('course_id', $courseId);
                                                
                    if($studentAssignment->count() == 0) {
                        $assignmentFlag = true;
                    } else {
                        if($studentAssignment->value('is_submitted') == false) {
                            $assignmentFlag = true;
                        } else {
                            $assignmentFlag = false;
                        }
                    }
                    
                    $details = [
                        'firstname' => $student->value('firstname'),
                        'lastname' => $student->value('lastname'),
                        'link' => base_path() . '/enrolled-course/' . $courseId,
                        'instructor_name' => $instructor->value('firstname') .' '.$instructor->value('lastname'),
                        'course_name' => $course->value('course_title'),
                        'date' => date("m-d-Y", strtotime($assignment->due_date))
                    ];
                    
                    if($assignmentFlag == true && $assignment->due_date == $oneDay) {
                        Mail::mailer('infosmtp')->to($student->value('email'))->send(new AssignmentReminder($details));
                    }
                }                   
            }
        })->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
