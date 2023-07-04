<?php

namespace App\Http\Controllers\Api\V1\Web;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;


use App\Http\Controllers\Api\V1\BaseController;

class MarketCapController extends BaseController
{
  
    public function getTotalHolderMarketCap()
    {
       
        $apiKey = '47bcec9f-b943-4295-92ca-97b0e591d94d';
        $apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/categories';

        $ch = curl_init($apiUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-CMC_PRO_API_KEY: ' . $apiKey]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode == 200) {
            $categories = json_decode($response, true);

            foreach ($categories['data'] as $category) {
                $categoryId = $category['id'];

                $apiUrl = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/category';

                $parameters = [
                    'start' => 1,
                    'limit' => 300,
                    'convert' => 'USD',
                    'id' => $categoryId,
                ];

                $queryString = http_build_query($parameters);
                $apiUrl = $apiUrl . '?' . $queryString;

                $ch = curl_init($apiUrl);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['X-CMC_PRO_API_KEY: ' . $apiKey]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                curl_close($ch);

                if ($httpCode == 200) {
                    $listings = json_decode($response, true);

                    foreach ($listings['data']['coins'] as $listing) {
                        $symbol = $listing['symbol'];
                        $slug = $listing['slug'];
                        $cmcRank = $listing['cmc_rank'];
                        $totalSupply = $listing['total_supply'];
                        $price = $listing['quote']['USD']['price'];
                        $volume24h = $listing['quote']['USD']['volume_24h'];
                        $marketCap = $listing['quote']['USD']['market_cap'];

                        // Insert the data into the CoinDetail table
                        DB::table('coin_details')->insert([
                            'symbol' => $symbol,
                            'slug' => $slug,
                            'cmc_rank' => $cmcRank,
                            'total_supply' => $totalSupply,
                            'price' => $price,
                            'volume_24h' => $volume24h,
                            'market_cap' => $marketCap,
                        ]);

                       
                    }
                } else {
                    // Handle the individual category API request error
                    // You can choose to skip the category or handle the error as required
                }
            }

            return response()->json(['success' => 'Insert success categories']);


        } else {
            // Handle the API request error
            return response()->json(['error' => 'Failed to fetch categories'], $httpCode);
        }
    }
}
