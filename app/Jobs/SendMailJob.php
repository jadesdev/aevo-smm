<?php

namespace App\Jobs;

use App\Mail\Sendmail;
use App\Models\Newsletter;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $newsletter;

    protected $email;

    public $tries = 5;

    public $backoff = 600;

    /**
     * Create a new job instance.
     */
    public function __construct(Newsletter $newsletter, $email = null)
    {
        $this->newsletter = $newsletter;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data['view'] = 'email.newsletter';
        $data['subject'] = $this->newsletter->subject;
        $data['email'] = env('MAIL_FROM_ADDRESS');
        $data['message'] = $this->newsletter->content;

        if ($this->email) {
            Mail::to($this->email)->queue(new Sendmail($data));
        } else {
            $emails = User::where('status', 1)->where('blocked', 0)->pluck('email')->toArray();
            foreach ($emails as $email) {
                Mail::to($email)->queue(new Sendmail($data));
            }
        }
    }
}
