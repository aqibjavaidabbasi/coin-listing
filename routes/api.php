<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Web\CoinController;
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
Route::post('list-coin', [CoinController::class, 'create']);
Route::group(['prefix' => 'coins'], function () {
    Route::get('/requests', [CoinController::class, 'coinRequests']);
    Route::get('/{promoted?}', [CoinController::class, 'index']);
    Route::post('/vote/{id}', [CoinController::class, 'vote']);
});
