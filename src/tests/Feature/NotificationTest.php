<?php

namespace Tests\Feature;

use App\Models\DiscordNotification;
use Database\Factories\DiscordNotificationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    public function testGetNotificationHelp()
    {
        $this->json('get', '/api/notifications', [])->assertStatus(200);
    }

    public function testCreateNotification()
    {
        $_SERVER['REMOTE_ADDR'] = 'none';
        $notofication = DiscordNotification::factory()->make();

        $data = $this->json('post', '/api/notifications', ['who' => 'test', 'message' => 'test']);
        $data->assertStatus(201);
        $result = $data->decodeResponseJson();
        $this->assertEquals('test', $result['who']);
        $this->assertEquals('test', $result['message']);
        $this->assertEquals('none', $result['ip']);
    }
}
