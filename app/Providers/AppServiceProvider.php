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
            $to = $message->getTo();
            $recipient = count($to) > 0 ? $to[0]->getAddress() : 'unknown';
            
            \Illuminate\Support\Facades\Log::info("Global Hijacker: Attempting to send email to {$recipient}");

            try {
                $client = new \GuzzleHttp\Client();
                $response = $client->post('https://api.brevo.com/v3/smtp/email', [
                    'headers' => [
                        'api-key' => env('BREVO_API_KEY'),
                        'Content-Type' => 'application/json',
                        'Accept' => 'application/json',
                    ],
                    'json' => [
                        'sender' => [
                            'name' => config('mail.from.name', 'CrowdFund'),
                            'email' => config('mail.from.address', 'naveen.n@spsu.ac.in'),
                        ],
                        'to' => collect($to)->map(fn($address) => [
                            'email' => $address->getAddress(),
                            'name' => $address->getName() ?: 'User',
                        ])->toArray(),
                        'subject' => $message->getSubject(),
                        'htmlContent' => $message->getHtmlBody() ?: $message->getTextBody(),
                    ],
                ]);
                
                \Illuminate\Support\Facades\Log::info("Global Hijacker: Successfully sent to Brevo API for {$recipient}");
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("Global Hijacker FAILED for {$recipient}: " . $e->getMessage());
            }

            return false; // STOP Laravel from trying to send it via SMTP/Log
        });
        

        // Force HTTPS in production
        if (config('app.env') === 'production' || env('FORCE_HTTPS')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
