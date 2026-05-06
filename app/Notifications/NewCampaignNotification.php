<?php

namespace App\Notifications;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCampaignNotification extends Notification
{
    use Queueable;

    public $campaign;

    public function __construct(Campaign $campaign)
    {
        $this->campaign = $campaign;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Campaign Pending Approval')
            ->greeting('Hello Admin!')
            ->line('A new campaign has been created and is waiting for your approval.')
            ->line('Campaign Title: ' . $this->campaign->title)
            ->line('Creator: ' . $this->campaign->user->name)
            ->action('Review Campaign', url('/admin/dashboard'))
            ->line('Thank you for managing the platform!');
    }
}
