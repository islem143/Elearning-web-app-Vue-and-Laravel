<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Spatie\UrlSigner\Laravel\UrlSignerFacade;

class VerifyNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $params = [

            'id' => $notifiable->getKey(),
            'hash' => sha1($notifiable->getEmailForVerification()),

        ];
        #$url = UrlSignerFacade::sign('http://localhost:3000/email-verify', now()->addMinutes(30));
        $url="http://localhost:3000/email-verify?";
        foreach ($params as $key => $param) {
            $url .= "$key=$param&";
        }
        
        return (new MailMessage)
            ->line('Email Verification')
            ->action('Verify Email', $url)
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
