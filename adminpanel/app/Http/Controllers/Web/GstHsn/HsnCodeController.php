<?php

namespace App\Http\Controllers\Web\GstHsn;

use App\Http\Controllers\Controller;
use App\Models\HsnCode;
use Illuminate\Http\Request;

class HsnCodeController extends Controller
{
     // ✅ List all HSN codes
    public function table(Request $request)
    {
        $query = HsnCode::latest();
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('code', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%')
                  ->orWhere('category', 'LIKE', '%' . $search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Pagination with 10 items per page
        $hsnCodes = $query->paginate(10);

        return view('hsncode.hsn-table', [
            'hsnCodes' => $hsnCodes,
            'search' => $request->search ?? '',
            'status' => $request->status ?? ''
        ]);
    }

    // ✅ Show Add Form
    public function create()
    {
        return view('hsncode.hsn-create');
    }

    // ✅ Store new record
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:hsn_codes,code',
            'description' => 'nullable|string',
            'gst_rate' => 'required|numeric|min:0|max:100',
            'cgst_rate' => 'nullable|numeric|min:0|max:100',
            'sgst_rate' => 'nullable|numeric|min:0|max:100',
            'igst_rate' => 'nullable|numeric|min:0|max:100',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'status' => 'boolean',
            'category' => 'nullable|string|max:100',
        ]);

        HsnCode::create([
            'code' => $request->code,
            'description' => $request->description,
            'gst_rate' => $request->gst_rate,
            'cgst_rate' => $request->cgst_rate,
            'sgst_rate' => $request->sgst_rate,
            'igst_rate' => $request->igst_rate,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'status' => $request->status ?? true,
            'category' => $request->category,
            'last_updated_by' => auth()->id() ?? null,
        ]);

        return redirect()->route('hsncode.table')->with('success', 'HSN Code added successfully!');
    }

    // ✅ Show Edit Form
    public function edit($id)
    {
        $hsn = HsnCode::findOrFail($id);
        return view('hsncode.hsn-edit', compact('hsn'));
    }

    // ✅ Update existing record
    public function update(Request $request, $id)
    {
        $hsn = HsnCode::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:10|unique:hsn_codes,code,' . $id,
            'description' => 'nullable|string',
            'gst_rate' => 'required|numeric|min:0|max:100',
            'cgst_rate' => 'nullable|numeric|min:0|max:100',
            'sgst_rate' => 'nullable|numeric|min:0|max:100',
            'igst_rate' => 'nullable|numeric|min:0|max:100',
            'effective_from' => 'nullable|date',
            'effective_to' => 'nullable|date|after_or_equal:effective_from',
            'status' => 'boolean',
            'category' => 'nullable|string|max:100',
        ]);

        $hsn->update([
            'code' => $request->code,
            'description' => $request->description,
            'gst_rate' => $request->gst_rate,
            'cgst_rate' => $request->cgst_rate,
            'sgst_rate' => $request->sgst_rate,
            'igst_rate' => $request->igst_rate,
            'effective_from' => $request->effective_from,
            'effective_to' => $request->effective_to,
            'status' => $request->status ?? true,
            'category' => $request->category,
            'last_updated_by' => auth()->id() ?? null,
        ]);

        return redirect()->route('hsncode.table')->with('success', 'HSN Code updated successfully!');
    }

    // ✅ Delete record
    public function destroy($id)
    {
        $hsn = HsnCode::findOrFail($id);
        $hsn->delete();
        return redirect()->route('hsncode.table')->with('success', 'HSN Code deleted successfully!');
    }

    public function view($id)
    {
    $hsn = HsnCode::findOrFail($id); // DB-la irunthu data fetch pannum
    return view('hsncode.hsn-view', compact('hsn')); // view file
    }

}
