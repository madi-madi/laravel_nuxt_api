<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;
// use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

use Illuminate\Auth\Notifications\VerifyEmail as Notification ;

class VerifyEmail extends Notification
{

    protected function verificationUrl($notifiable)
    {
        $appUrl = config('app.client_url', config('app.url'));

        $url = URL::temporarySignedRoute(
            'verification.verify', 
            Carbon::now()->addMinutes(60), 
            ['user' => $notifiable->id]
        );

        return str_replace(url('/api'), $appUrl, $url);
    }
}
