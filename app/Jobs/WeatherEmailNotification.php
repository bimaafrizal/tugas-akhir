<?php

namespace App\Jobs;

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
        $subject = "Weather Notification";
        foreach ($datas as $data) {
            $message = "Cuaca besok di tempat anda adalah " . $data['cuaca']->weather[0]->description . " dengan suhu " . $data['cuaca']->main->temp . "°C terasa seperti " . $data['cuaca']->main->feels_like  . "°C. Pada tanggal " . $data['cuaca']->dt_txt;
            $this->sendEmail($data['user']->email, $subject, $message);
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