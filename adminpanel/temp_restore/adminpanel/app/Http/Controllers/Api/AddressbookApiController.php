<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddressBook;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class AddressbookApiController extends Controller
{
    // 🔹 Get all addresses
    public function index()
    {
        $addresses = AddressBook::with('customer')
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $addresses
        ]);
    }


    // 🔹 Store address
    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone'      => 'required|string|max:15',
            'address'    => 'required|string',
            'city'       => 'required|string|max:100',
            'state'      => 'required|string|max:100',
            'pincode'    => 'required|string|max:10',
            'country'    => 'required|string|max:100',

            // Nullable fields
            'customer_type' => 'nullable|integer',
            'title'         => 'nullable|string|max:100',
            'landmark'      => 'nullable|string|max:255',
            'latitude'      => 'nullable|string|max:50',
            'longitude'     => 'nullable|string|max:50',
            'is_default'    => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $validated['customer_id'] = $user->id; // Always force current user's ID for safety

        $address = AddressBook::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Address created successfully',
            'data' => $address
        ]);
    }

    // 🔹 Update address
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'phone'      => 'required|string|max:15',
            'address'    => 'required|string',
            'city'       => 'required|string|max:100',
            'state'      => 'required|string|max:100',
            'pincode'    => 'required|string|max:10',
            'country'    => 'required|string|max:100',

            // Nullable fields
            'customer_type' => 'nullable|integer',
            'title'         => 'nullable|string|max:100',
            'landmark'      => 'nullable|string|max:255',
            'latitude'      => 'nullable|string|max:50',
            'longitude'     => 'nullable|string|max:50',
            'is_default'    => 'nullable|boolean',
        ]);

        $user = Auth::user();
        $address = AddressBook::where('id', $id)->where('customer_id', $user->id)->firstOrFail();

        $validated['customer_id'] = $user->id; // Ensure it stays linked to current user
        $address->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully',
            'data' => $address
        ]);
    }

    // 🔹 Delete address
    public function destroy($id)
    {
        $user = Auth::user();
        $address = AddressBook::where('id', $id)->where('customer_id', $user->id)->firstOrFail();
        $address->delete();

        return response()->json([
            'status' => true,
            'message' => 'Address deleted successfully'
        ]);
    }

    // 🔹 Get single address by ID
    public function show($id)
    {
    $address = AddressBook::findOrFail($id);

    return response()->json([
        'status' => true,
        'data' => $address
    ]);
   }

//    public function customerAddress($customer_id)
//    {

//     $customer = Customer::with('addresses')->find($customer_id);

//     if(!$customer) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Customer not found'
//         ], 404);
//     }

//     return response()->json([
//         'status' => true,
//         'customer' => $customer, // customer details + addresses inside
//         'address_count' => $customer->addresses->count(),
//         'addresses' => $customer->addresses
//     ]);
//     }
public function customerAddress()
{
    $user = Auth::user(); // Bearer token la irukura user details

    // Check user null ah nu
    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'Unauthorized access'
        ], 401);
    }

    // Assume user model = Customer model
    $customer = Customer::with('addresses')->find($user->id);

    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    return response()->json([
        'status' => true,
        'customer' => $customer,
        'address_count' => $customer->addresses->count(),
        'addresses' => $customer->addresses
    ]);
}
}