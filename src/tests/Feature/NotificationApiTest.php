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

class NotificationApiTest extends TestCase
{
    public function testGetNotificationHelp()
    {
        $this->json('get', '/api/notifications', [])->assertStatus(200);
    }

    public function testCreateNotificationAndGetAndDelete()
    {
        $_SERVER['REMOTE_ADDR'] = 'none';

        $data = $this->json('post', '/api/notifications', ['who' => 'test', 'message' => 'test']);
        $data->assertStatus(201);
        $result = $data->decodeResponseJson();
        $this->assertEquals('test', $result['who']);
        $this->assertEquals('test', $result['message']);
        $this->assertEquals('none', $result['ip']);

        // check created notification
        $id = $result['id'];
        $data = $this->json('get', "/api/notifications/{$id}", []);
        $data->assertStatus(200);
        $result = $data->decodeResponseJson();
        $this->assertEquals($id, $result['id']);
        $this->assertEquals('test', $result['who']);
        $this->assertEquals('test', $result['message']);
        $this->assertEquals('none', $result['ip']);

        // check update notification
        $data = $this->json('put', "/api/notifications/{$id}", ['who' => 'update_test', 'message' => 'update_test']);
        $data->assertStatus(200);
        $result = $data->decodeResponseJson();
        $this->assertEquals('update_test', $result['who']);
        $this->assertEquals('update_test', $result['message']);

        // check delete notification
        $data = $this->json('delete', "/api/notifications/{$id}", []);
        $data->assertStatus(204);

        $data = $this->json('delete', "/api/notifications/{$id}", []);
        $data->assertStatus(404);
    }
}
