<?php

namespace App\Notifications\email;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ModifyEmail extends BaseEmail
{
    /**
     * The callback that should be used to build the mail message.
     *
     * @var \Closure|null
     */
    public static $toMailCallback;
    public $newEmail;


    public function __construct($email)
    {
        parent::__construct();
        $this->newEmail = $email;
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable = null)
    {
        $verificationUrl = $this->verificationUrl();

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        return (new MailMessage)
            ->subject(Lang::getFromJson('Verificación del correo electrónico'))
            ->line("Por favor, verifique el correo electrónico")
            ->action("Verificar el correo electrónico", $verificationUrl);
    }

    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl()
    {
        return URL::temporarySignedRoute(
            'email.modify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            ['newEmail' => $this->newEmail, 'id' => Auth::user()->id]
        );
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
