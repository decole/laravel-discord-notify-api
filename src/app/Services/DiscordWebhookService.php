<?php

namespace App\Services;

use App\Models\DiscordNotification;
use Illuminate\Database\Eloquent\Collection;

/**
 * https://gist.github.com/Mo45/cb0813cb8a6ebcd6524f6a36d4f8862c
 * Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
 */
class DiscordWebhookService
{
    private string $webhook;

    private string $userId;

    public function __construct()
    {
        $this->webhook = env('DISCORD_WEBHOOK');
        $this->userId = env('DISCORD_USER');
    }

    public function run(): void
    {
        $status = true;
        while ($status) {
            $this->sendCollection();

            sleep(2);
        }
    }

    private function sendCollection(): void
    {
        $collection = $this->getNotify();

        foreach ($collection as $notify) {
            $this->send($notify);

            sleep(0.3);
        }
    }

    private function getNotify(): Collection
    {
        return DiscordNotification::where('sent', 0)->get();
    }

    private function send(?DiscordNotification $notify): void
    {
        $hexColor = $notify->is_priority == 1 ? 'E5534B' : 'E3D51B';
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

                    Message from services: {$notify->who} ip:{$notify->ip} by <@{$this->userId}>",
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

        $ch = curl_init($this->webhook);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);

        $this->changeStatus($notify);
    }

    private function changeStatus(?DiscordNotification $notify): void
    {
        $notify->sent = 1;
        $notify->save();
    }
}
