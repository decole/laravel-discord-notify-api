<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('who')->nullable();
            $table->string('message', 700);
            $table->tinyInteger('sent', false, true)->default(0);
            $table->tinyInteger('is_priority', false, true)->default(0);
            $table->string('ip', 16)->default('none');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discord_notifications');
    }
}
