<?php

namespace App\Http\Controllers\Api\V1\Web;

use Validator;
use App\Models\Coin;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;

class CoinController extends BaseController
{

    public function index(Request $request, $promoted = false)
    {
        $query = Coin::query();
        if ($request->has('type')) {
            if ($request->get('type') == 'active') {
                $query->where('is_active', true);
            } else if ($request->get('type') == 'inactive') {
                $query->where('is_active', false);
            }
        }
        if ($request->has('search')) {
            $toSearh = $request->get('search');
            $query->where('name', 'like', '%' . $toSearh . '%')
                ->orWhere('symbol', 'like', '%' . $toSearh . '%')
                ->orWhere('coin_description', 'like', '%' . $toSearh . '%')
                ->orWhere('contract_address', 'like', '%' . $toSearh . '%')
                ->orWhere('network_chain', 'like', '%' . $toSearh . '%');
        }

        if ($request->has('status')) {
            $status = ($request->get('status') == 0) ? false : true;
            $query->where('is_active', $status);
        }

        if ($request->has('listing_status')) {
            $listing_status = $request->get('listing_status');
            $query->where('listing_status', $listing_status);
        }

        if($request->has('sort')) {
            $sortBy = $request->get('sort');
            $query->orderBy($sortBy, 'asc');
        }

        ($promoted) ? $query->where('is_promoted', true) : $query->where('is_promoted', false);
        $coins = $query->get();
        return $this->sendResponse($coins, 'Coins retrieved successfully.');
    }

    public function coinRequests(Request $request)
    {
        $query = Coin::query();
        if ($request->has('search')) {
            $toSearh = $request->get('search');
            $query->where('name', 'like', '%' . $toSearh . '%')
                ->orWhere('symbol', 'like', '%' . $toSearh . '%')
                ->orWhere('coin_description', 'like', '%' . $toSearh . '%')
                ->orWhere('contract_address', 'like', '%' . $toSearh . '%')
                ->orWhere('network_chain', 'like', '%' . $toSearh . '%');
        }

        if ($request->has('listing_status')) {
            $listing_status = $request->get('listing_status');
            $query->where('listing_status', $listing_status);
        }

        if($request->has('sort')) {
            $sortBy = $request->get('sort');
            $query->orderBy($sortBy, 'asc');
        }
        $coins = $query->get();
        $coins = $coins->where('is_active', false);
        return $this->sendResponse($coins, 'Coin requests retrieved successfully.');
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $is_active = false;
        if ($request->has('source')) {
            unset($input['source']);
            $is_active = true;
        }
        $validator = Validator::make($input, [
            'name' => 'required',
            'symbol' => 'required',
            'coin_description' => 'required',
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
        $coin->update(['image' => $imageName, 'is_active' => $is_active]); 
        return $this->sendResponse($coin->toArray(), 'Coin created successfully.');
    }

    public function vote($coinId) {
        $coin = Coin::find($coinId);
        $coin->votes = $coin->votes + 1;
        $coin->save();
        return $this->sendResponse($coin->toArray(), 'Coin voted successfully.');
    }

    public function update(Request $request, $id) {
        $input = $request->all();
        $coin = Coin::find($id);
        $coin->update($input);
        return $this->sendResponse($coin->toArray(), 'Coin updated successfully.');
    }
}
