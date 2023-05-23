<?php

namespace App\Jobs;

use GuzzleHttp\Promise\Promise;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EmailSendNotification
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

        $subject = "Flood Notification";
        foreach ($datas as $data) {
            $level = "normal";
            if ($data['level'] ==  1) {
                $level = "Siaga";
            } else if ($data['level'] ==  2) {
                $level = "Waspada";
            } else if ($data['level'] ==  3) {
                $level = "Awas";
            }
            $body = "Informasi Banjir!! ketinggian pada level " . $level . ", jarak anda dengan titik alat adalah " . $data['distance'] .  " km dari unit " . $data['ews_name'] . " cek web awasbencana.website untuk informasi lebih lanjut.";

            $this->sendEmail($data['email_user'], $subject, $body);

            array_push($this->result, [
                'user_id' => $data['user_id'],
            ]);
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
