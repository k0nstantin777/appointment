<?php

namespace App\Console\Commands;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Laravel\Artisan\WebhookCommand;

class SetTelegramBotWebhook extends WebhookCommand
{
    /**
     * Setup Webhook.
     * @throws TelegramSDKException
     */
    protected function setupWebhook()
    {
        $params = ['url' => data_get($this->config, 'webhook_url')];
        $certificatePath = data_get($this->config, 'certificate_path', false);

        if ($certificatePath) {
            $params['certificate'] = $certificatePath;
        }

        $webhookConfig = data_get($this->config, 'webhook_params', []);

        $response = $this->telegram->setWebhook(array_merge($params, $webhookConfig));
        if ($response) {
            $this->info('Success: Your webhook has been set!');

            return;
        }

        $this->error('Your webhook could not be set!');
    }
}
