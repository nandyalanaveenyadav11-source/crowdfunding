<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDonationReceived extends Notification
{
    use Queueable;

    protected $donation;

    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $donorName = $this->donation->user ? $this->donation->user->name : 'A community member';
        
        return (new MailMessage)
            ->subject('Official Notification: New Contribution Received')
            ->greeting('Great news, ' . $notifiable->name . '!')
            ->line('Your campaign "' . $this->donation->campaign->title . '" has just received a new official contribution.')
            ->line('**Recent Activity:**')
            ->line('Contributor: ' . $donorName)
            ->line('Amount: $' . number_format($this->donation->amount))
            ->action('Manage Your Campaign', url('/dashboard'))
            ->line('Each contribution brings you one step closer to your goal. Keep sharing your vision!')
            ->salutation('Best regards, \nThe CrowdFund Team');
    }
}
