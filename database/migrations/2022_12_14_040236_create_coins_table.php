<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('symbol');
            $table->string('network_chain');
            $table->string('listing_status');
            $table->date('launch_date');
            $table->string('contract_address');
            $table->longText('coin_description');
            $table->float('votes', 12, 2)->default(0);
            $table->string('website_link')->nullable();
            $table->string('telegram_link')->nullable();
            $table->string('chart_link')->nullable();
            $table->string('reddit_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('discord_link')->nullable();
            $table->string('edit_by')->nullable();
            $table->enum('status', ['listed','presale'])->default('listed');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_promoted')->default(false);
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
        Schema::dropIfExists('coins');
    }
};
