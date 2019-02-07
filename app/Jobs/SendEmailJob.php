<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $subject;
    private $name;
    private $email;
    private $verification_code;
    private $username;
    private $password;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $name, $email, $verification_code, $username = null, $password = null)
    {
        $this->subject = $subject;
        $this->name = $name;
        $this->email = $email;
        $this->verification_code = $verification_code;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $name = $this->name;
        $email = $this->email;
        $subject = $this->subject;
        Mail::send('auth.verify', ['name' => $this->name, 'verification_code' => $this->verification_code, 'email' => $email, 'username' => $this->username, 'password' => $this->password],
            function ($mail) use ($email, $name, $subject) {
                $mail->from(getenv('MAIL_USERNAME'), "From KU-CLOUD");
                $mail->to($email, $name);
                $mail->subject($subject);
        });
    }
}
