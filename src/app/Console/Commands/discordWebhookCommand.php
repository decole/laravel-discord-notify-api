<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class discordWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test command notify by discord webhook';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        736282517409366088
//        Галочкин Сергей#6675

        $webhookurl = env("DISCORD_WEBHOOK");

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================

        $json_data = json_encode([
//            "content" => "ololo @everyone  ",
//            "content" => "hehehe <@838048954116997180> ",
            "content" => "Всем спокойной ночи :) ",
            "username" => "notify.bot",
            "tts" => false,

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


        $ch = curl_init( $webhookurl );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec( $ch );
        curl_close( $ch );

        return Command::SUCCESS;
    }
}
