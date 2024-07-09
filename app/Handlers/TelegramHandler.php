<?php

namespace App\Handlers;

use App\Http\Controllers\ConfirmationController;
use App\Services\ConfirmationServiceFactory;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use Illuminate\Support\Facades\App;
use \Illuminate\Support\Stringable;

class TelegramHandler extends WebhookHandler {
    protected ConfirmationServiceFactory $confirmationServiceFactory;

    public function __construct(ConfirmationServiceFactory $confirmationServiceFactory)
    {
        $this->confirmationServiceFactory = $confirmationServiceFactory;
    }

    public function confirm(): void
    {
        $code = rand(11111, 99999);
        $this->reply("Ваш код подтверждения - *{$code}*");

        $confirmationController = App::make(ConfirmationController::class);
        $confirmationController->save($code);
    }

    protected function handleUnknownCommand(Stringable $text): void
    {
        $this->reply('Неизвестная команда');
    }

    protected function handleChatMessage(Stringable $text): void
    {
        $this->reply('Неизвестная команда');
    }
}
