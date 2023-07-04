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
        Schema::create('coin_details', function (Blueprint $table) {
            $table->id();
            $table->string('symbol');
            $table->string('slug');
            $table->string('cmc_rank')->nullable();
            $table->string('total_supply')->nullable();
            $table->decimal('price', 18, 8)->nullable();
            $table->bigInteger('volume_24h')->nullable();

            $table->string('market_cap')->nullable();
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
        Schema::dropIfExists('coin_details');
    }
};
