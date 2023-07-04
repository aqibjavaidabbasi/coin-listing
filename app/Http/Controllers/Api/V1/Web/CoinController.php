<?php

namespace App\Http\Controllers\Api\V1\Web;

use Validator;
use App\Models\Coin;
use App\Models\CoinDetail;
use Illuminate\Http\Request;
use App\Models\NetworkChange;
use Illuminate\Support\Facades\DB;
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

        if ($request->has('sort')) {
            $sortBy = $request->get('sort');
            $query->orderBy($sortBy, 'asc');
        }

        // ($promoted) ? $query->where('is_promoted', true) : $query->where('is_promoted', false);

        $coins = $query->get();
        return $this->sendResponse($coins, 'Coins retrieved successfully.');
    }

    public function getCoins(Request $request, $promoted = false)
    {
    
        $query = Coin::query();

        // Apply filters
        if ($request->has('type')) {
            if ($request->get('type') == 'active') {
                $query->where('is_active', true);
            } else if ($request->get('type') == 'inactive') {
                $query->where('is_active', false);
            }
        }

        if ($request->has('status')) {
            $status = ($request->get('status') == 0) ? false : true;
            $query->where('is_active', $status);
        }

        if ($request->has('listing_status')) {
            $listing_status = $request->get('listing_status');
            $query->where('listing_status', $listing_status);
        }

        if ($request->has('sort')) {
            $sortBy = $request->get('sort');
            $query->orderBy($sortBy, 'asc');
        }

        // Handle search parameter from the controller
        if ($request->has('search')) {
            $searchText = $request->get('search');
            $query->where(function ($q) use ($searchText) {
                $q->where('name', 'like', '%' . $searchText . '%')
                    ->orWhere('symbol', 'like', '%' . $searchText . '%')
                    ->orWhere('coin_description', 'like', '%' . $searchText . '%')
                    ->orWhere('contract_address', 'like', '%' . $searchText . '%')
                    ->orWhere('network_chain', 'like', '%' . $searchText . '%');
            });
        }

        // Enable pagination
        $perPage = $request->has('per_page') ? $request->get('per_page') : 10;
        $coins = $query->with('coinDetail')->paginate($perPage);

        return response()->json([
            'data' => $coins->toArray(),
            'current_page' => $coins->currentPage(),
            'per_page' => $coins->perPage(),
            'total' => $coins->total(),
            'last_page' => $coins->lastPage(),
        ], 200);
    }

    public function PromotedCoins(Request $request, $promoted = false)
    {
    
        $query = Coin::where('is_promoted', true);

        // Enable pagination
        $perPage = $request->has('per_page') ? $request->get('per_page') : 10;
        $promotedcoins = $query->with('coinDetail')->paginate($perPage);

        return response()->json([
            'data' => $promotedcoins->toArray(),
            'current_page' => $promotedcoins->currentPage(),
            'per_page' => $promotedcoins->perPage(),
            'total' => $promotedcoins->total(),
            'last_page' => $promotedcoins->lastPage(),
        ], 200);
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

        if ($request->has('sort')) {
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
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $coin = Coin::create($input);
        $imageName = 'coin_' . $coin->id . '.' . $request->file('image')->getClientOriginalExtension();
        $request->file('image')->storeAs('public/coins', $imageName);
        $coin->update(['image' => $imageName, 'is_active' => $is_active]);
        return $this->sendResponse($coin->toArray(), 'Coin created successfully.');
    }

    public function vote($coinId)
    {
        $coin = Coin::find($coinId);
        $coin->votes = $coin->votes + 1;
        $coin->save();
        return $this->sendResponse($coin->toArray(), 'Coin voted successfully.');
    }

    public function update(Request $request, $id)
    {

        $input = $request->all();

        $coin = Coin::find($id);
        $coin->update($input);

        if ($request->hasFile('image')) {
            $imageName = 'blog_' . $coin->id . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/coin', $imageName);
            $coin->update(['image' => $imageName]);
        }
        return $this->sendResponse($coin->toArray(), 'Coin updated successfully.');
    }
    public function deleteCoin($id)
    {

        $coin = Coin::find($id);

        if (!$coin)
            return;
        $coin->delete();

        return $this->sendResponse($coin->toArray(), 'Coin deleted successfully.');
    }
    public function edit($id)
    {
        $group = Coin::find($id);
        $networkChain = NetworkChange::join('coins', 'coins.network_chain', '=', 'network_changes.id')
            ->select('network_changes.name')
            ->where('coins.id', $id)
            ->first();

        $group['network_chain_name'] = $networkChain->name;

        return $this->sendResponse($group, 'Coin retrieved successfully.');
    }
}
