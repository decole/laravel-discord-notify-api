<?php

namespace Tests;

use App\Services\DiscordWebhookService;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function testSendNotify()
    {
        // add notification
        $this->json('post', '/api/notifications', ['who' => 'test', 'message' => 'test']);

        $service = new DiscordWebhookService();
        $this->assertNull($service->run(true));
    }
}
