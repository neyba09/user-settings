<?php

namespace App\Services;

use App\Models\User;

class ConfirmationServiceFactory
{
    protected $emailService;
    protected $smsService;
    protected $telegramService;

    public function __construct(
        EmailServiceInterface $emailService,
        SmsServiceInterface $smsService,
        TelegramServiceInterface $telegramService
    ) {
        $this->emailService = $emailService;
        $this->smsService = $smsService;
        $this->telegramService = $telegramService;
    }

    public function getService(string $method): ConfirmationServiceInterface
    {
        switch ($method) {
            case 'email':
                return $this->emailService;
            case 'sms':
                return $this->smsService;
            case 'telegram':
                return $this->telegramService;
            default:
                throw new \InvalidArgumentException("Unsupported confirmation method: {$method}");
        }
    }
}
