<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'zip' => 'required|string|max:20',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'locality' => 'required|string',
            'landmark' => 'nullable|string',
            'type' => 'nullable|string|in:home,office,other'
        ]);

        try {
            $address = new Address();
            $address->user_id = Auth::id();
            $address->fill($request->all());
            $address->save();

            return response()->json([
                'success' => true,
                'message' => 'Address saved successfully',
                'address' => $address
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save address: ' . $e->getMessage()
            ], 500);
        }
    }
}