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
        // Register Custom Brevo API Mail Driver
        \Illuminate\Support\Facades\Mail::extend('brevo-api', function (array $config) {
            return new \App\Mail\BrevoTransport(config('services.brevo.key'));
        });

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

        // Force HTTPS in production to fix styling issues
        if (config('app.env') === 'production' || env('FORCE_HTTPS')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
