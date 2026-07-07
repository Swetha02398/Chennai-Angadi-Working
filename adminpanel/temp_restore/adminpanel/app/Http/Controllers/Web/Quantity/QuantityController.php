<?php
namespace App\Http\Controllers\Web\Quantity;

use App\Http\Controllers\Controller;
use App\Models\Quantity;
use Illuminate\Http\Request;

class QuantityController extends Controller
{
    // List all weights
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $status = $request->input('status', '');

        $query = Quantity::latest();

        // Search by name or label
        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%')
                  ->orWhere('label', 'like', '%' . $search . '%');
        }

        // Filter by status (only if status is not empty)
        if ($status !== '' && $status !== null) {
            $query->where('status', (int)$status);
        }

        $quantities = $query->paginate(10);
        return view('quantity.quantity-table', compact('quantities', 'search', 'status'));
    }

    // Show add weight form
    public function create()
    {
        return view('quantity.quantity-create');
    }

    // Store new weight
    public function store(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('quantities')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)
                                 ->where('label', $request->label);
                })
            ],
            'label' => 'required',
        ], [
            'name.unique' => 'Invalid: This Name and Weight combination already exists.',
            'name.required' => 'Name is required.',
            'label.required' => 'Weight is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        Quantity::create([
            'name' => $request->name,
            'label' => $request->label,
            'status' => 1
        ]);

        return redirect()->route('quantity.table')->with('success','Weight added successfully');
    }

    // Show edit form
    public function edit(Quantity $quantity)
    {
        return view('quantity.quantity-edit', compact('quantity'));
    }

    // Update weight
    public function update(Request $request, Quantity $quantity)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('quantities')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)
                                 ->where('label', $request->label);
                })->ignore($quantity->id)
            ],
            'label' => 'required',
        ], [
            'name.unique' => 'Invalid: This Name and Weight combination already exists.',
            'name.required' => 'Name is required.',
            'label.required' => 'Weight is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors()->first())->withInput();
        }

        $quantity->update([
            'name' => $request->name,
            'label' => $request->label
        ]);
        return redirect()->route('quantity.table')->with('success','Weight updated successfully');
    }

    // Delete weight
    public function destroy(Quantity $quantity)
    {
        // Check if this quantity is used in any product variants
        $isUsed = \DB::table('product_variants')->where('quantity_id', $quantity->id)->exists();

        if ($isUsed) {
            return redirect()->back()->with('error', 'This Quantity is already linked to some products and cannot be deleted.');
        }

        $quantity->delete();
        return redirect()->route('quantity.table')->with('success','Weight deleted successfully');
    }
    
    public function toggleStatus($id)
    {
        $quantity = Quantity::findOrFail($id);

        $quantity->status = $quantity->status == 1 ? 0 : 1;
        $quantity->save();

        return redirect()->back()->with('success', 'Quantity status updated');
    }

    public function toggle($id)
    {
        $quantity = Quantity::findOrFail($id);

        $quantity->status = $quantity->status == 1 ? 0 : 1;
        $quantity->save();

        return redirect()->back()->with('success', 'Quantity status updated');
    }
}
