<?php

namespace App\Http\Controllers\Web\AddressBook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AddressBook;
use App\Models\Customer;

class AddressController extends Controller
{
    // 🔹 List all addresses
    public function table(Request $request)
    {
        $query = AddressBook::with('customer')->orderByDesc('id');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('address', 'LIKE', '%' . $search . '%')
                  ->orWhere('city', 'LIKE', '%' . $search . '%')
                  ->orWhere('phone', 'LIKE', '%' . $search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination with 10 items per page
        $addresses = $query->paginate(10);
        
        return view('addressbook.address-table', [
            'addresses' => $addresses,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    // 🔹 Show create form
    public function create()
    {
        $customers = Customer::where('status', 1)->get();
        return view('addressbook.address-create', compact('customers'));
    }

    // 🔹 Store new address
    public function store(Request $request)
    {
        $validated = $request->validate([
           'customer_id' => 'required|exists:customers,id',
        // 'name' => 'required|string|max:100',
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|string|max:10',
        'country' => 'required|string|max:100',
     
        ]);

        AddressBook::create($request->all());

        return redirect()->route('addressbook.table')->with('success', 'Address added successfully!');
    }
     
     public function toggleStatus($id)
    {
     $address = AddressBook::findOrFail($id);

     // Toggle 1 ↔ 0
     $address->status = $address->status == 1 ? 0 : 1;
     $address->save();
     return redirect()->route('addressbook.table')->with('success', 'Address status updated successfully!');

    } 

    // 🔹 Show edit form
public function edit($id)
{
    $address = AddressBook::findOrFail($id);
    $customers = Customer::where('status', 1)->get();
    return view('addressbook.address-edit', compact('address', 'customers'));
}

// 🔹 Update existing address
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'customer_id' => 'required|exists:customers,id',
        // 'name' => 'required|string|max:100',
        'phone' => 'required|string|max:15',
        'address' => 'required|string',
        'city' => 'required|string|max:100',
        'state' => 'required|string|max:100',
        'pincode' => 'required|string|max:10',
        'country' => 'required|string|max:100',

        
    ]);

    $address = AddressBook::findOrFail($id);
    $address->update($request->all());

    return redirect()->route('addressbook.table')->with('success', 'Address updated successfully!');
}
   
   public function view($id)
    {
     $address = AddressBook::findOrFail($id);

    return view('addressbook.address-view', compact('address'));
    }


    // 🔹 Delete address
    public function destroy($id)
    {
        $address = AddressBook::findOrFail($id);
        $address->delete();

        return redirect()->route('addressbook.table')->with('success', 'Address deleted successfully!');
    }
}
