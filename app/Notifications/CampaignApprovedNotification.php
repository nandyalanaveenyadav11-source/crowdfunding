<?php

namespace App\Notifications;

use App\Models\Campaign;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignApprovedNotification extends Notification
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
            ->subject('Congratulations! Your Campaign is Approved')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your campaign "' . $this->campaign->title . '" has been approved by our team.')
            ->line('It is now live on the platform and ready to receive contributions.')
            ->action('View Your Campaign', route('campaigns.show', $this->campaign))
            ->line('Good luck with your fundraising!');
    }
}
