<?php

namespace App\Mail;

use GuzzleHttp\Client;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;

class BrevoTransport extends AbstractTransport
{
    protected $apiKey;

    public function __construct(array $config)
    {
        parent::__construct();
        $this->apiKey = $config['key'] ?? config('services.brevo.key');
    }

    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
        
        try {
            $client = new Client();
            $response = $client->post('https://api.brevo.com/v3/smtp/email', [
                'headers' => [
                    'api-key' => $this->apiKey,
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'sender' => [
                        'name' => config('mail.from.name', 'CrowdFund'),
                        'email' => config('mail.from.address', 'nandyalanaveenyadav11@gmail.com'),
                    ],
                    'to' => collect($email->getTo())->map(fn($address) => [
                        'email' => $address->getAddress(),
                        'name' => $address->getName() ?: 'User',
                    ])->toArray(),
                    'subject' => $email->getSubject(),
                    'htmlContent' => $email->getHtmlBody(),
                ],
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Brevo API Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function __toString(): string
    {
        return 'brevo-api';
    }
}
