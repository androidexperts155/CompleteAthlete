<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($userid,$username,$url)
    {

        $this->userid = $userid;
        $this->username = $username;    
        $this->url = $url; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from('no_reply@completeathlete', "CompleteAthlete Team")
        ->subject('Link to reset password')
        ->view('emails.resetpassword')
        ->with(['userid' => $this->userid,'username'=>$this->username,'url'=>$this->url]);
    }
}
