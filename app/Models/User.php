<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * Override: Send Email Verification directly via Brevo API 
     * to bypass all SMTP/Driver errors.
     */
    public function sendEmailVerificationNotification()
    {
        $url = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            ['id' => $this->getKey(), 'hash' => sha1($this->getEmailForVerification())]
        );

        try {
            $client = new \GuzzleHttp\Client();
            $client->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'api-key' => config('services.brevo.key') ?? env('BREVO_API_KEY'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => config('mail.from.name', 'CrowdFund'),
                        'email' => config('mail.from.address', 'nandyalanaveenyadav11@gmail.com'),
                    ],
                    'to' => [['email' => $this->email, 'name' => $this->name]],
                    'subject' => 'Verify Your CrowdFund Account',
                    'htmlContent' => "
                        <div style='font-family: sans-serif; padding: 20px; color: #333;'>
                            <h2>Welcome to CrowdFund!</h2>
                            <p>Please click the button below to verify your email address and activate your account.</p>
                            <a href='{$url}' style='display: inline-block; padding: 10px 20px; background-color: #4f46e5; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px;'>Verify Email Address</a>
                            <p style='margin-top: 20px; font-size: 0.9em; color: #666;'>If you did not create an account, no further action is required.</p>
                        </div>
                    ",
                ],
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Direct Brevo API Error: ' . $e->getMessage());
        }
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
