<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecommendationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $recDetails;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($recDetails)
    {
        $this->recDetails = $recDetails;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your recommendations for the session '. $this->recDetails['topic'] .' successfully')
                    ->markdown('Emails.RecommendationMail');
    }
}
