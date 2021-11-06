<?php

namespace Tests\Feature;

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
        $data->assertStatus(200);
        $result = $data->decodeResponseJson();
        $this->assertEquals(true, $result['success']);
    }
}
