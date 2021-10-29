<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DiscordNotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => 10,
            'who' => 'test',
            'message' => 'test',
            'ip' => 'none',
            'is_priority' => 0,
            'sent' => 0,
            'created_at' => '2021-10-29T21:04:56.000000Z',
            'updated_at' => '2021-10-29T21:04:56.000000Z',
        ];
    }
}
