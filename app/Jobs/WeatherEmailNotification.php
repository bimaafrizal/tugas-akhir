<?php

namespace App\Jobs;

use App\Models\Template;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class WeatherEmailNotification
{
    use Dispatchable;
    protected $data;
    protected $promise;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, Promise $promise)
    {
        $this->data = $data;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas = $this->data;
        $body = Template::where('id', 3)->first();
        $body = $body->body;
        $subject = "Weather Notification";
        foreach ($datas as $data) {
            $cuaca = $data['cuaca']->weather[0]->description;
            $temp = $data['cuaca']->main->temp;
            $feels_like = $data['cuaca']->main->feels_like;
            $dt_txt = $data['cuaca']->dt_txt;

            eval("\$body = \"$body\";");
            
            $this->sendEmail($data['user']->email, $subject, $body);
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