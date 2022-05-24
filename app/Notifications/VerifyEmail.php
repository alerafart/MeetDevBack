<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public static $toMailCallback;
     /*public function __construct()
    {
        //
    }*/

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
        $verificationUrl = $this->verificationUrl($notifiable);
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
                    ->subject(Lang::get('Confirmation d\'inscription'))
                    ->greeting(Lang::get('Bienvenue parmis nous '))//.$notifiable->firstname.' !'))
                    ->line(Lang::get('Merci de cliquer sur le bouton ci-dessous pour vérifier ton adresse mail et confirmer la création de ton compte.'))
                    ->action(Lang::get('Vérifier'), $verificationUrl)
                    ->line(Lang::get('Si tu n\'es pas à l\'origine de cette demande, aucune action supplémentaire n\'est requise.'))
                    ->line(Lang::get('Merci de nous rejoindre sur le réseau meetdev !'))
                    ->salutation(new HtmlString('A bientôt,<br><strong>L\'équipe meetdev</strong>'));
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        $token = JWTAuth::fromUser($notifiable);
       // return route('email.verify', [$token], false);
       return 'http://localhost:3000/email/verify/'.$token;
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
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
