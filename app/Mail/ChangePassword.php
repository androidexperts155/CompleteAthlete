<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChangePassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($username,$pwd)
    {

       
        $this->username = $username;    
        $this->pwd = $pwd; 
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->from('no_reply@completeathlete', "CompleteAthlete Team")
        ->subject('New password')
        ->view('emails.changepassword')
        ->with(['username'=>$this->username,'pwd'=>$this->pwd]);
    }
}
