<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LiveSessionReminderInstructor extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $details;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reminder for ThinkLit course ' . $this->details['course_name'])->markdown('Emails.LiveSessionReminderInstructor');
        // return $this->subject('Reminder for ThinkLit course' . $this->iDetails['course_name'])->markdown('Emails.LiveSessionReminderInstructor');
    }
}
