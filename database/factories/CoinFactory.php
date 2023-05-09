<?php

namespace Database\Factories;

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coin>
 */
class CoinFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = \Faker\Factory::create();
        return [
            'name' => $faker->name,
            'image' => $faker->imageUrl(),
            'symbol' => $faker->currencyCode,
            'network_chain' => $faker->word,
            'listing_status' => $faker->randomElement(['listed', 'presale']),
            'launch_date' => Carbon::now(),
            'contract_address' => $faker->uuid,
            'coin_description' => $faker->sentence,
            'votes' => $faker->randomFloat(2, 0, 100000),
            'website_link' => $faker->url,
            'telegram_link' => $faker->url,
            'chart_link' => $faker->url,
            'reddit_link' => $faker->url,
            'twitter_link' => $faker->url,
            'discord_link' => $faker->url,
            'edit_by' => $faker->name,
            'status' => $faker->randomElement(['listed', 'presale']),
            'is_active' => true,
            'is_promoted' => false,
        ];
    }
}
