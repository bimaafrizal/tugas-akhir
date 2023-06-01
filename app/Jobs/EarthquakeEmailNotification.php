<?php

namespace App\Jobs;

use App\Models\Template;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EarthquakeEmailNotification
{
    use Dispatchable;
    protected $users;
    protected $earthquake;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($users, $earthquake, Promise $promise)
    {
        $this->users = $users;
        $this->earthquake = $earthquake;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $users = $this->users;
        $earthquakeData = $this->earthquake;
        $longitude = $earthquakeData['longitude'];
        $latitude = $earthquakeData['latitude'];
        $depth = $earthquakeData['depth'];
        $strength = $earthquakeData['strength'];

        $body = Template::where('id', 2)->first();
        $body = $body->body;

        $subject = "Earthquake Notification";

        foreach ($users as $user) {
            $distance = $user['distance'];
            eval("\$body = \"$body\";");

            $this->sendEmail($user['email_user'], $subject, $body);
        }
    }

    public function sendEmail($receiver, $subject, $body)
    {
        if ($this->isOnline()) {
            $email = [
                'recepient' => $receiver,
                'fromEmail' => 'admin@awasbencana.com',
                'fromName' => 'Awas Bencana',
                'subject' => $subject,
                'body' => $body,
            ];

            Mail::send('pages.email-template', $email, function ($message) use ($email) {
                $message->from($email['fromEmail'], $email['fromName']);
                $message->to($email['recepient']);
                $message->subject($email['subject']);
            });
        }
    }

    public function isOnline($site = "https://www.youtube.com/")
    {
        if (@fopen($site, "r")) {
            return true;
        } else {
            return false;
        }
    }
}
