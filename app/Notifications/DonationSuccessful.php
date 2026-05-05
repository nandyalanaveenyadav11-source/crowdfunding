<?php

namespace App\Notifications;

use App\Models\Donation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DonationSuccessful extends Notification
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
        return (new MailMessage)
            ->subject('Official Contribution Receipt - CrowdFund')
            ->greeting('Thank you for your support, ' . $notifiable->name . '!')
            ->line('This is an official confirmation that your contribution to the campaign "' . $this->donation->campaign->title . '" has been successfully processed.')
            ->line('**Contribution Details:**')
            ->line('Amount: $' . number_format($this->donation->amount))
            ->line('Transaction ID: ' . $this->donation->transaction_id)
            ->line('Date: ' . $this->donation->created_at->format('M d, Y'))
            ->action('View Your Contribution', url('/dashboard'))
            ->line('Your support is instrumental in helping creators bring their ideas to life.')
            ->salutation('Warm regards, \nThe CrowdFund Team');
    }
}
