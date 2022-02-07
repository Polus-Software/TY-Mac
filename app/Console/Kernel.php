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
use Carbon\Carbon;

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
                                   
                                    
                                    $details = [
                                        'firstname' => $student->value('firstname'),
                                        'lastname' => $student->value('lastname'),
                                        'session_name' => $liveSession->session_title,
                                        'instructor_name' => $instructor->value('firstname') .' '.$instructor->value('lastname'),
                                        'course_name' => $course->value('course_title'),
                                        'time' => $liveSession->start_date . ' ' . $liveSession->start_time .' '. $liveSession->end_time 
                                    ];

                                    Mail::to($student->value('email'))->send(new LiveSessionReminderMail($details));
                                }
                            }
                        }
                        
                    } elseif ($notifId == 2) {
                        if($liveSession->value('second_notification_sent') == 0) {
                            
                        }
                    }
                }
            }
        })->everyMinute();
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
