<?php

namespace App\Http\Controllers;

use App\Services\TelegramBot\TelegramBotService;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Methods\Update;

class TelegramWebhookController extends Controller
{
    use Update;

    public function __invoke(Api $telegramBot, TelegramBotService $telegramBotService)
    {
        $update = $telegramBot->getWebhookUpdate();

        Log::debug('Update Given', $update->toArray());

        try {
            if ($update->hasCommand()) {
                $telegramBot->commandsHandler(true);
                return;
            }

            $handler = $telegramBotService->getHandler($update);
            $handler->handle($update);
        } catch (\Throwable $exception) {
            Log::error($exception->getMessage(), ['exception' => $exception]);

            $handler = $telegramBotService->getErrorHandler();
            $handler->handle($update);
        }
    }
}
