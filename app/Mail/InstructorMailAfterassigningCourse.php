<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InstructorMailAfterassigningCourse extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    Public $datas;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datas)
    {
        $this->datas = $datas;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('A new course assigned to you')
                    ->markdown('Emails.CourseAssigning');
    }
}
