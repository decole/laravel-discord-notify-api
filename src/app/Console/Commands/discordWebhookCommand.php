<?php

namespace App\Console\Commands;

use App\Services\DiscordWebhookService;
use Illuminate\Console\Command;

class discordWebhookCommand extends Command
{
    protected $signature = 'discord:webhook';

    protected $description = 'Command loop process notify by discord webhook';

    private DiscordWebhookService $service;

    public function __construct()
    {
        $this->service = new DiscordWebhookService();

        parent::__construct();
    }

    public function handle(): void
    {
        $this->service->run();
    }
}
