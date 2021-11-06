<?php

namespace App\Services;

use App\Services\Dto\NotifyDto;

/**
 * https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c
 * Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
 */
class DiscordWebhookService
{
    private $timeout = 10;

    public function send(NotifyDto $notify): void
    {
        $webhook = env('DISCORD_WEBHOOK');
        $userId = env('DISCORD_USER');

        $hexColor = $notify->isPriority == 1 ? 'E5534B' : 'E3D51B';
        $timestamp = date('c', strtotime('now'));
        $json_data = json_encode([
            'username' => 'notify.bot',
            'avatar_url' => 'https://ru.gravatar.com/userimage/120683956/d8f76293c10405a0006640f3891133d5.jpg',
            'tts' => false,
            'embeds' => [
                [
                    'title' => 'Notification service',
                    'type' => 'rich',
                    'description' => "Message: {$notify->message}

                    Message from services: {$notify->sender} ip:{$notify->ip} by <@{$userId}>",
                    'url' => 'https://uberserver.ru',
                    'timestamp' => $timestamp,
                    'color' => hexdec($hexColor),
                    'footer' => [
                        'text' => 'Notification message',
                    ],
                    'author' => [
                        'name' => 'notify.bot',
                        'url' => 'https://uberserver.ru/'
                    ],
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );

        $ch = curl_init($webhook);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    }
}
