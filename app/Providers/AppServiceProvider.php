<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Auth\Notifications\VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Verify Your CrowdFund Account')
                ->greeting('Welcome to CrowdFund!')
                ->line('We\'re excited to have you join our community of creators and supporters.')
                ->line('Please click the button below to verify your email address and activate your account.')
                ->action('Verify Email Address', $url)
                ->line('If you did not create an account, no further action is required.')
                ->salutation('Best regards, \nThe CrowdFund Team');
        });

        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });

        // Global Mail Hijacker: Catch ALL outgoing emails and send via Brevo API
        \Illuminate\Support\Facades\Event::listen(\Illuminate\Mail\Events\MessageSending::class, function ($event) {
            $message = $event->message;
            
            try {
                $client = new \GuzzleHttp\Client();
                $client->post('https://api.brevo.com/v3/smtp/email', [
                    'headers' => [
                        'api-key' => env('BREVO_API_KEY'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'sender' => [
                            'name' => config('mail.from.name', 'CrowdFund'),
                            'email' => config('mail.from.address', 'nandyalanaveenyadav11@gmail.com'),
                        ],
                        'to' => collect($message->getTo())->map(fn($address) => [
                            'email' => $address->getAddress(),
                            'name' => $address->getName() ?: 'User',
                        ])->toArray(),
                        'subject' => $message->getSubject(),
                        'htmlContent' => $message->getHtmlBody() ?: $message->getTextBody(),
                    ],
                ]);
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error('Global Brevo Hijacker Error: ' . $e->getMessage());
            }

            return false; // STOP Laravel from trying to send it via SMTP/Log
        });

        // Force HTTPS in production to fix styling issues
        if (config('app.env') === 'production' || env('FORCE_HTTPS')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
