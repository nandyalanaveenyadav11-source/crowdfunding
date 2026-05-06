<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DeletionRequestNotification extends Notification
{
    use Queueable;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Urgent: Account Deletion Request')
            ->greeting('Hello Admin!')
            ->line('A user has requested to delete their account.')
            ->line('User Name: ' . $this->user->name)
            ->line('User Email: ' . $this->user->email)
            ->action('Review Request', url('/admin/dashboard#deletion-requests'))
            ->line('The account will not be deleted until you confirm it in the Admin Panel.');
    }
}
