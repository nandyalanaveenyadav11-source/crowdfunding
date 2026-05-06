<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeletionRequestUserConfirmation extends Notification
{
    use Queueable;

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('We have received your account deletion request')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('We are writing to confirm that we have received your request to permanently delete your account.')
            ->line('Your request is now pending review by our administrator.')
            ->line('During this time, your account remains active but flagged for deletion. If you change your mind, please contact us immediately.')
            ->line('Thank you for being a part of our community.');
    }
}
