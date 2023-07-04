<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Web\CoinController;
use App\Http\Controllers\Api\V1\Web\BlogsController;
use App\Http\Controllers\Api\V1\Web\NetworkController;
use App\Http\Controllers\Api\V1\Web\MarketCapController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Guest Home
Route::post('login', [AuthController::class, 'login']);
Route::get('/market-cap', [MarketCapController::class, 'getTotalHolderMarketCap']);
Route::get('/home-coins', [CoinController::class, 'getcoins']);
Route::get('/promotedCoin', [CoinController::class, 'PromotedCoins']);
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('list-coin', [CoinController::class, 'create']);
    Route::post('blog-create', [BlogsController::class, 'store']);
    Route::post('/blog-update/{id}', [BlogsController::class, 'update']);
    Route::post('/blog-status-update/{id}', [BlogsController::class, 'updateStatus']);
    Route::delete('/blog-delete/{id}', [BlogsController::class, 'delete']);
   
    Route::get('latest-featured-blog', [BlogsController::class, 'LatestFeaturedBlog']);
    Route::get('/blog/{slug}', [BlogsController::class, 'getBlogBySlug']);
    Route::get('latest-featured-blogs', [BlogsController::class, 'LatestFeaturedBlogs']);
    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/list-blogs', [BlogsController::class, 'index']);
        Route::get('/get-all-blog', [BlogsController::class, 'getAllblogs']);
    });


    // Protected routes here...
    Route::get('/profile', [YourController::class, 'profile']);

    Route::get('/requests', [CoinController::class, 'coinRequests']);
    Route::post('/update/{id}', [CoinController::class, 'update']);

    Route::post('/vote/{id}', [CoinController::class, 'vote']);
    Route::delete('/coin-delete/{id}', [CoinController::class, 'deleteCoin']);

    Route::get('/coin-edit/{id}', [CoinController::class, 'edit']);

   
        Route::get('/{promoted?}', [CoinController::class, 'index']);
   
    // notwork
    Route::get('/networks', [NetworkController::class, 'index']);
    Route::post('network-create', [NetworkController::class, 'store']);
    Route::delete('/networks/{id}', [NetworkController::class, 'destroy']);
    Route::get('/networks-edit/{id}', [NetworkController::class, 'edit']);
    Route::post('/networks-update/{id}', [NetworkController::class, 'update']);




    // Route::get('/market-cap', [MarketCapController::class, 'getTotalHolderMarketCap']);
});
