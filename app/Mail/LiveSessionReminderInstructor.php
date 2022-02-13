<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LiveSessionReminderInstructor extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $iDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($iDetails)
    {
        $this->iDetails = $iDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reminder for ThinkLit course' . $this->iDetails['course_name'])->markdown('Emails.LiveSessionReminderInstructor');
    }
}
