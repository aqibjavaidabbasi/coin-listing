<?php

namespace App\Http\Controllers\Api\V1\Web;

use Validator;
use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;

class CoinController extends BaseController
{

    public function index($promoted = false)
    {
        $query = Coin::query();
        ($promoted) ? $query->where('is_promoted', true) : $query->where('is_promoted', false);
        $coins = $query->where('is_active', true)->get();
        return $this->sendResponse($coins, 'Coins retrieved successfully.');
    }

    public function coinRequests()
    {
        $coins = Coin::where('is_active', false)->get();
        return $this->sendResponse($coins, 'Coin requests retrieved successfully.');
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'symbol' => 'required',
            'coin_description' => 'required',
            'telegram_link' => 'required',
            'contract_address' => 'required',
            'image' => 'required',
            'network_chain' => 'required',
            'listing_status' => 'required',
        ]);
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $coin = Coin::create($input);
        $imageName = 'coin_' . $coin->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/coins', $imageName);
        $coin->update(['image' => $imageName, 'is_active' => false]); 
        return $this->sendResponse($coin->toArray(), 'Coin created successfully.');
    }

    public function vote($coinId) {
        $coin = Coin::find($coinId);
        $coin->votes = $coin->votes + 1;
        $coin->save();
        return $this->sendResponse($coin->toArray(), 'Coin voted successfully.');
    }
}
