<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AccountActivationInvite extends Notification
{
    use Queueable;

    public function __construct(private readonly string $token)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $url = sprintf(
            '%s/activate-account?token=%s',
            config('app.frontend_url'),
            $this->token
        );

        return (new MailMessage)
            ->subject('Activez votre compte')
            ->greeting("Bonjour {$notifiable->first_name},")
            ->line("Un compte vient d'être créé pour vous sur le système de gestion d'exploitation agricole.")
            ->line('Cliquez sur le bouton ci-dessous pour définir votre mot de passe et activer votre compte.')
            ->action('Activer mon compte', $url)
            ->line('Ce lien est valable 3 jours et ne peut être utilisé qu\'une seule fois.')
            ->line("Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email.");
    }
}
