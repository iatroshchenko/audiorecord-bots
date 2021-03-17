<?php


namespace App\ExternalServices;

use Longman\TelegramBot\Telegram;

class TelegramService
{
    private Telegram $telegram;

    public function __construct()
    {
        $botUsername = config('telegram.bot_username');
        $botApiKey = config('telegram.bot_api_key');

        if (!$botUsername || !$botApiKey) throw new \DomainException('Bot credentials not set');

        $this->telegram = new Telegram(
            $botApiKey,
            $botUsername
        );
    }

    public function telegram(): Telegram
    {
        return $this->telegram;
    }
}
