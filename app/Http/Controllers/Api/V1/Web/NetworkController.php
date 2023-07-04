<?php

namespace App\Http\Controllers\Api\V1\Web;

use App\Http\Controllers\Controller;
use App\Models\NetworkChange;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\BaseController;

class NetworkController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $networks = NetworkChange::get();

        return $this->sendResponse($networks, 'Network retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        $networkChange = new NetworkChange();
        $networkChange->name = $validatedData['name'];
        $networkChange->value = $validatedData['value'];
        $networkChange->save();

        // Return a response or redirect as needed
        return response()->json(['success' => true]);
    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $network = NetworkChange::find($id);

        return $this->sendResponse($network, 'Network retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'value' => 'required',
        ]);

        // Find the network record
        $network = NetworkChange::findOrFail($id);

        // Update the network record
        $network->name = $validatedData['name'];
        $network->value = $validatedData['value'];
        $network->save();

        // Return a response
        return response()->json(['success' => true, 'message' => 'Network updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $networkChange = NetworkChange::find($id);

        if (!$networkChange)
            return;
        $networkChange->delete();

        return $this->sendResponse($networkChange->toArray(), 'Network Change deleted successfully.');
    }
}
