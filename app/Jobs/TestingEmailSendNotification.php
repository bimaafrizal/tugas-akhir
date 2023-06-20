<?php

namespace App\Jobs;

use App\Models\Template;
use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class TestingEmailSendNotification
{
    use Dispatchable;
    protected $datas;
    protected $promise;
    protected $result = [];

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($arr, Promise $promise)
    {
        $this->datas = $arr;
        $this->promise = $promise;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $datas = $this->datas;
        $body = Template::where('id', 1)->first();

        $body2 = $body->body;

        $subject = "Flood Notification";
        for ($i = 0; $i < count($datas); $i++) {
            $body = $body2;
            $distance = 0;
            $ews_name = "";

            $level = "normal";
            if ($datas[$i]['level'] ==  1) {
                $level = "Siaga";
            } else if ($datas[$i]['level'] ==  2) {
                $level = "Waspada";
            } else if ($datas[$i]['level'] ==  3) {
                $level = "Awas";
            }

            $distance = $datas[$i]['distance'];
            $ews_name = $datas[$i]['ews_name'];

            eval("\$body = \"$body\";");

            $this->sendEmail($datas[$i]['email_user'], $subject, $body);
        }

        $this->promise->resolve($this->result);
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
